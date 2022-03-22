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
					<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
					<li class="breadcrumb-item active" aria-current="page">Show</li>
				</ol>
			</nav>
		</div>

	</div>	

	<div class="row">

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="lastname" class="col-lg-3 col-form-label">Last Name</label>
				<div class="col-lg-7">
					<input type="text" disabled class="form-control" value="{{ $user->lastname }}" />
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="username" class="col-lg-3 col-form-label">Username</label>
				<div class="col-lg-7">
					<input type="text" disabled class="form-control" value="{{ $user->username }}" />
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="firstname" class="col-lg-3 col-form-label">First Name</label>
				<div class="col-lg-7">
					<input type="text" disabled class="form-control" value="{{ $user->firstname }}" />
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="password" class="col-lg-3 col-form-label">Password</label>
				<div class="col-lg-7">
					<input type="password" class="form-control" disabled value="{{ $user->password }}" />
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="middlename" class="col-lg-3 col-form-label">Middle Name</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" disabled value="{{ $user->middlename }}" />
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group">
				<div class="row">
				<label for="assign_to" class="col-lg-3 col-form-label">Assign To</label>
				<div class="col-lg-4">  
					<input type="text" class="form-control" disabled
						value="{{ $user->branch ?  $user->branch->name: null }}" />				
				</div>
				<div class="col-lg-4">
					<input type="text" class="form-control" disabled 
						value="{{ $user->assign_name }}" />	
				</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="position" class="col-lg-3 col-form-label">Position</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" disabled value="{{ $user->position }}" />
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group row">

				<label for="branch_group" class="col-lg-3 col-form-label">Group</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" disabled 
						value="{{ $user->branch_group ? $user->branch_group->name : null }}" />
					
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="status" class="col-lg-3 col-form-label">Status</label>
				<div class="col-lg-7">
					<label>
						<input type="radio" disabled value="1" 
							@if($user->status == 1) checked @endif> Active
					</label> &nbsp;&nbsp;&nbsp;&nbsp;
					<label>									
						<input type="radio" disabled value="0" 
							@if($user->status == 0) != null) checked @endif> Inactive
					</label>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="access" class="col-lg-3 col-form-label">Access</label>
				<div class="col-lg-7">
					<input type="text" value="{{ implode(' | ', $user->roles()->pluck('name')->toArray()) }}" class="form-control"
						disabled>
				</div>
			</div>
		</div>

    </div>
	
@endsection


@section('pagejs')

	<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>	
	<script type="text/javascript">
		
    	$("#access").select2({
		    tags: true,
		    tokenSeparators: [',']
		})
   

	</script>

@endsection