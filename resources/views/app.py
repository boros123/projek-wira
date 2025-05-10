import cv2
from deepface import DeepFace
import requests
import numpy as np
from datetime import datetime
import time

# API endpoint
LARAVEL_API_PEGAWAI = "http://127.0.0.1:8000/api/pegawai"
LARAVEL_API_ABSEN = "http://127.0.0.1:8000/api/absen"

# Load face detector
face_cascade = cv2.CascadeClassifier(cv2.data.haarcascades + 'haarcascade_frontalface_default.xml')

# Load data pegawai
pegawai_data = requests.get(LARAVEL_API_PEGAWAI).json()
face_encodings_db = {}
pegawai_info_db = {}

for pegawai in pegawai_data:
    image_url = f"http://127.0.0.1:8000/storage/{pegawai['foto_pegawai']}"
    res = requests.get(image_url)
    if res.status_code != 200:
        continue

    img = cv2.imdecode(np.asarray(bytearray(res.content), dtype=np.uint8), cv2.IMREAD_COLOR)
    if img is None:
        continue

    faces = face_cascade.detectMultiScale(img, 1.1, 5)
    if len(faces) > 0:
        x, y, w, h = faces[0]
        face_roi = img[y:y+h, x:x+w]
        try:
            embedding = DeepFace.represent(face_roi, model_name="Facenet")[0]["embedding"]
            face_encodings_db[pegawai["id"]] = embedding
            pegawai_info_db[pegawai["id"]] = {
                "nama": pegawai["nama_pegawai"],
                "nip": pegawai["nip"],
                "jam_kerja": pegawai["jam_kerja"]
            }
        except Exception:
            continue

print("Data pegawai berhasil dimuat.")

def get_tipe_absen(pegawai_id):
    now = datetime.now().time()
    status_pegawai = pegawai_info_db[pegawai_id]["jam_kerja"]

    checkin_awal = datetime.strptime("10:00", "%H:%M").time()
    checkin_akhir = datetime.strptime("10:40", "%H:%M").time()
    checkout_awal = datetime.strptime("11:40", "%H:%M").time()
    checkout_akhir = datetime.strptime("12:20", "%H:%M").time()

    if checkin_awal <= now <= checkin_akhir:
        return "checkin"
    elif checkout_awal <= now <= checkout_akhir:
        return "checkout"
    elif status_pegawai == "lembur" and now >= checkout_awal:
        return "checkout"
    else:
        return None

last_absen_time = {}
status_recognition = {}
RECOGNITION_HOLD_TIME = 2
message_text = ""
message_time = 0

cap = cv2.VideoCapture(0)

while cap.isOpened():
    ret, frame = cap.read()
    if not ret:
        break

    now = time.time()
    frame_height, frame_width = frame.shape[:2]
    gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
    detected_faces = face_cascade.detectMultiScale(gray, 1.1, 5)

    for (x, y, w, h) in detected_faces:
        face_roi = frame[y:y+h, x:x+w]
        try:
            current_embedding = DeepFace.represent(face_roi, model_name="Facenet")[0]["embedding"]
            wajah_dikenali = False

            for pegawai_id, saved_embedding in face_encodings_db.items():
                distance = np.linalg.norm(np.array(current_embedding) - np.array(saved_embedding))
                if distance < 10:
                    tipe = get_tipe_absen(pegawai_id)
                    nama = pegawai_info_db[pegawai_id]["nama"]
                    nip = pegawai_info_db[pegawai_id]["nip"]

                    if tipe is None:
                        now_time = datetime.now().time()

                        # Cek sebelum jam check-in
                        if now_time < datetime.strptime("10:00", "%H:%M").time():
                            message_text = "Belum waktunya absen"
                        
                        # Cek setelah jam check-out
                        elif datetime.strptime("12:20", "%H:%M").time() < now_time and pegawai_info_db[pegawai_id]["jam_kerja"] != "lembur":
                            message_text = "Absen sudah checkout ditutup"
                        
                        # Cek lebih dari waktu check-in tapi sebelum jam check-out
                        elif datetime.strptime("10:00", "%H:%M").time() <= now_time <= datetime.strptime("10:40", "%H:%M").time():
                            message_text = "Tepat waktu check-in"
                        
                        # Cek setelah waktu check-in dan sebelum check-out
                        elif now_time > datetime.strptime("10:40", "%H:%M").time() and now_time < datetime.strptime("11:40", "%H:%M").time():
                            message_text = "Absen sudah checkin ditutup"
                        
                        # Cek lembur
                        elif pegawai_info_db[pegawai_id]["jam_kerja"] == "lembur" and now >= datetime.strptime("13:00", "%H:%M").time():
                            message_text = "Absen Lembur Berhasil"
                        
                        # Cek jika tidak bisa absen
                        else:
                            message_text = "Belum waktunya absen"

                    if pegawai_id in last_absen_time and now - last_absen_time[pegawai_id] < RECOGNITION_HOLD_TIME:
                        wajah_dikenali = True
                        break

                    payload = {'pegawai_id': pegawai_id, 'tipe': tipe}
                    response = requests.post(LARAVEL_API_ABSEN, json=payload)
                    if response.status_code == 200:
                        message_text = f"Berhasil Terdeteksi untuk {nama}"
                    else:
                        message_text = f"Gagal {tipe} untuk {nama}"
                    message_time = now

                    last_absen_time[pegawai_id] = now
                    status_recognition[pegawai_id] = {
                        "timestamp": now,
                        "coords": (x, y, w, h),
                        "nama": nama,
                        "nip": nip
                    }

                    wajah_dikenali = True
                    break

            if not wajah_dikenali:
                cv2.putText(frame, "Wajah tidak dikenali", (x, y-10),
                            cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 0, 255), 1)
                cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 0, 255), 1)

        except Exception:
            continue

    for pegawai_id in list(status_recognition):
        data = status_recognition[pegawai_id]
        if now - data["timestamp"] < RECOGNITION_HOLD_TIME:
            x, y, w, h = data["coords"]
            nama = data["nama"]
            nip = data["nip"]

            cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
            cv2.putText(frame, nama, (x, y+h+20),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 1)
            cv2.putText(frame, nip.upper(), (x, y+h+38),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 1)
        else:
            del status_recognition[pegawai_id]

    if message_text and time.time() - message_time < 2:
        cv2.putText(frame, message_text, (10, 30),
                    cv2.FONT_HERSHEY_SIMPLEX, 0.7, (0, 255, 255), 2)

    cv2.imshow("Absensi Wajah", frame)

    if cv2.waitKey(1) & 0xFF == ord("q"):
        break

cap.release()
cv2.destroyAllWindows()
