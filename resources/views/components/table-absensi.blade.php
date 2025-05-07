@foreach ($absensis as $a)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td class="text-uppercase">{{$a->pegawai->nama_pegawai}}</td>
        <td class="text-uppercase">{{$a->pegawai->nip}}</td>
        <td>{{$a->tanggal}}</td>
        <td>{{$a->checkin}}</td>
        <td>{{$a->checkout}}</td>
        <td>{{$a->keterangan}}</td>
        <td>{{$a->status}}</td>
        {{-- <td>{{$a->jam_kerja}}</td> --}}
        <td>
            <div class="d-flex ms-4">
                <a href="/get-absen/{{ $a->id }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
            </div>
        </td>
    </tr>
    {{-- Off canvas --}}

    </div>



    {{-- Off canvas --}}
@endforeach