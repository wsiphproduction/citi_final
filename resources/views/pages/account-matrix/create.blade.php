@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('account-matrix.index') }}">Account Matrix</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">New Account Matrix Form</h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<form method="POST" action="{{ route('account-matrix.store') }}" class="col-lg-12">
	        @csrf
	        
	        <div class="row">
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Account Name</label>
						<div class="col-lg-7">
							<select class="form-control" name="name">
								<option value=""> Select Account </option>
								@foreach( $accounts as $account )
									<option value="{{ $account['name'] }}" @if(old('name') == $account['name']) selected @endif>{{ $account['name'] }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Account Number</label>
						<div class="col-lg-7">
							<input type="text" name="number" class="form-control" value="{{ old('number') }}"/>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Amount</label>
						<div class="col-lg-7">
							<input type="number" name="amount" class="form-control" id="amount"  step="1" min="0" value="{{ old('amount') }}" 
								@if(old('regardless')) disabled @endif/>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">&nbsp;</label>
						<div class="col-lg-7">
							<label>
								<input type="checkbox" id="beyond" name="beyond" value="1" @if(old('beyond')) checked @endif> Beyond
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="checkbox" id="regardless" name="regardless" value="1"
									@if(old('regardless')) checked @endif> Regardless
							</label>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Approval Code</label>
						<div class="col-lg-7">
							<label>
								<input type="radio" name="code" value="1" @if(old('code') == 1 || old('code') == null) checked @endif> Yes
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="radio" name="code" value="0" @if(old('code') == 0 && old('code') != null) checked @endif> No
							</label>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Status</label>
						<div class="col-lg-7">
							<label>
								<input type="radio" name="status" value="1" 
									@if(old('status') == 1 || old('status') == null) checked @endif> Active
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="radio" name="status" value="0" 
									@if(old('status') == 0 && old('status') != null) checked @endif> Inactive
							</label>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6 mg-t-20 text-right">
					<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150">
						<i class="mg-r-5" data-feather="send"></i> Submit
					</button>
				</div>
			</div>

		</form>

    </div>
	
@endsection

@section('pagejs')

<script type="text/javascript">
	
	$(document).on('click', '#regardless', function() {
		if($(this).is(':checked')) {
			$('#amount').attr('disabled', 'disabled');
		} else {
			$('#amount').attr('disabled', false);
		}
	});

</script>

@endsection