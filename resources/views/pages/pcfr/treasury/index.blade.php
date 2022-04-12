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
					<li class="breadcrumb-item active">Petty Cash Fund Replenishment</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Petty Cash Fund Replenishments</h4>
		</div>

		@if(auth()->user()->position != 'Treasury Head' || auth()->user()->position != 'treasury head')
		
			<div class="d-md-block mt-4 mt-lg-0">
	            <a class="btn btn-sm pd-x-15 btn-primary btn-uppercase" href="{{ route('treasury.pcfr.create') }}">
	            	<i data-feather="plus" class="wd-10 mg-r-5"></i> Create PCFR
	            </a>
	        </div>

        @endif

	</div>	

	@include('components.messages')

	<div class="row">

        <div class="col-lg-12">

            <table id="example1" class="table">

            	<thead>
                    <tr>
                        <th class="wd-10p">Date</th>
                        <th class="wd-20p">PCFR No.</th>
                        <th class="wd-20p">Batch ID</th>
                        <th class="wd-15p">Vendor</th>
                        <th class="wd-15p">Requested By</th>
                        <th class="wd-10p">Status</th>
                        <th class="wd-10p">Action</th>
                    </tr>
            	</thead>

            	<tbody>

                    @forelse( $pcfr as $pcfrr )                    

                        <tr>
                            <td>{{ \Carbon\Carbon::parse($pcfrr->date_created)->toFormattedDateString() }}</td>
                            <td>{{ $pcfrr->pcfr_no }}</td>
                            <td>{{ $pcfrr->batch_no }}</td>
                            <td>{{ $pcfrr->vendor }}</td>
                            <td>{{ $pcfrr->user->username }}</td>
                            <td>
                            	<span class="badge badge-secondary tx-uppercase">{{ $pcfrr->status }}</span>
                            </td>
                            <td>
                            	<nav class="nav table-options">
	                                <a class="nav-link p-0 pl-2" href="{{ route('treasury.pcfr.show-pcfr', $pcfrr->id) }}" 
	                                	title="View Request">
	                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
	                                </a>
	                                @if(!in_array($pcfrr->status, ['post to ebs', 'submitted', 'approved', 'for replished']))
	                                    <a class="nav-link p-0 pl-2" href="{{ route('treasury.pcfr.edit', $pcfrr->id) }}" title="Edit Request">
	                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
	                                    </a>
	                                @endif
	                            </nav>
                            </td>
                        </tr>

                    @empty
                    	<tr>
                    		<td class="text-center" colspan="7"> No PCFR Found </td>
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
    <script>
		$(function(){
			'use strict'

			$('#example1').DataTable({
				language: {
				searchPlaceholder: 'Search',
				sSearch: '',
				lengthMenu: 'Show _MENU_ entries',
				},
				columnDefs: [
				{ targets: 6, orderable: false }
				]
			});

			// Select2
			$('.dataTables_length select').select2({ 
				minimumResultsForSearch: Infinity 
			});
		});
    </script>


@endsection