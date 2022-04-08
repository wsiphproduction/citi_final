@extends('layouts.app')

@section('pagecss')
	<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('branch-group.index') }}">Branch Group</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">New Group Form</h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<form method="POST" action="{{ route('branch-group.store') }}" class="col-lg-12">
	        @csrf
	        
	        <div class="row">
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Group Name</label>
						<div class="col-lg-7">
							<input type="text" name="name" class="form-control">
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Size</label>
						<div class="col-lg-7">
							<select class="form-control" name="size">
								<option value=""> Select Size </option>
								@foreach($branch_sizes as $size)
									<option value="{{ strtolower($size->BRANCH_SIZE) }}">{{ $size->BRANCH_SIZE }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Branch</label>
						<div class="col-lg-7">
							<select class="form-control" name="branch[]" id="actions" multiple placeholder="Select Branch">
								@foreach($branch as $bran)
									<option value="{{ $bran->name }}">{{ ucfirst($bran->name) }} </option>
								@endforeach	
							</select>
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

@section('pagejs')
	<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
    	$("#actions").select2({
		    tags: true,
		    tokenSeparators: [',']
		})
    </script>
@endsection
