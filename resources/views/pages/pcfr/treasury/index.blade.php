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

		<div class="d-md-block mt-4 mt-lg-0">
            <a class="btn btn-sm pd-x-15 btn-primary btn-uppercase" href="{{ route('treasury.pcfr.create') }}">
            	<i data-feather="plus" class="wd-10 mg-r-5"></i> Create PCFR
            </a>
        </div>

	</div>	

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
	                                    <i data-feather="external-link"></i>
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