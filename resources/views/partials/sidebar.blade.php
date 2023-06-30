 <aside class="main-sidebar sidebar-light-primary elevation-4">
     <!-- Brand Logo -->
     <a href="{{ route('dashboard') }}" class="brand-link bg-primary bg-light">
         <img src="{{ asset('assets/logo/logo.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
         <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 <img src="{{ asset('assets/logo/logo.jpg') }}" class="img-circle elevation-2"
                     alt="User Image">
             </div>
             <div class="info">
                 <a href="javascript:void(0)" class="d-block">{{ auth()->user()->name }}</a>
             </div>
         </div>

         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">

                 <li class="nav-item">
                     <a href="{{ route('dashboard') }}"
                         class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>

                 {{-- @if (auth()->user()->hasRole('admin'))
                     <li class="nav-header">MASTER DATA</li>
                 @else
                     <li class="nav-header">MANAJEMEN DATA</li>
                 @endif --}}

                 @if (Auth()->user()->hasRole('admin'))
                     <li class="nav-item">
                         <a href="{{ route('mahasiswa.index') }}" class="nav-link {{ request()->is('admin/mahasiswa*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-users"></i>
                             <p>
                                 Data Mahasiswa
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('dosen.index') }}" class="nav-link {{ request()->is('admin/dosen*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-user"></i>
                             <p>
                                 Data Dosen
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{route('ruang.index')}}" class="nav-link {{ request()->is('admin/ruang*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-university"></i>
                             <p>
                                 Data Ruang
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{route('kelas.index')}}" class="nav-link {{ request()->is('admin/kelas*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-graduation-cap"></i>
                             <p>
                                 Data Kelas
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('matakuliah.index') }}" class="nav-link {{ request()->is('admin/matakuliah*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-book"></i>
                             <p>
                                 Data Mata Kuliah
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('jadwal.index') }}" class="nav-link {{ request()->is('admin/jadwal*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-calendar-alt"></i>
                             <p>
                                 Data Jadwal
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('perlengkapan.index') }}" class="nav-link {{ request()->is('admin/perlengkapan*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-wrench"></i>
                             <p>
                                 Data Perlengkapan
                             </p>
                         </a>
                     </li>
                     <li class="nav-header">TRANSAKSI</li>
                     <li class="nav-item">
                         <a href="{{ route('peminjaman.index') }}" class="nav-link {{ request()->is('admin/peminjaman*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-sign-in-alt"></i>
                             <p>
                                 Peminjaman
                             </p>
                         </a>
                     </li>
                     <li class="nav-item">
                         <a href="{{ route('pengembalian.index') }}" class="nav-link {{ request()->is('admin/pengembalian*') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-sign-in-alt"></i>
                             <p>
                                 Pengembalian
                             </p>
                         </a>
                     </li>
                 @endif

                 @if (auth()->user()->hasRole('admin'))
                     <li class="nav-header">REPORT</li>
                     <li class="nav-item">
                         <a href="#" class="nav-link">
                             <i class="nav-icon fas fa-file-pdf"></i>
                             <p>
                                 Laporan
                             </p>
                         </a>
                     </li>
                 @else
                     <li class="nav-item">
                         <a href="#" class="nav-link {{ request()->is('karyawan/scan') ? 'active' : '' }}">
                             <i class="nav-icon fas fa-qrcode"></i>
                             <p>
                                 SCAN QR
                             </p>
                         </a>
                     </li>
                 @endif
                 <li class="nav-header">MANAJEMEN AKUN</li>
                 <li class="nav-item">
                     <a href="{{ route('profile.show') }}"
                         class="nav-link {{ request()->is('user/profile') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-user"></i>
                         <p>
                             Profil
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('profile.show.password') }}"
                         class="nav-link {{ request()->is('user/profile/password') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-unlock"></i>
                         <p>
                             Ubah Password
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="javascript:void(0)" class="nav-link"
                         onclick="document.querySelector('#form-logout').submit()">
                         <i class="nav-icon fas fa-sign-in-alt"></i>
                         <p>
                             Logout
                         </p>
                     </a>
                     <form action="{{ route('logout') }}" method="post" id="form-logout">
                         @csrf
                     </form>
                 </li>
             </ul>
         </nav>
         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
