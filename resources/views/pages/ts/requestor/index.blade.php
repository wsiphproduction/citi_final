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
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="{{ route('requestor.ts.index') }}">Temporary Slip</a></li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Unliquidated Temporary Slip</h4>
		</div>

		<div class="d-md-block mt-4 mt-lg-0">
        	<a class="btn btn-sm pd-x-15 btn-primary btn-uppercase" href="{{ route('requestor.ts.create') }}"><i data-feather="plus" class="wd-10 mg-r-5"></i> Create Temporary Slip</a>
        </div>

	</div>	

    @include('components.messages')

	<div class="row">
		
        <div class="col-lg-12">
            <table id="example1" class="table">
                
                <thead>
                    <tr>
                        <td>Date</td>
                        <th>Temporary Slip No.</th>
                        <th>Account</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>                    
                    @forelse( $temporary_slips as $slip )
                        <tr>
                            <td>{{ $slip->date_created->toFormattedDateString() }}</td> 
                            <td>{{ $slip->ts_no }}</td> 
                            <td>{{ $slip->account_name }}</td> 
                            <td>{{ $slip->description }}</td> 
                            <td>{{ $slip->amount }}</td>
                            <td>
                                @if($slip->created_at->diffInDays(\Carbon\Carbon::now()) >= 3 && count($slip->pcv) == 0)
                                    <strong style="color: red;">{{ $slip->created_at->diffForHumans() }}</strong>
                                @else
                                    {{ $slip->created_at->diffForHumans() }}
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-secondary tx-uppercase">{{ $slip->status }}</span>
                            </td>
                            <td>
                                <nav class="nav table-options">
                                    <a class="nav-link p-0 pl-2" href="{{ route('requestor.ts.show', $slip->id) }}" title="View Request">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                    </a>
                                
                                @if($slip->status == 'saved' || \Str::contains($slip->status , 'disapproved' ))
                                    <a class="nav-link p-0 pl-2" href="{{ route('requestor.ts.edit', $slip->id) }}" title="View Request">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon><line x1="3" y1="22" x2="21" y2="22"></line></svg>
                                    </a>
                                @endif

                                </nav>
                            </td>                            
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center"> No Temporary Slip Found </td>
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
    			]
    		});

    		// Select2
    		$('.dataTables_length select').select2({ 
                minimumResultsForSearch: Infinity 
            });
    		
		});
    </script>

@endsection