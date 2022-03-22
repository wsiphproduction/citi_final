@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('charges.index') }}">Charges</a></li>
					<li class="breadcrumb-item active" aria-current="page">Show</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Show Charge</h4>
		</div>

	</div>	

	<div class="row">
		
        <div class="row">
	        <div class="offset-3"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="name" class="col-lg-5 col-form-label">Account Name</label>
					<div class="col-lg-7">
						<input type="text" value="{{ $charge->name }}" class="form-control" disabled>
					</div>
				</div>
			</div>

			<div class="col-lg-3"></div>
	        <div class="offset-3"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="name" class="col-lg-5 col-form-label">Charge To</label>
					<div class="col-lg-7">
						<input type="text" value="{{ $charge->charge_to }}" class="form-control" disabled/>
					</div>
				</div>
			</div>

			<div class="col-lg-3"></div>
			<div class="offset-3"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="name" class="col-lg-5 col-form-label">Code</label>
					<div class="col-lg-7">
						<input type="text" value="{{ $charge->code }}" class="form-control" disabled/>
					</div>
				</div>
			</div>

			<div class="col-lg-3"></div>
			<div class="offset-3"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="name" class="col-lg-5 col-form-label">Type</label>
					<div class="col-lg-7">
						<input type="text" value="{{ $charge->type }}" disabled class="form-control">
					</div>
				</div>
			</div>

			<div class="col-lg-3"></div>
			<div class="offset-3"></div>

		</div>

    </div>
	
@endsection
