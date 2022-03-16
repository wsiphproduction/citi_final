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

	</div>	
    
    @include('components.messages')

	<div class="row">

        <div class="col-lg-12">
            <table id="example1" class="table">

                <thead>
                    <tr>
                        <td>Date</td>
                        <td>PCV No.</td>
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
	                        <td> {{ $pcv->account_name }} </td>
	                        <td> {{ $pcv->amount }} </td>
	                        <td>
	                        	<span class="badge badge-secondary tx-uppercase"> {{ $pcv->status }} </span>
	                        </td>
	                        <td>
	                        	<nav class="nav table-options">
	                                <a class="nav-link p-0 pl-2" href="{{ route('approver.pcv.show', $pcv->pcv_no) }}" title="View Request">
	                                    <i data-feather="external-link"></i>
	                                </a>
	                            </nav>
	                        </td>
	                  	</tr>
                    @empty
	                	<tr>
	                		<td class="text-center" colspan="6"> No PCV Found </td>
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
				{ targets: 5, orderable: false }
				],
				dom: 'lf<"dataTables_responsive"t>ip'
			});
		});
    </script>


@endsection