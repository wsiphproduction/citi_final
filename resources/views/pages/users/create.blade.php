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
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">New User Form</h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<form method="POST" action="{{ route('users.store') }}" class="col-lg-12">
			@csrf

			<div class="row">

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="lastname" class="col-lg-3 col-form-label">Last Name</label>
						<div class="col-lg-7">
							<input type="text" name="lastname" class="form-control" value="{{ old('lastname') }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="username" class="col-lg-3 col-form-label">Username</label>
						<div class="col-lg-7">
							<input type="text" name="username" class="form-control" value="{{ old('username') }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="firstname" class="col-lg-3 col-form-label">First Name</label>
						<div class="col-lg-7">
							<input type="text" name="firstname" class="form-control" value="{{ old('firstname') }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="password" class="col-lg-3 col-form-label">Password</label>
						<div class="col-lg-7">
							<input type="password" class="form-control" id="password" name="password" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="middlename" class="col-lg-3 col-form-label">Middle Name</label>
						<div class="col-lg-7">
							<input type="text" class="form-control" id="middlename" name="middlename" value="{{ old('middlename') }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="assign_to" class="col-lg-3 col-form-label">Assign To</label>
						<div class="col-lg-4">
							<select class="form-control" name="store_type" id="store_type">
								<option value=""> Select </option>
								<option value="stores">Store</option>
								<option value="distribution center">DC</option>
								<option value="head office">SSC</option>
							</select>
							<input type="hidden" name="assign_to" id="assign_to">
						</div>
						<div class="col-lg-4">
							<select class="form-control" name="assign_name" id="assign_name"> 
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
								<option > Select Position </option>
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
									<option value="{{ $group->id }}" @if(old('branch_group_id') == $group->id) selected @endif> 
										{{ $group->name }} 
									</option>
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
								<input type="radio" name="status" value="1" 
									@if(old('status') == 1 || old('status',null) == null) checked @endif> Active
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="radio" status="status" value="0" 
									@if(old('status') == 0 && old('status', null) != null) checked @endif> Inactive
							</label>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="access" class="col-lg-3 col-form-label">Access</label>
						<div class="col-lg-7">
							<select class="form-control" name="access[]" id="access" multiple>
								@foreach( $roles as $role )
									<option value="{{ $role->name }}" @if(in_array($role->name, old('access',[]))) selected @endif> {{ $role->name }} </option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-6"></div>

				<div class="col-lg-12 mg-t-20">
					<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg> 
						Save
					</button>					
				</div>

			</div>

		</form>

    </div>
	
@endsection


@section('pagejs')

	<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>	
	<script type="text/javascript">
		
		$(document).on('change', '#store_type', function() {

			let _select_assignment = $(this).val();
			let _url = "";
			let _that = $(this);

			$.ajax({
				url 		: "{!! env('APP_URL') !!}/branch/department-list?type="+_select_assignment ,
				method 		: 'GET' ,
				success 	: function(res) {

					$('#assign_name').empty();

					let _html = '<option value=""> Select </option>';
					console.log(_select_assignment);
					$.each(res, function(i, o) {

						if(_select_assignment == 'head office') {
							_html += '<option value="'+o.DEPARTMENTS+'" data-store="'+o.STORE_CODE+'">'+ o.DEPARTMENTS +'</option>';
						} else {
							_html += '<option value="'+o.STORE_CODE+'">'+o.OPERATING_UNIT_NAME + ' - ' + o.ASSIGNED_STORE +'</option>';
						}

					});

					$('#assign_name').append(_html);

				}
			})

		});

		$(document).on('change', '#assign_name', function() {
			if($('#store_type').val() == 'head office') {
				$('#assign_to').val($('#assign_name').find(":selected").data('store'));
			} else {
				$('#assign_to').val($(this).val());
			}
		});

    	$("#access").select2({
		    tags: true,
		    tokenSeparators: [',']
		})
   

	</script>

@endsection