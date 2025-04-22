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

# Load pegawai data
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
                "nip": pegawai["nip"]
            }
        except:
            continue

print("Data pegawai berhasil dimuat.")

# Fungsi untuk menentukan tipe absen
def get_tipe_absen():
    now = datetime.now().time()
    if datetime.strptime("14:00", "%H:%M").time() <= now <= datetime.strptime("15:00", "%H:%M").time():
        return "checkin"
    elif datetime.strptime("18:00", "%H:%M").time() <= now <= datetime.strptime("19:00", "%H:%M").time():
        return "checkout"
    return None

# Variabel kontrol
last_absen_time = {}
status_recognition = {}
RECOGNITION_HOLD_TIME = 2  # detik
success_text = ""
success_time = 0

# Mulai kamera
cap = cv2.VideoCapture(0)

while cap.isOpened():
    ret, frame = cap.read()
    if not ret:
        break

    now = time.time()
    tipe = get_tipe_absen()

    frame_height, frame_width = frame.shape[:2]

    if tipe is None:
        cv2.putText(frame, "Di luar jam absen (07:00–08:00 & 16:00–17:00)", (10, 30),
                    cv2.FONT_HERSHEY_SIMPLEX, 0.6, (0, 0, 255), 2)
        status_recognition.clear()
    else:
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
                        nama = pegawai_info_db[pegawai_id]["nama"]
                        nip = pegawai_info_db[pegawai_id]["nip"]

                        if pegawai_id in last_absen_time and now - last_absen_time[pegawai_id] < RECOGNITION_HOLD_TIME:
                            wajah_dikenali = True
                            break

                        payload = {'pegawai_id': pegawai_id, 'tipe': tipe}
                        requests.post(LARAVEL_API_ABSEN, data=payload)
                        last_absen_time[pegawai_id] = now

                        success_text = f"Berhasil {tipe}"
                        success_time = now

                        status_recognition[pegawai_id] = {
                            "timestamp": now,
                            "coords": (x, y, w, h),
                            "nama": nama,
                            "nip": nip
                        }

                        wajah_dikenali = True
                        break

                if not wajah_dikenali:
                    cv2.putText(frame, "Wajah tidak dikenali", (x, y - 10),
                                cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 0, 255), 1)
                    cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 0, 255), 1)

            except Exception as e:
                print("Error mengenali wajah:", e)
                continue

    # Tampilkan kotak hijau dan info pegawai yang dikenali
    for pegawai_id in list(status_recognition):
        data = status_recognition[pegawai_id]
        if now - data["timestamp"] < RECOGNITION_HOLD_TIME:
            x, y, w, h = data["coords"]
            nama = data["nama"]
            nip = data["nip"]

            cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
            cv2.putText(frame, nama, (x, y + h + 20),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 1)
            cv2.putText(frame, nip.upper(), (x, y + h + 38),
                        cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 1)
        else:
            del status_recognition[pegawai_id]

    # Tampilkan teks berhasil absen
    if success_text and time.time() - success_time < 2:
        cv2.putText(frame, success_text, (10, 30),
                    cv2.FONT_HERSHEY_SIMPLEX, 0.7, (0, 255, 0), 2)

    # Tampilkan frame
    cv2.imshow("Absensi Wajah", frame)

    if cv2.waitKey(1) & 0xFF == ord("q"):
        break

cap.release()
cv2.destroyAllWindows()
