@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">New User Form</h4>
		</div>

	</div>	

	<div class="row">
		
		<form method="POST" action="{{ route('users.store') }}" class="col-lg-12">
			@csrf

			<div class="row">

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="lastname" class="col-lg-3 col-form-label">Last Name</label>
						<div class="col-lg-7">
							<input type="text" name="lastname" class="form-control" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="username" class="col-lg-3 col-form-label">Username</label>
						<div class="col-lg-7">
							<input type="text" name="username" class="form-control" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="firstname" class="col-lg-3 col-form-label">First Name</label>
						<div class="col-lg-7">
							<input type="text" name="firstname" class="form-control" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="password" class="col-lg-3 col-form-label">Password</label>
						<div class="col-lg-7">
							<input type="password" class="form-control" id="password" name="password">
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="middlename" class="col-lg-3 col-form-label">Middle Name</label>
						<div class="col-lg-7">
							<input type="text" class="form-control" id="middlename" name="middlename">
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
									<option value="{{ $bran->id }}"> {{ $bran->name }} </option>
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
								<option value="administrator" @if(old('position') == 'administrator') selected @endif> Administrator </option>
								<option value="area head" @if(old('position') == 'area head') selected @endif> Area Head </option>
								<option value="audit" @if(old('position') == 'audit') selected @endif> Audit </option>
								<option value="department head" @if(old('position') == 'department head') selected @endif> Department Head </option>
								<option value="division head" @if(old('position') == 'division head') selected @endif> Division Head </option>
								<option value="department staff" @if(old('position') == 'department staff') selected @endif> Department Staff </option>
								<option value="logistics head" @if(old('position') == 'logistics head') selected @endif> Logistics Head </option>
								<option value="ol head" @if(old('position') == 'ol head') selected @endif> OL Head </option>
								<option value="payables staff" @if(old('position') == 'payables staff') selected @endif> Payables Staff </option>
								<option value="petty cash custodian" @if(old('position') == 'petty cash custodian') selected @endif> Petty Cash Custodian </option>
								<option value="team leader" @if(old('position') == 'team leader') selected @endif> Team Leader </option>
								<option value="treasury head" @if(old('position') == 'treasury head') selected @endif> Treasury Head </option>
								<option value="treasury staff" @if(old('position') == 'treasury staff') selected @endif> Treasury Staff </option>
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
									<option value="{{ $group->id }}"> {{ $group->name }} </option>
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
								<input type="radio" name="status" value="1" checked> Active
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="radio" name="status" value="0"> Inactive
							</label>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="access" class="col-lg-3 col-form-label">Access</label>
						<div class="col-lg-7">
							<select class="form-control" name="access">
								<option value=""> Select Access </option>
								@foreach( $roles as $role )
									<option value="{{ $role->name }}"> {{ $role->name }} </option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-6"></div>

				<div class="col-lg-12 mg-t-20">
					<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150">
						<i class="mg-r-5" data-feather="send"></i> Submit
					</button>					
				</div>

			</div>

		</form>

    </div>
	
@endsection


@section('pagejs')

	<script type="text/javascript">
		
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

						_html += '<option value="'+o.name+'">'+o.name+'</option>';

					});

					$('#assign_name').append(_html).attr('disabled', false);

				}
			})

		});

	</script>

@endsection