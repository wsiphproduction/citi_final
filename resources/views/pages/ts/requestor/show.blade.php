@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="{{ route('requestor.ts.index') }}">Temporary Slip</a></li>
					<li class="breadcrumb-item active" aria-current="page">Show</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Temporary Slip Form</h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<div class="col-lg-6">
			<div class="form-group row">
				<label for="temporary-slip-no" class="col-lg-5 col-form-label">Temporary Slip No.</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" id="ts_no" name="ts_no" readonly
						value="{{ $ts->ts_no }}">
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="date" class="col-lg-2 col-form-label">Date</label>
				<div class="col-lg-10">
					<input type="text" class="form-control wd-100p wd-lg-250" readonly
						value="{{ \Carbon\Carbon::parse($ts->date_created)->toFormattedDateString() }}">
				</div>
			</div>
		</div>

		<div class="col-lg-12">
			<hr class="mg-t-10 mg-b-30">
		</div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="account" class="col-lg-5 col-form-label">Account</label>
				<div class="col-lg-7">
					<input type="text" value="{{ $ts->account_name }}" class="form-control" readonly>
				</div>
			</div>
		</div>

		<div class="col-lg-6"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="amount" class="col-lg-5 col-form-label">Amount</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" readonly value="{{ $ts->amount }}">
				</div>
			</div>
		</div>

		<div class="col-lg-6"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="description" class="col-lg-5 col-form-label">Description</label>
				<div class="col-lg-7">
					<textarea id="description" name="description" class="form-control" rows="3" readonly>{{ $ts->description }}</textarea>
				</div>
			</div>
		</div>

		<div class="col-lg-6"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="received_date" class="col-lg-5 col-form-label">Received Date</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" id="received_date" name="received_date"
						value="{{ \Carbon\Carbon::parse($ts->received_date)->toFormattedDateString() }}" readonly>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="received_by" class="col-lg-5 col-form-label">Received By</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" id="received_by" name="received_by"
						value="{{ $ts->received_by }}" readonly>
				</div>
			</div>
		</div>

		@if( $ts->status == 'saved' )
		<div class="col-lg-12 mg-t-20">	
			<form action="{{ route('requestor.ts.status-update', $ts->id) }}" method="POST">
				@csrf
				@method('PUT')
				<input type="hidden" name="action" value="submitted">
			
				<button type="submit" class="btn btn-primary mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150"
					data-action="submitted" data-id="{{ $ts->id }}" id="btn-submit"> 
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send mg-r-5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>Submit
				</button>							
			</form>
		</div>
		@endif

    </div>
	
@endsection
