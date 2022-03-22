@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('branch.index') }}">Branch</a></li>
					<li class="breadcrumb-item active" aria-current="page">Show</li>
				</ol>
			</nav>
		</div>

	</div>	

	<div class="row">
		
	
        <div class="row">
	        <div class="offset-3"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="name" class="col-lg-5 col-form-label">Branch Name</label>
					<div class="col-lg-7">
						<input type="text" disabled class="form-control" value="{{ $branch->name }}">
					</div>
				</div>
			</div>

			<div class="col-lg-3"></div>
	        <div class="offset-3"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="name" class="col-lg-5 col-form-label">Budget</label>
					<div class="col-lg-7">
						<input type="number" disabled class="form-control" step="1" min="0" value="{{ $branch->budget }}" />
					</div>
				</div>
			</div>

			<div class="col-lg-3"></div>
	        <div class="offset-3"></div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="name" class="col-lg-5 col-form-label">Company Name</label>
					<div class="col-lg-7">
						<input type="text" disabled class="form-control" value="{{ $branch->company_name }}" />
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
							<input type="radio" disabled value="1" @if($branch->status == 1) checked @endif> Active
						</label> &nbsp;&nbsp;&nbsp;&nbsp;
						<label>									
							<input type="radio" disabled value="0" @if($branch->status == 0) checked @endif> Inactive
						</label>
					</div>
				</div>
			</div>

			<div class="col-lg-3"></div>
			<div class="offset-3"></div>

		</div>

    </div>
	
@endsection
