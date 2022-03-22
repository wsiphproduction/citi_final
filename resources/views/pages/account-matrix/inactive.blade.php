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
					<li class="breadcrumb-item"><a href="{{ route('account-matrix.index') }}">Inactive Matrix</a></li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Inactive Matrix</h4>
		</div>

	</div>	

	<div class="row">

        <div class="col-lg-12">
            <table id="example1" class="table">
                
                <thead>
                    <tr>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Amount</th>
                        <th>Created By</th>
                        <th>Date Created</th>
                        <th>Updated By</th>
                        <th>Date Updated</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse( $matrix as $accnt_matrix )
                        <tr>
                            <td> {{ $accnt_matrix->name }} </td>
                            <td> {{ $accnt_matrix->number }} </td>
                            <td> {{ number_format($accnt_matrix->amount, 2) }} </td>
                            <td> {{ $accnt_matrix->created_by }} </td>
                            <td> {{ $accnt_matrix->created_at->toFormattedDateString() }} </td>
                            <td> {{ $accnt_matrix->updated_by }} </td>
                            <td> {{ $accnt_matrix->updated_at->toFormattedDateString() }} </td>
                            <td>
                                @if($accnt_matrix->status == 1)
                                    <span class="badge badge-primary tx-uppercase">Active</span>
                                @else
                                    <span class="badge badge-secondary tx-uppercase">Inactive</span>
                                @endif
                            </td>
                            <td> 
                                <nav class="nav table-options">
                                    <a class="nav-link p-0 pl-2" href="{{ route('account-matrix.show', $accnt_matrix->id) }}" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>   

                                    <a class="nav-link p-0 pl-2" href="{{ route('account-matrix.edit', $accnt_matrix->id) }}" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>    
                                </nav> 

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center"> No Accout Matrix Found </td>
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
                "aaSorting": [],
    			language: {
    			searchPlaceholder: 'Search',
    			sSearch: '',
    			lengthMenu: 'Show _MENU_ entries',
    			},
    			columnDefs: [
    			{ targets: 7, orderable: false }
    			]
    		});

    		// Select2
    		$('.dataTables_length select').select2({ 
                minimumResultsForSearch: Infinity 
            });
		});
    </script>

@endsection