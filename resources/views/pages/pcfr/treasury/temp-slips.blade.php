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

	</div>	

	<div class="row">

        <div class="col-lg-12">

            <table id="example1" class="table">

            	<thead>
                    <tr>
                        <th class="wd-10p">Date</th>
                        <th class="wd-20p">Temporary Slip</th>
                        <th class="wd-20p">Account</th>
                        <th class="wd-15p">Description</th>
                        <th class="wd-15p">Amount</th>
                        <th class="wd-10p">Age</th>
                        <th class="wd-10p">Status</th>
                        <th class="wd-10p">Action</th>
                    </tr>
            	</thead>

            	<tbody>

                    @forelse( $temp_slips as $temp_slip )                    

                        <tr>
                            <td>{{ \Carbon\Carbon::parse($temp_slip->date_created)->toFormattedDateString() }}</td>
                            <td>{{ $temp_slip->ts_no }}</td>
                            <td>{{ $temp_slip->account_name }}</td>
                            <td>{{ $temp_slip->description }}</td>
                            <td>{{ $temp_slip->amount }}</td>
                            <td>{{ $temp_slip->created_at->diffForHumans() }}</td>
                            <td>
                            	<span class="badge badge-secondary tx-uppercase">{{ $temp_slip->status }}</span>
                            </td>
                            <td>
                            	<nav class="nav table-options">
	                                <a class="nav-link p-0 pl-2" href="#" title="View Request">
	                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
	                                </a>
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