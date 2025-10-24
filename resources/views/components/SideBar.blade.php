 <style>
    .nav-sidebar>.nav-item>.nav-link.active {
    background-color: #00bc8c !important;
    color: #fff;
}
 </style>

 <aside class="main-sidebar sidebar-light-primary  elevation-4" id="newApp">
     <!-- Brand Logo -->
     <a href="{{ route('dashboard') }}" class="brand-link" style="padding: 3px 15px !important;">
         <img src="{{ asset('asset/img/icon.png') }}" alt="Logo" class="me-5"
             style="opacity: .8; height:50px;">
         <span class="brand-text font-weight-bold pl-2"> Alumni  Portal</span>
     </a>

     <!-- Sidebar -->
     <div class="sidebar">
         <!-- Sidebar user panel (optional) -->
         <div class="user-panel mt-3 pb-3 mb-3 d-flex">
             <div class="image">
                 @if (!empty(Auth::user()->image))
                     <img src="{{ asset( Auth::user()->image) }}" class="img-circle elevation-2" alt="{{ Auth::user()->name }}">
                 @else
                     <img src="{{ asset('asset/img/user.jpeg') }}" class="img-circle elevation-2" alt="No Image">
                 @endif
             </div>
             <div class="info">
                 <a href="#" class="d-block">{{ Auth::user()->name }}</a>
             </div>
         </div>



         <!-- Sidebar Menu -->
         <nav class="mt-2">
             <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                 data-accordion="false">
                 <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 {{-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> --}}
                 <li class="nav-item">
                     <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p>
                             Dashboard
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-users"></i>
                         <p>
                             Users
                         </p>
                     </a>
                 </li>
                           <li class="nav-item">
                     <a href="{{ route('assign.alumni') }}" class="nav-link {{ request()->routeIs('assign.alumni') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-users"></i>
                         <p>
                            Assign Alumnis
                         </p>
                     </a>
                 </li>
                    <li class="nav-item">
                     <a href="{{ route('alumni.index') }}" class="nav-link {{ request()->routeIs('alumni.index') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-users"></i>
                         <p>
                             Alumni
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="{{ route('profile') }}" class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                         <i class="nav-icon fas fa-user"></i>
                         <p>
                             My Account
                         </p>
                     </a>
                 </li>
                 <li class="nav-item">


                     <a href="#" class="nav-link d-flex align-items-center"
                         @click="logout">
                         <i class="nav-icon fas fa-sign-out-alt"></i>
                         <p class="mb-0 ms-2">Log out</p>
                     </a>
                 </li>

             </ul>
         </nav>

         <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>
    <script>
        new Vue({
            el: '#newApp',
            data: {
                email: '',
                password: '',
                error: '',
            },
            methods: {
                logout() {
                    axios.post('logout')
                        .then(response => {
                             window.location.href = "{{ route('home') }}";
                        })
                        .catch(error => {
                            this.error =  error.response.data.message;;

                        });
                },
            },
            created() {
                // alert('ok');
            },
        });
    </script>
