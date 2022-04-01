<aside class="aside aside-fixed">

    <div class="aside-header">
        
        <a href="{{ route('dashboard') }}" class="aside-logo">
            <img src="{{ asset('img/logo (1).png') }}" alt="Citihardware logo">
        </a>
        
        <a href="" class="aside-menu-link">
        <i data-feather="menu"></i>
        <i data-feather="x"></i>
        
        </a>
    
    </div>

    <div class="aside-body">

    <ul class="nav nav-aside">

        <li class="nav-item @if(request()->routeIs('dashboard')) active @endif">
            <a href="{{ route('dashboard') }}" class="nav-link"><i data-feather="home">
            </i> <span>Dashboard</span></a>
        </li>

        @hasanyrole('Requestor|SSC Requestor')
            <li class="nav-item with-sub @if(request()->routeIs('requestor*')) show @endif">
                <a href="#" class="nav-link">
                    <i data-feather="file-text"></i> 
                    <span>Request</span>
                </a>
            
                <ul>
                    @can('ts view')
                        <li class="nav-item @if(request()->routeIs('requestor.ts*')) active @endif"><a href="{{ route('requestor.ts.index') }}">Temporary Slip</a></li>   
                    @endcan
                    @can('pcv view')
                        <li class="nav-item @if(request()->routeIs('requestor.pcv*')) active @endif"><a href="{{ route('requestor.pcv.index') }}">PCV</a></li>
                    @endcan
                    @if(auth()->user()->position != 'Administrator' && auth()->user()->getUserAssignTo() != 'SSC')
                        @can('pcfr view')
                            <li class="nav-item @if(request()->routeIs('requestor.pcfr*')) active @endif"><a href="{{ route('requestor.pcfr.index') }}">PCFR</a></li>
                        @endcan
                    @endif
                </ul>        
            </li>
        @endhasanyrole

        @hasanyrole('TL Approver|Department Head|Division Head')
            <li class="nav-item with-sub @if(request()->routeIs('approver*')) show @endif">
                
                <a href="#" class="nav-link">
                    <i data-feather="check-circle"></i> 
                    <span>Approval</span>
                </a>           
                <ul>
                    @can('ts view')
                        <li class="nav-item @if(request()->routeIs('approver.ts*')) active @endif"><a href="{{ route('approver.ts.index') }}">Temporary Slip</a></li>
                    @endcan

                    @can('pcv view')
                        <li class="nav-item @if(request()->routeIs('approver.pcv*')) active @endif"><a href="{{ route('approver.pcv.index') }}">PCV</a></li>
                    @endcan
                
                    @hasanyrole('TL Approver|Division Head')
                        @can('pcfr view')
                            <li class="nav-item @if(request()->routeIs('approver.pcfr*')) active @endif"><a href="{{ route('approver.pcfr.index') }}">PCFR</a></li>
                        @endcan
                    @endhasanyrole

                 </ul>
            </li>
        @endhasanyrole

        @hasanyrole('Treasury Staff|Treasury Head')
            <li class="nav-item with-sub @if(request()->routeIs('treasury*')) show @endif">
                
                <a href="#" class="nav-link"><i data-feather="briefcase"></i> <span>Treasury</span></a>
            
                <ul>                    
                    <li class="nav-item nav-item @if(request()->routeIs('treasury.pcfr.index')) active @endif">
                        <a href="{{ route('treasury.pcfr.index') }}">PCFR</a>
                    </li>
                    <li class="nav-item nav-item @if(request()->routeIs('treasury.pcfr.for-approval')) active @endif">
                        <a href="{{ route('treasury.pcfr.for-approval') }}">For Approval</a>
                    </li>
                    <li class="nav-item nav-item @if(request()->routeIs('treasury.pcfr.temp-slips')) active @endif">
                        <a href="{{ route('treasury.pcfr.temp-slips') }}">Temporary Slip</a>
                    </li>
                    <li class="nav-item nav-item @if(request()->routeIs('treasury.pcfr.pcvs')) active @endif">
                        <a href="{{ route('treasury.pcfr.pcvs') }}">PCV</a>
                    </li>
                </ul>

            </li>
        @endhasanyrole
    
        @hasanyrole('Payable Approver')
            <li class="nav-item with-sub @if(request()->routeIs('payable*')) show @endif">
                
                <a href="#" class="nav-link"><i data-feather="credit-card"></i> <span>Payables</span></a>
            
                <ul>
                    <li class="nav-item @if(request()->routeIs('payable.pcfr.index')) active @endif">
                        <a href="{{ route('payable.pcfr.index') }}">Approved</a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('payable.pcfr.for-replenished')) active @endif">
                        <a href="{{ route('payable.pcfr.for-replenished') }}">For Replenishment</a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('payable.pcfr.replenished')) active @endif">
                        <a href="{{ route('payable.pcfr.replenished') }}">Replenished</a>
                    </li>
                </ul>
            
            </li>
        @endhasanyrole

        @hasanyrole('Audit')
            <li class="nav-item with-sub @if(request()->routeIs('audit*')) show @endif">
                
                <a href="#" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                    <span>Audit</span>
                </a>
        
                <ul>
                    @can('ts view')
                        <li class="nav-item @if(request()->routeIs('audit.ts.index')) active @endif">
                            <a href="{{ route('audit.ts.index') }}">Temporary Slip</a>
                        </li>
                    @endcan

                    @can('pcv view')
                        <li class="nav-item @if(request()->routeIs('audit.pcv.index')) active @endif">
                            <a href="{{ route('audit.pcv.index') }}">PCV</a>
                        </li>
                    @endcan
                
                    @can('pcfr view')
                        <li class="nav-item @if(request()->routeIs('audit.pcfr.index')) active @endif">
                            <a href="{{ route('audit.pcfr.index') }}">PCFR</a>
                        </li>
                    @endcan
                </ul>
            
            </li>
        @endhasanyrole

        @hasanyrole('Administrator')

            <li class="nav-item @if(request()->routeIs('admin.ts.index')) active @endif">
                <a href="{{ route('admin.ts.index') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                    <span>Temporary Slip</span>
                </a>
            </li>

            <li class="nav-item @if(request()->routeIs('admin.pcv.index')) active @endif">
                <a href="{{ route('admin.pcv.index') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                    <span>PCV</span>
                </a>
            </li>

            <li class="nav-item @if(request()->routeIs('admin.pcfr.index')) active @endif">
                <a href="{{ route('admin.pcfr.index') }}" class="nav-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    <span>PCFR</span>
                </a>
            </li>
      
        @endhasanyrole

        @hasanyrole('Administrator')
            <li class="nav-item @if(request()->routeIs('reports.index')) active @endif">
                <a href="{{ route('reports.index') }}" class="nav-link">
                    <i data-feather="clipboard"></i> 
                    <span>Report</span>
                </a>
            </li>
        @endhasanyrole

        @hasrole('Administrator|Maintenance|Audit')

            <li class="nav-label mg-t-25">Maintenance</li>

                @can('user view')
                <li class="nav-item with-sub">
                    <a href="#" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Manage Users
                    </a>
                    <ul>
                        <li><a href="{{ route('users.index') }}">Active Users</a></li>
                        <li><a href="{{ route('users.inactive') }}">Inactive Users</a></li>                                   
                    </ul>
                </li>
                @endcan
                
                @can('account view')
                <li class="nav-item with-sub">
                    <a href="#" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Account Management</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('roles.index') }}">Roles</a></li>
                        <li><a href="{{ route('permissions.index') }}">Permissions</a></li>
                        <li><a href="{{ route('modules.index') }}">Modules</a></li>                
                    </ul>
                </li>
                @endcan
            

            {{-- <li class="nav-item">
                <a href="{{ route('accounts.index') }}" class="nav-link"><i data-feather="users"></i> <span>Accounts</span></a>
            </li> --}}

                @can('vendor view')
                <li class="nav-item with-sub">
                    <a href="#" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Manage Vendors</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('vendors.index') }}">Active Vendors</a></li>
                        <li><a href="{{ route('vendors.inactive') }}">Inactive Vendors</a></li>                                   
                    </ul>
                </li>
                @endcan
                
                @can('charge view')
                <li class="nav-item with-sub">
                    <a href="#" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span>Manage Charges</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('charges.index') }}">Active Charges</a></li>
                        <li><a href="{{ route('charges.inactive') }}">Inactive Charges</a></li>                                   
                    </ul>
                </li>
                @endcan
                
                @can('branch view')
                <li class="nav-item with-sub">
                    <a href="#" class="nav-link"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg><span>Branch Management</span></a>
                    <ul>
                        <li class="nav-item">
                            <a href="{{ route('branch.index') }}"><span>Branch</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('branch-group.index') }}"><span>Group</span></a>
                        </li>
                    </ul>
                </li>
                @endcan
                
                @can('matrix view')
                <li class="nav-item with-sub">
                    <a href="#" class="nav-link">                    
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slack"><path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"></path><path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path><path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"></path><path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"></path><path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"></path><path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"></path><path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"></path><path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"></path></svg>
                        <span>Account Matrix</span>
                    </a>
                    <ul>
                        <li class="nav-item">
                            <a href="{{ route('account-matrix.index') }}"><span>Active Matrix</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('account-matrix.inactive') }}"><span>Inactive Matrix</span></a>
                        </li>
                    </ul>
                </li>
                @endcan
            

        @endhasrole

    </ul>

    </div>

</aside>