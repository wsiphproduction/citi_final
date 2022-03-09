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

        <li class="nav-item active">
            <a href="{{ route('dashboard') }}" class="nav-link"><i data-feather="home">
            </i> <span>Dashboard</span></a>
        </li>
        

        @hasanyrole('Administrator|Requestor')
            <li class="nav-item with-sub">
                <a href="#" class="nav-link">
                    <i data-feather="file-text"></i> 
                    <span>Request</span>
                </a>
            
                <ul>
                    @can('ts view')
                        <li><a href="{{ route('requestor.ts.index') }}">Temporary Slip</a></li>   
                    @endcan
                    @can('pcv view')
                        <li><a href="{{ route('requestor.pcv.index') }}">PCV</a></li>
                    @endcan
                    @can('pcfr view')
                        <li><a href="{{ route('requestor.pcfr.index') }}">PCFR</a></li>
                    @endcan
                </ul>        
            </li>
        @endhasanyrole

        @hasanyrole('Administrator|TL Approver|Department Head|Division Head')
            <li class="nav-item with-sub">
                
                <a href="#" class="nav-link">
                    <i data-feather="check-circle"></i> 
                    <span>Approval</span>
                </a>           
                <ul>
                    @can('ts view')
                        <li><a href="{{ route('approver.ts.index') }}">Temporary Slip</a></li>
                    @endcan
                    @can('pcv view')
                        <li><a href="{{ route('approver.pcv.index') }}">PCV</a></li>
                    @endcan
                    @can('pcfr view')
                        <li><a href="{{ route('approver.pcfr.index') }}">PCFR</a></li>
                    @endcan
                </ul>
            </li>
        @endhasanyrole

        @hasanyrole('Administrator')
            <li class="nav-item with-sub">
                
                <a href="#" class="nav-link"><i data-feather="briefcase"></i> <span>Treasury</span></a>
            
                <ul>
                
                    <li><a href="treasury-pcfr.html">PCFR</a></li>
                    <li><a href="treasury-for-approval.html">For Approval</a></li>
                    <li><a href="treasury-temporary-slip.html">Temporary Slip</a></li>
                    <li><a href="treasury-pcv.html">PCV</a></li>
                
                </ul>

            </li>
        @endhasanyrole
    
        @hasanyrole('Administrator|Payable Approver')
        <li class="nav-item with-sub">
            
            <a href="#" class="nav-link"><i data-feather="credit-card"></i> <span>Payables</span></a>
        
            <ul>

                <li><a href="#">Approved</a></li>
                <li><a href="payables-for-replenishment.html">For Replenishment</a></li>
                <li><a href="payables-replenished.html">Replenished</a></li>

            </ul>
        
        </li>
        @endhasanyrole

        <li class="nav-item"><a href="#" class="nav-link">
            <i data-feather="clipboard"></i> 
            <span>Report</span></a>
        </li>

        @hasrole('Administrator')

            <li class="nav-label mg-t-25">Maintenance</li>

            <li class="nav-item with-sub">
                <a href="#" class="nav-link"><i data-feather="users"></i> <span>Users</span></a>
                <ul>
                    <li><a href="{{ route('users.index') }}">Manage Users</a></li>
                    <li><a href="{{ route('users.create') }}">Add New User</a></li>
                </ul>
            </li>

            <li class="nav-item with-sub">
                <a href="#" class="nav-link"><i data-feather="user"></i> <span>Account Management</span></a>
                <ul>
                    <li><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li><a href="{{ route('permissions.index') }}">Permissions</a></li>
                    <li><a href="{{ route('modules.index') }}">Modules</a></li>                
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('accounts.index') }}" class="nav-link"><i data-feather="users"></i> <span>Accounts</span></a>
            </li>

            <li class="nav-item">
                <a href="{{ route('vendors.index') }}" class="nav-link"><i data-feather="users"></i> <span>Vendors</span></a>
            </li>

            <li class="nav-item">
                <a href="{{ route('charges.index') }}" class="nav-link"><i data-feather="users"></i> <span>Charges</span></a>
            </li>

            <li class="nav-item with-sub">
                <a href="#" class="nav-link"><i data-feather="user"></i> <span>Branch Management</span></a>
                <ul>
                    <li class="nav-item">
                        <a href="{{ route('branch.index') }}"><span>Branch</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('branch-group.index') }}"><span>Group</span></a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('account-matrix.index') }}" class="nav-link"><i data-feather="users"></i> <span>Account Matrix</span></a>
            </li>

        @endhasrole

    </ul>

    </div>

</aside>