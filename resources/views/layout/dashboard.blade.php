<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="assets/img/icon.png">
    <title>{{ $title }}</title>
    <!-- Custom fonts for this template -->

    {{-- <link href="{{asset('sb/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css"> --}}
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('sb/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('sb/vendor/fontawesome-free/css/all.min.css') }}">

    <!-- Custom styles for this template -->
    <link href="{{asset('sb/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <style>
        .paginate_button.page-item.active .page-link {
            background-color: #1100ff !important;
            border-color: #1100ff !important;
            color: #fff !important;
        }
    </style>
    <!-- Custom styles for this page -->
    <link href="{{asset('sb/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">


</head>

<body id="page-top">


    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('components.sidebarsb')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            @include('components.header')

            <!-- Main Content -->
            <div id="content">
                @yield('content')
            </div>
            <!-- End of Main Content -->

            @include('sweetalert::alert')
            @include('components.footersb')
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase" id="exampleModalLabel">Yakin untuk logout?</h5>

                </div>
                <div class="modal-body">
                    <form method="POST" action="/logout" id="formlogout">
                        @csrf
                        <button class="btn btn-danger mx-auto col-lg-12 text-uppercase" href="/logout"
                            id="submitlogout">yes</button>
                        <button class="btn btn-secondary mx-auto col-lg-12 text-uppercase mt-3" type="button"
                            data-dismiss="modal">no</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('sb/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('sb/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    
    <!-- Core plugin JavaScript-->
    <script src="{{asset('sb/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    
    <!-- Custom scripts for all pages-->
    <script src="{{asset('sb/js/sb-admin-2.min.js')}}"></script>
    
    <!-- Page level plugins -->
    <script src="{{asset('sb/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('sb/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    
    <!-- Page level custom scripts -->
    <script src="{{asset('sb/js/demo/datatables-demo.js')}}"></script>
  

</body>

</html>
