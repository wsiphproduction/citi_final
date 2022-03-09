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
					<li class="breadcrumb-item"><a href="request-temporary-slip.html">Vendors</a></li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Vendors</h4>
		</div>

		<div class="d-md-block mt-4 mt-lg-0">
        	<a class="btn btn-sm pd-x-15 btn-primary btn-uppercase" href="{{ route('vendors.create') }}">
                <i data-feather="plus" class="wd-10 mg-r-5"></i> Create Vendor
            </a>
        </div>

	</div>	

	<div class="row">

        <div class="col-lg-12">
            <table id="example1" class="table">
                
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Created By</th>
                        <th>Date Created</th>
                        <th>Updated By</th>
                        <th>Date Updated</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse( $vendors as $vendor )
                        <tr>
                            <td> {{ $vendor->name }} </td>
                            <td> {{ $vendor->address }} </td>
                            <td> {{ $vendor->created_by }} </td>                            
                            <td> {{ $vendor->created_at->toFormattedDateString() }} </td>
                            <td> {{ $vendor->updated_by }} </td>
                            <td> {{ $vendor->updated_at->toFormattedDateString() }} </td>
                            <td> 
                                <a href="{{ route('vendors.edit', $vendor->id) }}" > Edit </a>
                                <a href="javascript:void(0);" > Delete </a> 
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center"> No Vendors Found </td>
                        </tr>
                    @endforelse
                                                        
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