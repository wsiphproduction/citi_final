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
					<li class="breadcrumb-item"><a href="{{ route('branch-group.index') }}">Branch</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Edit Branch Group Form</h4>
		</div>

	</div>	

	<div class="row">
		
        <div class="offset-3"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="name" class="col-lg-5 col-form-label">Group Name</label>
				<div class="col-lg-7">
					<input type="text" disabled class="form-control" value="{{ $branch_group->name }}">
				</div>
			</div>
		</div>

		<div class="col-lg-3"></div>
        <div class="offset-3"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="name" class="col-lg-5 col-form-label">Size</label>
				<div class="col-lg-7">
					<input type="text" disabled class="form-control" value="{{ $branch_group->size }}">
				</div>
			</div>
		</div>

		<div class="col-lg-3"></div>
		<div class="offset-3"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="name" class="col-lg-5 col-form-label">Branch</label> 
				<div class="col-lg-7">
					<ul style="padding: 0 20px;">
						@forelse( $branch_group->branch as $branch)
							<li> {{ $branch }} </li>
						@empty

							<li>No Branch Found</li>

						@endforelse
					</ul>
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
						<input type="radio" disabled value="1" @if($branch_group->status == 1) checked @endif> Active
					</label> &nbsp;&nbsp;&nbsp;&nbsp;
					<label>									
						<input type="radio" disabled value="0" @if($branch_group->status == 0) checked @endif> Inactive
					</label>
				</div>
			</div>
		</div>

		<div class="col-lg-3"></div>
		<div class="offset-3"></div>

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
