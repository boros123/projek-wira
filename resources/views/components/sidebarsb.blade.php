       <!-- Sidebar -->
       <ul class="navbar-nav  sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color:  #1100ff">

           <!-- Sidebar - Brand -->
           <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/home">
               <div class="sidebar-brand-icon rotate-n-15">
                <i class="bi bi-person-bounding-box"></i>
               </div>
               <div class="sidebar-brand-text mx-3">TAWON</div>
           </a>

           <!-- Divider -->
           <hr class="sidebar-divider my-0">

           <!-- Nav Item - Dashboard -->
           <li class="nav-item active">
               <a class="nav-link" href="/">
                   <i class="bi bi-house-door"></i>
                   <span class="text-uppercase">Dashboard</span></a>
           </li>

           <!-- Divider -->
           <hr class="sidebar-divider">

           <!-- Heading -->
           <div class="sidebar-heading">
               Tangkap Wajah Online
           </div>
           <li class="nav-item">
               <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
                   aria-expanded="true" aria-controls="collapseOne">
                <i class="bi bi-person-vcard"></i>
                   <span class="text-uppercase">Jabatan Pegawai</span>
               </a>
               <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
                   <div class="bg-white py-2 collapse-inner rounded">
                       <h6 class="collapse-header text-uppercase">Management</h6>
                       <a class="collapse-item text-uppercase" href="/home/data-jabatan">Data Jabatan</a>
                   </div>
               </div>
           </li>
           <li class="nav-item">
               <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                   aria-expanded="true" aria-controls="collapseTwo">
                <i class="bi bi-person-fill"></i>
                   <span class="text-uppercase">Pegawai</span>
               </a>
               <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                   <div class="bg-white py-2 collapse-inner rounded">
                       <h6 class="collapse-header text-uppercase">Management</h6>

                       <a class="collapse-item text-uppercase" href="/data-pegawai">Data Pegawai</a>

                   </div>
               </div>
           </li>
           <li class="nav-item">
               <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                   aria-expanded="true" aria-controls="collapseThree">
                   <i class="bi bi-table"></i>
                   <span class="text-uppercase">Absensi</span>
               </a>
               <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                   <div class="bg-white py-2 collapse-inner rounded">
                       <h6 class="collapse-header text-uppercase">Management</h6>
                       <a class="collapse-item text-uppercase" href="/home/data-absensi">Data Absensi</a>
                   </div>
               </div>
           </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
                aria-controls="collapseFour">
                <i class="bi bi-table"></i>
                <span class="text-uppercase">Nilai Pegawai</span>
            </a>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header text-uppercase">Management</h6>
                    <a class="collapse-item text-uppercase" href="/home/data-penilaian">Data Nilai</a>
                </div>
            </div>
        </li>

           <!-- Nav Item - Utilities Collapse Menu -->
           {{-- <li class="nav-item">
               <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                   aria-expanded="true" aria-controls="collapseUtilities">
                   <i class="bi bi-cart-plus-fill"></i>
                   <span class="text-uppercase">Product</span>
               </a>
               <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                   data-parent="#accordionSidebar">
                   <div class="bg-white py-2 collapse-inner rounded">
                       <h6 class="collapse-header text-uppercase">Management</h6>
                       <a class="collapse-item text-uppercase" href="/home/data-product">Data Product</a>
                   </div>
               </div>
           </li> --}}




           <!-- Divider -->
           <hr class="sidebar-divider">
           <!-- Sidebar Toggler (Sidebar) -->
           <div class="text-center d-none d-md-inline">
               <button class="rounded-circle border-0" id="sidebarToggle">
               </button>
           </div>

           <!-- Sidebar Message -->


       </ul>
       <!-- End of Sidebar -->
