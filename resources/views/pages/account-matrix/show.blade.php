@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('account-matrix.index') }}">Account Matrix</a></li>
					<li class="breadcrumb-item active" aria-current="page">Show</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Account Matrix</h4>
		</div>

	</div>	

	<div class="row">
	        
        <div class="offset-3"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="name" class="col-lg-5 col-form-label">Account Name</label>
				<div class="col-lg-7">
					<input type="text" disabled class="form-control" value="{{ old('name', $matrix->name) }}"/>
				</div>
			</div>
		</div>

		<div class="col-lg-3"></div>
        <div class="offset-3"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="name" class="col-lg-5 col-form-label">Account Number</label>
				<div class="col-lg-7">
					<input type="text" disabled class="form-control" value="{{ old('number', $matrix->number) }}"/>
				</div>
			</div>
		</div>

		<div class="col-lg-3"></div>
		<div class="offset-3"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="name" class="col-lg-5 col-form-label">Amount</label>
				<div class="col-lg-7">
					<input type="number" name="amount" class="form-control" value="{{ old('amount', $matrix->amount) }}" 
						disabled/>
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
						<input type="checkbox" disabled
							@if(old('beyond', $matrix->beyond)) checked @endif> Beyond
					</label> &nbsp;&nbsp;&nbsp;&nbsp;
					<label>									
						<input type="checkbox" disabled
							@if(old('regardless', $matrix->regardless)) checked @endif> Regardless
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
						<input type="radio" disabled value="1" 
							@if(old('code',$matrix->code) == 1 || is_null(old('code', $matrix->code))) checked @endif> Yes
					</label> &nbsp;&nbsp;&nbsp;&nbsp;
					<label>									
						<input type="radio" disabled value="0" 
							@if(old('code',$matrix->code) == 0 && !is_null(old('code',$matrix->code))) checked @endif> No
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
						<input type="radio" disabled value="1" 
							@if(old('status',$matrix->status) == 1 || is_null(old('status',$matrix->status))) checked @endif> Active

					</label> &nbsp;&nbsp;&nbsp;&nbsp;
					<label>									
						<input type="radio" disabled value="0" 
							@if(old('status',$matrix->status) == 0 && !is_null(old('status',$matrix->status))) checked @endif> Inactive
					</label>
				</div>
			</div>
		</div>

		<div class="col-lg-3"></div>
		<div class="offset-3"></div>
		
    </div>
	
@endsection