@extends('layout.dashboard')
@section('content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-6 ms-1 mb-2">
                    <button class="btn btn-success " style="background-color:  #1100ff" data-toggle="modal" data-target="#buatjabatanModal">Tambah Jabatan
                        Perusahaan</button>

                </div>
            </div>

    <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-uppercase" style="color:  #1100ff">Data Jabatan</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead style="background-color: #1100ff;">
                                            <tr>
                                                <th style="color: white">No</th>
                                                <th style="color: white">Nama Pegawai</th>
                                                <th style="color: white">Deskripsi</th>
                                                <th style="color: white">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($jabatans as $jb)

                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$jb->nama_jabatan}}</td>
                                                <td>{{$jb->deskripsi}}</td>
                                                <td>
                                                    <div class="d-flex ms-4">
                                                        <a href="/get-jabatan/{{$jb->id}}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                                        &nbsp;
                                                        <form method="post" action="">
                                                            @csrf
                                                            <button type="submit" onclick="return confirm('Apakah Anda Yakin Menghapus Data?');"
                                                                class="btn btn-danger  "><i class="bi bi-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>	


            <div class="modal fade" id="buatjabatanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-uppercase" id="exampleModalLabel">Tambah Jabatan</h5>
                            <button class="close h2" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('create-jabatan')}}" method="post" id="form" enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-evenly">
                                    <div class="col-12">
                                        <div class="mb-3  mx-auto ">
                                            <input type="text" class="form-control" name="nama_jabatan" id="nama-jabatan"
                                                placeholder="Nama Jabatan">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3  mx-auto ">
                                            <div class="mb-3">
                                                <textarea class="form-control" name="deskripsi" id="" rows="3" placeholder="Deskripsi"></textarea>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-12 mt-3">
                                        <div class="d-flex justify-content-center">
                                            <Button class="btn btn-success col-12" id="submit" type="submit">Simpan</Button>
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