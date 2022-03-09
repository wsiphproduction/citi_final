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
					<li class="breadcrumb-item"><a href="#">Petty Cash Voucher</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Petty Cash Vouchers</h4>
		</div>

		<div class="d-md-block mt-4 mt-lg-0">
          	<a class="btn btn-sm pd-x-15 btn-primary btn-uppercase" href="{{ route('pcv.create') }}">
          		<i data-feather="plus" class="wd-10 mg-r-5"></i> Create PCV
          	</a>
        </div>

	</div>	
    
    @include('components.messages')

	<div class="row">

		<div class="col-lg-12">
          	<div class="btn-group mg-b-30 request-nav" role="group" aria-label="Request Navigation">
            	<a href="request-temporary-slip.html" class="btn btn-sm btn-white btn-uppercase bd-gray-700">Temporary Slip</a>
            	<a href="request-pcv.html" class="btn btn-sm btn-white btn-uppercase bd-gray-700 active">PCV</a>
           	 	<a href="request-pcfr.html" class="btn btn-sm btn-white btn-uppercase bd-gray-700">PCFR</a>
          	</div>
        </div>

        <div class="col-lg-12">
            <table id="example1" class="table">

                <thead>
                    <tr>
                        <th class="wd-10p">Date</th>
                        <th class="wd-20p">PCV No.</th>
                        <th class="wd-15p">Account</th>
                        <th class="wd-15p">Amount</th>
                        <th class="wd-10p">Status</th>
                        <th class="wd-10p">Action</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                    @forelse( $pcvs as $pcv )

                      	<tr>
	                        <td> {{ \Carbon\Carbon::parse($pcv->date_created)->toFormattedDateString() }} </td>
	                        <td> <a href="{{ route('pcv.show', $pcv->pcv_no) }}"> {{ $pcv->pcv_no }} </a></td>
	                        <td> {{ $pcv->account_name }} </td>
	                        <td> {{ $pcv->amount }} </td>
	                        <td><span class="badge badge-secondary tx-uppercase"> {{ $pcv->status }} </span></td>
	                        <td> 
	                        	<a href="{{ route('pcv.edit', $pcv->pcv_no) }}" > Edit </a>
                                <a href="javascript:void(0);" > Delete </a> 
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
				{ targets: 6, orderable: false }
				],
				dom: 'lf<"dataTables_responsive"t>ip'
			});

			// Select2
			$('.dataTables_length select').select2({ 
				minimumResultsForSearch: Infinity 
			});
		});
    </script>


@endsection