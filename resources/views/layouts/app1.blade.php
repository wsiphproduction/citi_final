@include('layouts.header')

    <body>
          
        <div class="content ht-100v pd-0">

            <div class="content-header">

                <div class="content-title">
                
                    <h1 class="tx-lg-30 tx-md-24 tx-13 mg-b-0 ml-2">Petty Cash Fund Replenishment</h1>
                
                </div>

                <div class="dropdown dropdown-profile">
                
                    <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static" aria-expanded="false">
                    
                        <div class="tx-color-01"><span>Admin</span> <i data-feather="chevron-down"></i></div>
                    
                    </a>

                    <!-- dropdown-link -->
                    <div class="dropdown-menu dropdown-menu-right tx-13">
                    
                        <h6 class="tx-semibold mg-b-5">{{ auth()->user()->username }}</h6>
                        <p class="mg-b-25 tx-12 tx-color-03">{{ auth()->user()->position }}</p>

                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item">Log out</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    
                    </div> <!-- dropdown-menu -->

                </div>

            </div><!-- content-header -->

            <div class="content-body">
        
                <div class="container-fluid pd-x-0">
                    
                    @yield('content')

                </div>

            </div>

        </div>

        @include('layouts.footer')

    </body>

</html>

    