@extends('layout.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 ms-1 mb-2">
                <button class="btn btn-success " data-toggle="modal" data-target="#buatkategoriModal"  style="background-color:  #1100ff">Tambah Data Pegawai</button>

            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-uppercase"  style="color:  #1100ff">Data Pegawai</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th>Alamat</th>
                                <th>Jam Kerja</th>
                                <th>Total Poin</th>
                                <th>Foto Pegawai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawais as $p)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-uppercase">{{ $p->nama_pegawai }}</td>
                                                <td class="text-uppercase">{{ $p->nip }}</td>
                                                <td>{{ $p->jabatan->nama_jabatan }}</td>
                                                <td>{{ $p->alamat }}</td>
                                                <td>{{ $p->jam_kerja }}</td>
                                                <td>{{ $p->penilaian->sum('poin_lembur')+ $p->penilaian->sum('poin') }}</td>
                                                <td>

                                                    <button class="btn btn-success" type="button" data-toggle="modal"
                                                        data-target="#Modal{{ $p->id }}"  style="background-color:  #1100ff">Lihat</button>
                                                </td>
                                                <td>
                                                    <div class="d-flex ms-4">
                                                        <a href="/get-data-pegawai/{{ $p->id }}" class="btn btn-warning"><i
                                                                class="bi bi-pencil-square"></i></a>
                                                        &nbsp;
                                                        <form method="post" action="{{route('hapus-data-pegawai', $p->id)}}">
                                                            @csrf
                                                            <button type="submit"
                                                                onclick="return confirm('Apakah Anda Yakin Menghapus Data?');"
                                                                class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- Off canvas --}}
                                            <div class="modal fade" id="Modal{{ $p->id }}" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-uppercase" id="exampleModalLabel">{{$p->nama_pegawai}}</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card border border-0 bg-primary bg-opacity-25 shadow rounded p-1">
                                                                <img src="{{ asset('/storage/' . $p->foto_pegawai) }}" class="img-fluid rounded" alt="" style="max-height: 500px;">
                                                            </div>
                                                            <div class="card border border-0 shadow rounded pt-2 mt-2 text-center">
                                                                <p></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                </div>



                                {{-- Off canvas --}}
                            @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="buatkategoriModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="exampleModalLabel">Buat Data Pegawai</h5>
                    <button class="close h2" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('create-pegawai')}}" method="post" id="form" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-evenly">
                            <div class="col-12">
                                <div class="mb-3  mx-auto ">
                                    <input type="text" class="form-control" name="nama_pegawai" id="nama-produk"
                                    placeholder="Nama Pegawai">
                                </div>
                            </div>
                            <div class="col-12">

                                <div class="mb-3  mx-auto ">
                                    <label for="">NIP</label>
                                    <input type="text" class="form-control form-control-sm text text-uppercase" id="no-order" name="nip"
                                        value="{{ $nip }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <select class="form-control" id="exampleFormControlSelect1" name="jabatan_id">
                                    @foreach ($jabatans as $jb)
                                    <option value="{{ $jb->id }}">{{ $jb->nama_jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="mb-3  mx-auto ">
                                <label for="">Handphone</label>
                                    <input type="number" class="form-control" name="no_telp" id="no_telp" >
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3 mx-auto ">
                                    <label for="foto-pegawai">Upload Foto Pegawai</label>
                                    <input type="file" class="form-control" name="foto_pegawai">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3  mx-auto ">
                                    <div class="mb-3">
                                        <textarea class="form-control" name="alamat" id="" rows="3" placeholder="Alamat"></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-12 mt-3">
                                <div class="d-flex justify-content-center">
                                    <Button class="btn btn-primary col-12" id="submit" type="submit">Simpan</Button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection