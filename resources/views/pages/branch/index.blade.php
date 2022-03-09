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
					<li class="breadcrumb-item"><a href="request-temporary-slip.html">Branch</a></li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Branch</h4>
		</div>

		<div class="d-md-block mt-4 mt-lg-0">
        	<a class="btn btn-sm pd-x-15 btn-primary btn-uppercase" href="{{ route('branch.create') }}">
                <i data-feather="plus" class="wd-10 mg-r-5"></i> Create Branch
            </a>
        </div>

	</div>	
    @include('components.messages')
	<div class="row">

        <div class="col-lg-12">
            <table id="example1" class="table">
                
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Budget</th>
                        <th>Created By</th>
                        <th>Date Created</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse( $branch as $bran )
                        <tr>
                            <td> {{ $bran->name }} </td>
                            <td> {{ number_format($bran->budget, 2) }} </td>
                            <td> {{ $bran->created_by }} </td>
                            <td> {{ $bran->created_at->toFormattedDateString() }} </td>
                            <td>
                                @if($bran->status == 1)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </td>
                            <td> 
                                <a href="{{ route('branch.edit', $bran->id) }}" > Edit </a>
                                <a href="javascript:void(0);" > Delete </a> 
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center"> No Branch Found </td>
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
    		

            


		});
    </script>

@endsection