@extends('layouts.app')

@section('pagecss')
    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
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
		
		<form method="POST" action="{{ route('users.update', $user->id) }}" class="col-lg-12" id="user-form">
			@csrf
			@method('PUT')

			<input type="hidden" name="remarks" id="hidden-remarks">

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
							<input type="password" class="form-control" id="password" name="password">
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
							<select class="form-control" name="store_type" id="store_type">
								<option value=""> Select </option>								
								<option value="stores" @if($user->store_type == 'stores') selected @endif>Store</option>
								<option value="distribution center" @if($user->store_type == 'distribution center') selected @endif>DC</option>
								<option value="head office" data-store="00000" @if($user->store_type == 'head office') selected @endif>SSC</option>
							</select>
							<input type="hidden" name="assign_to" id="assign_to" value="{{ $user->assign_to }}">
						</div>
						<div class="col-lg-4">
							<select class="form-control" name="assign_name" id="assign_name" > 
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
					<button type="button" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150"
						data-toggle="modal" data-target="#userUpdateRemarks">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
						Update
					</button>					
				</div>

			</div>

		</form>

    </div>

    <div class="modal fade" id="userUpdateRemarks" tabindex="-1" role="dialog" 
		aria-labelledby="userUpdateRemarks" aria-modal="true">

		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content tx-14">
				
				<div class="modal-header">
					<h6 class="modal-title" id="exampleModalLabel3">Remarks</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="row">
						
						<div class="col-lg-12">
							<div class="form-group">
								<label for="remarks" class="d-block">Remarks</label>
								<textarea id="user-remarks" class="form-control" rows="3"></textarea>
							</div>
						</div>

					</div>
				</div>

				<div class="modal-footer">
					<button class="btn btn-brand-01 d-inline-block tx-13 tx-uppercase" id="btn_updateWithRemarks">Update</button>
					<button type="button" class="btn btn-white tx-13 tx-uppercase" data-target="#userUpdateRemarks" data-toggle="modal" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>

	</div>


    @if(count($user->audits()->where('event', 'updated')->get()))

    <div class="row">
    
    	<div class="mg-t-50 col-lg-12">
    		
    		<h3> User Logs </h3>

    		<div class="dataTables_responsive">
    			
    			<table id="example1" class="table">
    				
    				<thead>
    					<th> Changes </th>
    					<th> Created By </th>
    					<th> Created Date and Time </th>
    					<th> Updated By </th>
    					<th> Updated Date and Time </th>
    					<th> Remarks </th>
    				</thead>

    				<tbody>
    					@foreach( $user->audits()->where('event', 'updated')->get() as $audit )
    					<tr>
    						<td>
    							<ul style="list-style: none; padding: 0;">
    							@foreach($audit->new_values as $key => $value)
    								@if($key != 'updated_by' && $key != 'remarks')
	    								<li>({{ $key }}) - From {{ $audit->old_values[$key] }} - To {{ $value }}</li>
	    							@endif
    							@endforeach
    							</ul>
    						</td>
    						<td>
    							{{ $user->created_by }}
    						</td>
    						<td>
    							{{ $audit->created_at }}
    						</td>
    						<td>
    							{{ array_key_exists('updated_by', $audit['new_values']) ? $audit['new_values']['updated_by'] : $user->updated_by }}
    						</td>
    						<td>
    							{{ $audit->updated_at }}
    						</td>
    						<td>
    							
    							@foreach($audit->new_values as $key => $value)
    								@if($key == 'remarks')
	    								{{ $value }} 
	    							@endif
    							@endforeach

    						</td>
    					</tr>
    					@endforeach
    				</tbody>

    			</table>

    		</div>

    	</div>

    </div>
	
    @endif

@endsection


@section('pagejs')
	
	<script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
	<script type="text/javascript">
			
		$(document).ready(function(){
			$('#store_type').change();
		});

		$(document).on('change', '#store_type', function() {
			console.log('called');
			let _select_assignment = $(this).val();
			console.log(_select_assignment);
			let _url = "";

			$.ajax({
				url 		: "{!! env('APP_URL') !!}/branch/department-list?type="+_select_assignment ,
				method 		: 'GET' ,
				success 	: function(res) {

					$('#assign_name').empty();

					let _html = '<option value=""> Select </option>';
					
					$.each(res, function(i, o) {

						if(_select_assignment == 'head office') {
							if('{!! $user->assign_name !!}' == o.DEPARTMENTS) {
								_html += '<option value="'+o.DEPARTMENTS+'" data-store="'+o.STORE_CODE+'" selected>'+ o.DEPARTMENTS +'</option>';
							} else {
								_html += '<option value="'+o.DEPARTMENTS+'" data-store="'+o.STORE_CODE+'">'+ o.DEPARTMENTS +'</option>';				
							}
						} else {
							if('{!! $user->assign_name !!}' == o.STORE_CODE) {
								_html += '<option value="'+o.STORE_CODE+'" selected>'+o.OPERATING_UNIT_NAME + ' - ' + o.ASSIGNED_STORE +'</option>';
							} else {
								_html += '<option value="'+o.STORE_CODE+'">'+o.OPERATING_UNIT_NAME + ' - ' + o.ASSIGNED_STORE +'</option>';
							}
						}

					});

					$('#assign_name').append(_html);

				}
			});			
			
			if($('#store_type').val() == 'head office') {
				$('#assign_to').val("00000");
			}
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

		$(function(){
			'use strict'

			$('#example1').DataTable({
				"ordering": false,
        		"info":     false,
        		"searching": false,
        		"bLengthChange": false,
			});
		});

		$(document).on('click', '#btn_updateWithRemarks', function() {

			let _remarks = $('#user-remarks').val();

			if(_remarks == '') {
				alert('Remarks is required');
				return false;
			}

			$('#hidden-remarks').val(_remarks);
			$('#user-form').submit();


		});

    </script>

@endsection