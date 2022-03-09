@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="request-temporary-slip.html">Temporary Slip</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Temporary Slip Form</h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<form method="POST" action="{{ route('ts.store') }}" id="ts_form">

			<div class="col-lg-12">
			<div class="row">
					
			@csrf
			<input type="hidden" name="status" id="status">

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="temporary-slip-no" class="col-lg-5 col-form-label">Temporary Slip No.</label>
					<div class="col-lg-7">
						<input type="text" class="form-control" id="ts_no" name="ts_no" readonly
							value="{{ \App\Models\TemporarySlip::generateTSNumber() }}">
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="date" class="col-lg-2 col-form-label">Date</label>
					<div class="col-lg-10">
						<input type="date" class="form-control wd-100p wd-lg-250" id="date_created" name="date_created"
							value="{{ old('date_created', date('Y-m-d')) }}">
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
						<select class="custom-select" id="account_name" name="account_name">
							@foreach( $accounts as $account )
								<option value="{{ $account['name'] }}" @if(old('account_name')==$account['name']) selected @endif> 
									{{ $account['name'] }} 
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
						<input type="number" class="form-control" id="amount" name="amount" step="1" min="0"
							value="{{ old('amount') }}">
					</div>
				</div>
			</div>

			<div class="col-lg-6"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="description" class="col-lg-5 col-form-label">Description</label>
					<div class="col-lg-7">
						<textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
					</div>
				</div>
			</div>

			<div class="col-lg-6"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="received_date" class="col-lg-5 col-form-label">Received Date</label>
					<div class="col-lg-7">
						<input type="date" class="form-control" id="received_date" name="received_date"
							value="{{ old('received_date', date('Y-m-d')) }}">
					</div>
				</div>
			</div>
			
			<div class="col-lg-6"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="received_by" class="col-lg-5 col-form-label">Received By</label>
					<div class="col-lg-7">
						<input type="text" class="form-control" id="received_by" name="received_by"
							value="{{ old('received_by') }}">
					</div>
				</div>
			</div>

			<div class="col-lg-6"></div>

			<div class="col-lg-12 mg-t-20">
				<button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit"
					data-action="saved">
					<i class="mg-r-5" data-feather="save"></i> Save
				</button>
				<button type="button" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-submit"
					data-action="submitted">
					<i class="mg-r-5" data-feather="send"></i> Submit
				</button>
			</div>


			</div>
			</div>

		</form>

    </div>
	
@endsection

@section('pagejs')

	<script type="text/javascript">
		
		$(document).on('click', '.btn-submit', function(e) {

			e.preventDefault();

			$('#status').val($(this).data('action'));

			$('#ts_form').submit();

		});


	</script>

@endsection