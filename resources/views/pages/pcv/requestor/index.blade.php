@extends('layouts.app')

@section('pagecss')

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
					<li class="breadcrumb-item active" aria-current="page">Petty Cash Voucher</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Petty Cash Vouchers</h4>
		</div>

		<div class="d-md-block mt-4 mt-lg-0">
          	<a class="btn btn-sm pd-x-15 btn-primary btn-uppercase" href="{{ route('requestor.pcv.create') }}">
          		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          		Create PCV
          	</a>
        </div>

	</div>	
    
    @include('components.messages')

	<div class="row">

        <div class="col-lg-12">
            <table id="example1" class="table">

                <thead>
                    <tr>
                        <td>Date</td>
                        <td>PCV No.</td>
                        <td>Description</td>
                        <td>Account</td>
                        <td>Amount</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse( $pcvs as $pcv )
	                  	<tr>	                  		
	                        <td> {{ \Carbon\Carbon::parse($pcv->date_created)->toFormattedDateString() }} </td>
	                        <td> {{ $pcv->pcv_no }} </td>
	                        <td> {{ $pcv->description }} </td>
	                        <td> {{ $pcv->account_name }} </td>
	                        <td> {{ number_format($pcv->amount, 2, '.', ',') }} </td>
	                        <td>
	                        	<span class="badge badge-secondary tx-uppercase"> {{ $pcv->status }} </span>
	                        </td>
	                        <td>
	                        	
	                            <nav class="nav table-options">
                                    <a class="nav-link p-0 pl-2" href="{{ route('requestor.pcv.show', $pcv->id) }}" title="View Request">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>
                                
                                @if($pcv->status == 'saved' || \Str::contains($pcv->status , 'disapproved' ))
                                    <a class="nav-link p-0 pl-2" href="{{ route('requestor.pcv.edit', $pcv->id) }}" title="Edit Request">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                @endif

                                </nav>
                                
	                        </td>
	                  	</tr>
                    @empty
	                	<tr>
	                		<td class="text-center" colspan="7"> No PCV Found </td>
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
				"aaSorting": [],
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