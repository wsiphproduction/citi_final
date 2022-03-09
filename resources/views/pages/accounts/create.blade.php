@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="request-temporary-slip.html">Accounts</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">New Account Form</h4>
		</div>

	</div>	

	<div class="row">
		
		<form method="POST" action="{{ route('users.store') }}" class="col-lg-12">
			@csrf

			<div class="offset-3"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="name" class="col-lg-4 col-form-label">Name</label>
					<div class="col-lg-8">
						<input type="text" name="name" class="form-control" />
					</div>
				</div>
			</div>

			<div class="col-lg-3"></div>


			<div id="field-wrapper">
				<div class="col-lg-12">
					
					<div class="row">
				
						<div class="col-lg-3">
							<div class="form-group row">
								<label for="username" class="col-lg-5 col-form-label">Name</label>
								<div class="col-lg-7">
									<input type="text" name="username" class="form-control" />
								</div>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group row">
								<label for="username" class="col-lg-5 col-form-label">Type</label>
								<div class="col-lg-7">
									<input type="text" name="username" class="form-control" />
								</div>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group row">
								<label for="username" class="col-lg-5 col-form-label">Other details</label>
								<div class="col-lg-7">
									<textarea rows="5" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="offset-3"></div>
				
					</div>

				</div>
				</div>

			<div class="col-lg-12 text-right">
				<div class="row">
					<button class="btn btn-xs btn-primary" type="button"> Add field </button>
				</div>
			</div>

			<div class="col-lg-3"></div>
			<div class="col-lg-6"></div>

			<div class="col-lg-3 mg-t-20 text-right">
				<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150">
					<i class="mg-r-5" data-feather="send"></i> Submit
				</button>
			</div>

		</form>

    </div>
	
@endsection
