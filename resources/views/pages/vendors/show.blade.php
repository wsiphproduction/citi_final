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
	
        
        <div class="row">

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="vendor" class="col-lg-5 col-form-label">Vendor/Company</label>
					<div class="col-lg-7">
						<input type="text" name="name" class="form-control" value="{{ $vendor->name }}" disabled />
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="address" class="col-lg-5 col-form-label">Address</label>
					<div class="col-lg-7">
						<textarea rows="5" class="form-control" name="address" disabled >{{ $vendor->address }}</textarea>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="tin" class="col-lg-5 col-form-label">Vat Registered TIN</label>
					<div class="col-lg-7">
						<input type="text" name="tin" class="form-control" value="{{ $vendor->tin }}" disabled />
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="attachment" class="col-lg-5 col-form-label">Attachment</label>
					<div class="col-lg-7">
						<ul>
							@forelse($vendor->attachment as $attchmnt )
								<li> <a href='{{ env("APP_URL")."/storage/vendors/{$vendor->id}/attachments/{$attchmnt}" }}' target="_blank">
									{{ $attchmnt }} </a> 
								</li>
							@empty
								<li> No Attachment Found </li>
							@endforelse
						</ul>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="contact_number" class="col-lg-5 col-form-label">Contact Number</label>
					<div class="col-lg-7">
						<input type="text" name="contact_number" class="form-control" value="{{ $vendor->contact_number }}" disabled />
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

		</div>

    </div>
	
@endsection
