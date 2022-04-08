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

	</div>	

    @include('components.messages')

    <div class="row mg-b-30">
        
        <div class="col-lg-12">

            <form class="row">

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="temporary-slip-no" class="col-lg-5 col-form-label">Branch</label>
                        <div class="col-lg-7">
                            <select class="form-control custom-select" name="branch">
                            <option value=""> Select Account </option>                              
                            @foreach( $branch as $br )
                                <option value="{{ $br->store_id }}" @if($br->store_id == request()->branch) selected @endif> 
                                    {{ $br->name }} 
                                </option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <button class="btn btn-primary"> Filter </button>
                    </div>
                </div>

            </form>

        </div>

    </div>

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
                                @if( !count($slip->pcv) && $slip->created_at->diffInDays(\Carbon\Carbon::now()) >= 3 && count($slip->pcv) == 0)
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
                                    <a class="nav-link p-0 pl-2" href="{{ route('audit.ts.show', $slip->id) }}" title="View Request">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </a>
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