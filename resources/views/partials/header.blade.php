 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <li class="nav-item">
             <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
         </li>
         <li class="nav-item d-none d-sm-inline-block">
             <a class="nav-link animasi-teks text-bold">
                 SISTEM INFORMASI PEMINJAMAN PERANGKAT PEMBELAJARAN
             </a>
         </li>
     </ul>

     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">

         <!-- Messages Dropdown Menu -->
         <li class="nav-item dropdown mr-3">
             <a class="nav-link" data-toggle="dropdown" href="javascript:void(0);">
                 <img src="{{ asset('assets/logo/logo.jpg') }}" class="img-circle" alt="User Image"
                     style="width: 29px ">
                 {{ auth()->user()->name }}
             </a>
             <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                 <a href="javascript:void(0);" onclick="document.querySelector('#form-logout').submit()"
                     class="dropdown-item">
                     Logout
                 </a>

                 <form action="{{ route('logout') }}" method="post" id="form-logout">
                     @csrf
                 </form>
             </div>
         </li>
     </ul>
 </nav>
