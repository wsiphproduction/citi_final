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
					<li class="breadcrumb-item active" aria-current="page">Edit</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Edit User Form</h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<form method="POST" action="{{ route('users.update', $user->id) }}" class="col-lg-12">
			@csrf
			@method('PUT')

			<div class="row">

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="lastname" class="col-lg-3 col-form-label">Last Name</label>
						<div class="col-lg-7">
							<input type="text" name="lastname" class="form-control" value="{{ old('lastname',$user->lastname) }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="username" class="col-lg-3 col-form-label">Username</label>
						<div class="col-lg-7">
							<input type="text" name="username" class="form-control" value="{{ old('username',$user->username) }}"/>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="firstname" class="col-lg-3 col-form-label">First Name</label>
						<div class="col-lg-7">
							<input type="text" name="firstname" class="form-control" value="{{ old('firstname',$user->firstname) }}"/>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="password" class="col-lg-3 col-form-label">Password</label>
						<div class="col-lg-7">
							<input type="password" class="form-control" id="password" name="password" 
								readonly value="{{ old('password',$user->password) }}">
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="middlename" class="col-lg-3 col-form-label">Middle Name</label>
						<div class="col-lg-7">
							<input type="text" class="form-control" id="middlename" name="middlename" 
								value="{{ old('middlename',$user->middlename) }}">
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="assign_to" class="col-lg-3 col-form-label">Assign To</label>
						<div class="col-lg-4">
							<select class="form-control" name="assign_to" id="assign_to">
								<option value=""> Select </option>
								
								@foreach( $branch as $bran )
									<option value="{{ $bran->id }}" @if(old('assign_to',$user->assign_to)==$bran->id) selected @endif> {{ $bran->name }} </option>
								@endforeach
							</select>
						</div>
						<div class="col-lg-4">
							<select class="form-control" name="assign_name" id="assign_name" disabled> 
								<option value=""> Select </option>
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="position" class="col-lg-3 col-form-label">Position</label>
						<div class="col-lg-7">
							<select class="form-control" name="position">
								<option value=""> Select Position </option>
								<option value="administrator" @if(old('position', $user->position) == 'administrator') selected @endif> Administrator </option>
								<option value="area head" @if(old('position', $user->position) == 'area head') selected @endif> Area Head </option>
								<option value="audit" @if(old('position', $user->position) == 'audit') selected @endif> Audit </option>
								<option value="department head" @if(old('position', $user->position) == 'department head') selected @endif> Department Head </option>
								<option value="division head" @if(old('position', $user->position) == 'division head') selected @endif> Division Head </option>
								<option value="department staff" @if(old('position', $user->position) == 'department staff') selected @endif> Department Staff </option>
								<option value="logistics head" @if(old('position', $user->position) == 'logistics head') selected @endif> Logistics Head </option>
								<option value="ol head" @if(old('position', $user->position) == 'ol head') selected @endif> OL Head </option>
								<option value="payables staff" @if(old('position', $user->position) == 'payables staff') selected @endif> Payables Staff </option>
								<option value="petty cash custodian" @if(old('position', $user->position) == 'petty cash custodian') selected @endif> Petty Cash Custodian </option>
								<option value="team leader" @if(old('position', $user->position) == 'team leader') selected @endif> Team Leader </option>
								<option value="treasury head" @if(old('position', $user->position) == 'treasury head') selected @endif> Treasury Head </option>
								<option value="treasury staff" @if(old('position', $user->position) == 'treasury staff') selected @endif> Treasury Staff </option>
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="branch_group" class="col-lg-3 col-form-label">Group</label>
						<div class="col-lg-7">
							<select class="form-control" name="branch_group_id">
								<option value=""> Select Branch Group </option>
								@foreach( $branch_groups as $group )
									<option value="{{ $group->id }}" @if(old('branch_group_id',$user->branch_group_id)==$group->id) selected @endif> {{ $group->name }} </option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="status" class="col-lg-3 col-form-label">Status</label>
						<div class="col-lg-7">
							<label>
								<input type="radio" name="status" value="1" @if(old('status',$user->status)==1) checked @endif> Active
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="radio" name="status" value="0" @if(old('status',$user->status)==0) checked @endif> Inactive
							</label>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="access" class="col-lg-3 col-form-label">Access</label>
						<div class="col-lg-7">
							<select class="form-control" name="access[]" id="access" multiple>
								<option value=""> Select Position </option>
								@foreach( $roles as $role )
									<option value="{{ $role->name }}" @if($user->hasrole($role->name)) selected @endif> {{ $role->name }} </option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-12 mg-t-20">
					<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
						Update
					</button>					
				</div>

			</div>

		</form>

    </div>
	
@endsection


@section('pagejs')

	<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
	<script type="text/javascript">
			
		$(document).ready(function(){
			$('#assign_to').change();
		});

		$(document).on('change', '#assign_to', function() {

			let _select_assignment = $(this).val();
			let _url = "";

			$.ajax({
				url 		: "{!! env('APP_URL') !!}/branch/department-list?branch="+_select_assignment ,
				method 		: 'GET' ,
				success 	: function(res) {

					$('#assign_name').empty();

					let _html = '<option value=""> Select </option>';

					$.each(res, function(i, o) {

						if('{!! $user->assign_name !!}' == o.name) {
							_html += '<option value="'+o.name+'" selected>'+o.name+'</option>';
						} else {
							_html += '<option value="'+o.name+'">'+o.name+'</option>';
						}

					});

					$('#assign_name').append(_html).attr('disabled', false);

				}
			})

		});

		$("#access").select2({
		    tags: true,
		    tokenSeparators: [',']
		})

	</script>

@endsection