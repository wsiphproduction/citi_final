@extends('layouts.app')

@section('pagecss')
	
	<link href="{{ asset('lib/prismjs/themes/prism-vs.css') }}" rel="stylesheet">
	<link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">

@endsection

@section('content')
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="request-temporary-slip.html">Accounts</a></li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Accounts</h4>
		</div>

		<div class="d-md-block mt-4 mt-lg-0">
        	<a class="btn btn-sm pd-x-15 btn-primary btn-uppercase" href="{{ route('accounts.create') }}">
                <i data-feather="plus" class="wd-10 mg-r-5"></i> Create Account
            </a>
        </div>

	</div>	

	<div class="row">

        <div class="col-lg-12">
            <table id="example1" class="table">
                
                <thead>
                    <tr>
                        <th class="wd-10p">Name</th>
                        <th class="wd-15p">Username</th>
                        <th class="wd-10p">Email</th>
                        <th class="wd-20p">Status</th>
                        <th class="wd-15p">Date Created</th>
                        <th class="wd-10p text-right">Action</th>
                    </tr>
                </thead>

                <tbody>
                    
                    <tr>
                        <td>XX/XX/XXXX</td>
                        <td>TS-XXXXXXX</td>
                        <td>Account1</td>
                        <td>Sample Description</td>
                        <td>00000.00</td>
                        <td>
                          	<nav class="nav table-options justify-content-end">
	                            <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                              	<i data-feather="external-link"></i>
	                            </a>
                          	</nav>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>XX/XX/XXXX</td>
                        <td>TS-XXXXXXX</td>
                        <td>Account1</td>
                        <td>Sample Description</td>
                        <td>00000.00</td>
                        <td>
                          	<nav class="nav table-options justify-content-end">
	                            <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                              	<i data-feather="external-link"></i>
	                            </a>
                          	</nav>
                        </td>
                    </tr>

                    <tr>
                        <td>XX/XX/XXXX</td>
                        <td>TS-XXXXXXX</td>
                        <td>Account1</td>
                        <td>Sample Description</td>
                        <td>00000.00</td>
                        <td>
                          	<nav class="nav table-options justify-content-end">
	                            <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                              	<i data-feather="external-link"></i>
	                            </a>
                          	</nav>
                        </td>
                    </tr>

                    <tr>
                        <td>XX/XX/XXXX</td>
                        <td>TS-XXXXXXX</td>
                        <td>Account1</td>
                        <td>Sample Description</td>
                        <td>00000.00</td>
                        <td>
                          	<nav class="nav table-options justify-content-end">
	                            <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                              	<i data-feather="external-link"></i>
	                            </a>
                          	</nav>
                        </td>
                    </tr>

                    <tr>
                        <td>XX/XX/XXXX</td>
                        <td>TS-XXXXXXX</td>
                        <td>Account1</td>
                        <td>Sample Description</td>
                        <td>00000.00</td>
                        <td>
                          	<nav class="nav table-options justify-content-end">
	                            <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                              	<i data-feather="external-link"></i>
	                            </a>
                          	</nav>
                        </td>
                    </tr>

                    <tr>
                        <td>XX/XX/XXXX</td>
                        <td>TS-XXXXXXX</td>
                        <td>Account1</td>
                        <td>Sample Description</td>
                        <td>00000.00</td>
                        <td>
                          	<nav class="nav table-options justify-content-end">
	                            <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                              	<i data-feather="external-link"></i>
	                            </a>
                          	</nav>
                        </td>
                    </tr>

                    <tr>
                        <td>XX/XX/XXXX</td>
                        <td>TS-XXXXXXX</td>
                        <td>Account1</td>
                        <td>Sample Description</td>
                        <td>00000.00</td>
                        <td>
                          	<nav class="nav table-options justify-content-end">
	                            <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                              	<i data-feather="external-link"></i>
	                            </a>
                          	</nav>
                        </td>
                    </tr>

                    <tr>
                        <td>XX/XX/XXXX</td>
                        <td>TS-XXXXXXX</td>
                        <td>Account1</td>
                        <td>Sample Description</td>
                        <td>00000.00</td>
                        <td>
                          	<nav class="nav table-options justify-content-end">
	                            <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                              	<i data-feather="external-link"></i>
	                            </a>
                          	</nav>
                        </td>
                    </tr>

                    <tr>
                        <td>XX/XX/XXXX</td>
                        <td>TS-XXXXXXX</td>
                        <td>Account1</td>
                        <td>Sample Description</td>
                        <td>00000.00</td>
                        <td>
                          	<nav class="nav table-options justify-content-end">
	                            <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                              	<i data-feather="external-link"></i>
	                            </a>
                          	</nav>
                        </td>
                    </tr>

                    <tr>
                        <td>XX/XX/XXXX</td>
                        <td>TS-XXXXXXX</td>
                        <td>Account1</td>
                        <td>Sample Description</td>
                        <td>00000.00</td>
                        <td>
                          	<nav class="nav table-options justify-content-end">
	                            <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                              	<i data-feather="external-link"></i>
	                            </a>
                          	</nav>
                        </td>
                    </tr>
                    
                    
                </tbody>

            </table>
        </div>

	</div>

@endsection

@section('pagejs')

	<script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
		$(function(){
			'use strict'

    		$('#example1').DataTable({
    			language: {
    			searchPlaceholder: 'Search',
    			sSearch: '',
    			lengthMenu: 'Show _MENU_ entries',
    			},
    			columnDefs: [
    			{ targets: 7, orderable: false }
    			],
    			dom: 'lf<"dataTables_responsive"t><"dataTables_total d-flex justify-content-end">ip'
    		});

    		// Select2
    		$('.dataTables_length select').select2({ 
                minimumResultsForSearch: Infinity 
            });
    		$(".dataTables_total").append('<label class="tx-bold">Total <input type="number" class="form-control ml-2 tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" value="00000.00" disabled></label>');
		});
    </script>

@endsection