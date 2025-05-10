@extends('layout.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row">

        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-uppercase"  style="color:  #1100ff">Data Absensi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead style="background-color: #1100ff;">
                            <tr>
                                <th style="color: white">No</th>
                                <th style="color: white">Nama Pegawai</th>
                                <th style="color: white">NIP</th>
                                <th style="color: white">Tanggal</th>
                                <th style="color: white">Checkin</th>
                                <th style="color: white">Checkout</th>
                                <th style="color: white">Keterangan</th>
                                <th style="color: white">Status</th>
                                <th style="color: white">Jam Kerja</th>
                             
                            </tr>
                        </thead>
                        <tbody id="absensi-data">
                           @include('components.table-absensi', ['absensis' => $absensis])
                </tbody>
                </table>
            </div>
        </div>
    </div>


    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchAbsensi() {
            $.ajax({
                url: "/fetchdataabsen",
                type: "GET",
                success: function (data) {
                    $('#absensi-data').html(data);
                }
            });
        }

        // Refresh otomatis setiap 5 detik
        setInterval(fetchAbsensi, 5000);
</script>
