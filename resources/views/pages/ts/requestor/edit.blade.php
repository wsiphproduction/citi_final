@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="{{ route('requestor.ts.index') }}">Temporary Slip</a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Edit Temporary Slip</h4>
		</div>

	</div>	

	@include('components.messages')

	
		
		<form action="{{ route('requestor.ts.update', $ts->id) }}" method="POST" id="ts_form">
			@csrf
			@method('PUT')
			<input type="hidden" name="status" value="submitted" id="status">
			
			<div class="row">

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="temporary-slip-no" class="col-lg-5 col-form-label">Temporary Slip No.</label>
					<div class="col-lg-7">
						<input type="text" class="form-control" id="ts_no" name="ts_no"
							value="{{ $ts->ts_no }}" readonly>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="date" class="col-lg-2 col-form-label">Date</label>
					<div class="col-lg-10">
						<input type="date" class="form-control wd-100p wd-lg-250"
							value="{{ \Carbon\Carbon::parse($ts->date_created)->format('Y-m-d') }}" name="date_created" disabled>
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

						<!-- <select class="custom-select" id="account_name" name="account_name">
							<option value="">Select Account</option>
							@foreach( $accounts as $account )
								<option value="{{ $account['name'] }}" 
									@if( $account['name'] == $ts->account_name ) selected @endif >
									{{ $account['name'] }} 
								</option>
							@endforeach
						</select> -->

						<select class="form-control" name="account">
							<option value=""> Select Account </option>								
							@foreach( \App\Models\Account::getAccounts() as $account )
								<option value="{{ $account['FLEX_VALUE_MEANING'] }} | {{ $account['DESCRIPTION'] }}"
									@if( $account['FLEX_VALUE_MEANING'] == $ts->account_code ) selected @endif > 
									{{ $account['DESCRIPTION'] }} 
								</option>
							@endforeach
						</select>

					</div>
				</div>
			</div>

			<div class="col-lg-6"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="amount" class="col-lg-5 col-form-label">Amount</label>
					<div class="col-lg-7">
						<input type="text" class="form-control" value="{{ $ts->amount }}" name="amount" autocomplete="off">
					</div>
				</div>
			</div>

			<div class="col-lg-6"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="description" class="col-lg-5 col-form-label">Description</label>
					<div class="col-lg-7">
						<textarea id="description" name="description" class="form-control" rows="3">{{ $ts->description }}</textarea>
					</div>
				</div>
			</div>

			<div class="col-lg-6"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="received_date" class="col-lg-5 col-form-label">Received Date</label>
					<div class="col-lg-7">
						<input type="text" class="form-control" id="received_date" name="received_date"
							value="{{ \Carbon\Carbon::parse($ts->received_date)->format('Y-m-d') }}">
					</div>
				</div>
			</div>
			
			<div class="col-lg-6"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="received_by" class="col-lg-5 col-form-label">Received By</label>
					<div class="col-lg-7">
						<input type="text" class="form-control" id="received_by" name="received_by"
							value="{{ $ts->received_by }}" autocomplete="off">
					</div>
				</div>
			</div>

			<div class="col-lg-12 mg-t-20">	
											
				<button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit"
				data-action="saved" data-id="{{ $ts->id }}"> 
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
					Saved
				</button>	

				@if(\Str::contains($ts->status , 'disapproved') || $ts->status == 'saved')				
					<button type="button" class="btn btn-primary mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit"
					data-action="submitted" data-id="{{ $ts->id }}"> 
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send mg-r-5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>		
						Submit
					</button>
				@endif
					
									
			</div>

		
    	</div>
	
	</form>

@endsection	

@section('pagejs')

	<script type="text/javascript">	

		$("#received_date").datepicker({
		    minDate: new Date()
		});

		$(document).on('click', '.btn-submit', function() {

			let _action = $(this).data('action');

			$('#status').val(_action);
			$('#ts_form').submit();


		});


	</script>

@endsection