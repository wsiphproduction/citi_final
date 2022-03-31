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
					<li class="breadcrumb-item active" aria-current="page">Edit</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Edit Branch Group Form</h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<form method="POST" action="{{ route('branch-group.update', $branch_group->id) }}" class="col-lg-12">
	        @csrf
	        @method('PUT')
	        
	        <div class="row">
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Group Name</label>
						<div class="col-lg-7">
							<input type="text" name="name" class="form-control" value="{{ $branch_group->name }}">
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
									<option value="{{ strtolower($size->BRANCH_SIZE) }}"
										@if(strtolower($size->BRANCH_SIZE) == $branch_group->size) selected @endif>{{ $size->BRANCH_SIZE }}</option>
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
									<option value="{{ $bran->name }}" @if(in_array($bran->name, $branch_group->branch)) selected @endif>
										{{ ucfirst($bran->name) }} 
									</option>
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
							<input type="radio" name="status" value="1" @if($branch_group->status == 1) checked @endif> Active
						</label> &nbsp;&nbsp;&nbsp;&nbsp;
						<label>									
							<input type="radio" name="status" value="0" @if($branch_group->status == 0) checked @endif> Inactive
						</label>
					</div>
				</div>
			</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6 mg-t-20 text-right">
					<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
						Update
					</button>
				</div>
			</div>

		</form>

    </div>

    @if(count($branch_group->audits()->where('event', 'updated')->get()))

    <div class="row">
    
    	<div class="mg-t-50 col-lg-12">
    		
    		<h3> Branch Group Logs </h3>

    		<div class="dataTables_responsive">
    			
    			<table id="example1" class="table">
    				
    				<thead>
    					<th> Changes </th>
    					<th> Branch/Store </th>
    					<th> Created By </th>
    					<th> Created Date and Time </th>
    					<th> Updated By </th>
    					<th> Updated Date and Time </th>
    				</thead>

    				<tbody>
    					@foreach( $branch_group->audits()->where('event', 'updated')->get() as $audit )
    					<tr>
    						<td>
    							<ul style="list-style: none; padding: 0;">
    							@foreach($audit->new_values as $key => $value)
    								@if($key != 'updated_by')
	    								<li>({{ $key }}) - From {{ $audit->old_values[$key] }} - To {{ $value }}</li>
	    							@endif
    							@endforeach
    							</ul>
    						</td>
    						<td>
    							@foreach($branch_group->branch as $branch)
    								@if($loop->last)
    									{{ $branch }}
    								@else
    									{{ $branch }}, 
    								@endif
    							@endforeach
    						</td>
    						<td>
    							{{ $branch_group->created_by }}
    						</td>
    						<td>
    							{{ $audit->created_at }}
    						</td>
    						<td>
    							{{ array_key_exists('updated_by', $audit['new_values']) ? $audit['new_values']['updated_by'] : $branch_group->updated_by }}
    						</td>
    						<td>
    							{{ $audit->updated_at }}
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
	<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
    	$("#actions").select2({
		    tags: true,
		    tokenSeparators: [',']
		})
    </script>
@endsection
