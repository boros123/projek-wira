@extends('layout.dashboard')
@section('content')
            <div class="container-fluid">
               
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-uppercase"  style="color:  #1100ff">Data Penilaian</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Poin</th>
                                        <th>Poin lembur</th>
                                        <th>Total Poin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penilaians as $p)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="text-uppercase">{{ $p->pegawai->nama_pegawai }}</td>
                                                        <td>{{ $p->poin }}</td>
                                                        <td>{{ $p->poin_lembur }}</td>
                                                        <td>{{ $p->poin_lembur + $p->poin }}</td>
                                                        
                                                     
                                                        <td>
                                                            <div class="d-flex ms-4">
                                                                <a href="/get-data-pegawai/{{ $p->id }}" class="btn btn-warning"><i
                                                                        class="bi bi-pencil-square"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    {{-- Off canvas --}}
                                                   
                                        </div>



                                        {{-- Off canvas --}}
                                    @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>

          
            </div>
@endsection