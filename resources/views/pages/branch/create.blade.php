@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('branch.index') }}">Branch</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">New Branch Form</h4>
		</div>

	</div>	

	<div class="row">
		
		<form method="POST" action="{{ route('branch.store') }}" class="col-lg-12">
	        @csrf
	        
	        <div class="row">
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Branch Name</label>
						<div class="col-lg-7">
							<input type="text" name="name" class="form-control">
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Budget</label>
						<div class="col-lg-7">
							<input type="number" name="budget" class="form-control" step="1" min="0" />
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
								<input type="radio" name="status" value="1" checked> Active
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="radio" name="status" value="0"> Inactive
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
