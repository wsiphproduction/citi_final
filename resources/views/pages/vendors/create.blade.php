@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">New Vendor Form</h4>
		</div>

	</div>	

	<div class="row">
		
		<form method="POST" action="{{ route('vendors.store') }}" class="col-lg-12" enctype="multipart/form-data">
	        @csrf
	        
	        <div class="row">

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="vendor" class="col-lg-5 col-form-label">Vendor/Company</label>
						<div class="col-lg-7">
							<input type="text" name="name" class="form-control" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="address" class="col-lg-5 col-form-label">Address</label>
						<div class="col-lg-7">
							<textarea rows="5" class="form-control" name="address"></textarea>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="tin" class="col-lg-5 col-form-label">Vat Registered TIN</label>
						<div class="col-lg-7">
							<input type="text" name="tin" class="form-control" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="attachment" class="col-lg-5 col-form-label">Attachment</label>
						<div class="col-lg-7">
							<input type="file" name="attachments[]" multiple  />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="contact_number" class="col-lg-5 col-form-label">Contact Number</label>
						<div class="col-lg-7">
							<input type="text" name="contact_number" class="form-control" />
						</div>
					</div>
				</div>

				<div class="col-lg-6"></div>

				<div class="col-lg-6">
					<div class="form-group row">

						<label for="contact_number" class="col-lg-5 col-form-label">Status</label>						
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

				<div class="col-lg-12 mg-t-20 text-right">
					<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
						Save
					</button>
				</div>
			</div>

		</form>

    </div>
	
@endsection
