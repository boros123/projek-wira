@extends('layout.dashboard')
@section('content')
        <div class="container-fluid">
            <div class="row">
                <div class="panel col-lg-9  mx-auto p-3 rounded "  style="background-color:  #1100ff">
                <form action="{{route('update-pegawai', $data->id)}}" method="post" id="form" enctype="multipart/form-data">
                    @csrf
                    <div class="row justify-content-evenly">
                        <div class="col-12 col-lg-6">
                            <div class="mb-3  mx-auto ">
                                <label for="" class="text-light">Handphone</label>
                                <input type="number" class="form-control" name="no_telp"  value="{{ $data->no_telp }}" id="no_telp">
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">

                            <div class="mb-3 mx-auto ">
                                <label for="" class="text-light">NIP</label>
                                <input type="text" class="form-control text-uppercase" id="no-order" name="nip"  value="{{ $data->nip }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="mb-3  mx-auto ">
                                <input type="text" class="form-control" name="nama_pegawai"  value="{{ $data->nama_pegawai }}" id="nama-produk" placeholder="Nama Pegawai">
                            </div>
                        </div>

                        <div class="mb-3 col-12 col-lg-6">
                            <select class="form-control" id="exampleFormControlSelect1" name="jabatan_id">
                                <option  value="{{ $data->jabatan_id }}">{{ $data->jabatan->nama_jabatan }}</option>
                                @foreach ($jabatans as $jb)
                                    <option value="{{ $jb->id }}">{{ $jb->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
    <div class="mb-3 col-12 col-lg-6">
        <select class="form-control" id="exampleFormControlSelect1" name="jam_kerja">
            <option value="{{ $data->jam_kerja }}">{{ $data->jam_kerja }}</option>
            <option value="normal">Normal</option>
            <option value="lembur">Lembur</option>
        </select>
    </div>
                        <div class="col-12 mb-3">
                            <div class="mb-3 mx-auto ">
                                <label for="foto-pegawai" class="text-light">Upload Foto Pegawai</label>
                                <input type="file" class="form-control" name="foto_pegawai">
                                <input type="hidden" value="{{ $data->foto_pegawai }}" name="oldpegawai">
                            </div>
                            <button class="btn btn-light" type="button" data-toggle="modal" data-target="#Modal{{ $data->id }}"
                                >Lihat Foto Lama</button>
                        </div>
                        <div class="col-12">
                            <div class="mb-3  mx-auto ">
                                <div class="mb-3">
                                    <textarea class="form-control" name="alamat" id="" rows="3" placeholder="Alamat">{{ $data->alamat }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <div class="d-flex justify-content-center">
                                <Button class="btn btn-light col-12" id="submit" type="submit">Simpan</Button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>

        </div>
        <div class="modal fade" id="Modal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card border border-0 bg-primary bg-opacity-25 shadow rounded p-1">
                            <img src="{{ asset('/storage/' . $data->foto_pegawai) }}" class="img-fluid rounded" alt=""
                                style="max-height: 500px;">
                        </div>
                        <div class="card border border-0 shadow rounded pt-2 mt-2 text-center">
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection