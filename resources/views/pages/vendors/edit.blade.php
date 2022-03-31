@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Edit Vendor Form</h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<form method="POST" action="{{ route('vendors.update', $vendor->id) }}" class="col-lg-12" enctype="multipart/form-data">
	        @csrf
	        @method('PUT')
	        
	        <div class="row">

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="vendor" class="col-lg-5 col-form-label">Vendor/Company</label>
						<div class="col-lg-7">
							<input type="text" name="name" class="form-control" value="{{ old('name',$vendor->name) }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="branch" class="col-lg-5 col-form-label">Branch</label>
						<div class="col-lg-7">
							<select class="custom-select form-control" name="branch_id">
								<option value="">Select Branch</option>
								@foreach($branch as $br)
									<option value="{{ $br->id }}" @if(old('branch_id', $vendor->branch_id) == $br->id) selected @endif>{{ $br->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="tin" class="col-lg-5 col-form-label">Vat Registered TIN</label>
						<div class="col-lg-7">
							<input type="text" name="tin" class="form-control" value="{{ old('tin', $vendor->tin) }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="contact_number" class="col-lg-5 col-form-label">Contact Number</label>
						<div class="col-lg-7">
							<input type="text" name="contact_number" class="form-control" 
								value="{{ old('contact_number', $vendor->contact_number) }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="address" class="col-lg-5 col-form-label">Address</label>
						<div class="col-lg-7">
							<textarea rows="5" class="form-control" name="address">{{ old('address', $vendor->address) }}</textarea>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="attachment" class="col-lg-5 col-form-label">Attachment</label>
						<div class="col-lg-7">
							<input type="file" name="attachments[]" multiple  />
						</div>
					</div>


					<div class="col-lg-12 mg-t-50">
						<div data-label="Attachment" class="df-example" id="attachment-outter-wrapper">

							<table class="col-lg-12">
								<thead>
									<td width="90%"> Name </td>
									<td width="10%"> Action </td>
								</thead>
								<tbody>
									@forelse( $vendor->attachments as $attachment )
										<tr>
											<td><a href='{{ env("APP_URL")."/storage/vendors/{$vendor->id}/attachments/{$attachment->attachment}" }}' target="_blank">{{ $attachment->attachment }}</a></td>
											<td><a href="javascript:void(0);" data-id="{{ $attachment->id }}" data-from="vendor" 
												class="remove_attachment"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></a></td>
										</tr>
									@empty

									@endforelse
								</tbody>
							</table>
						
						</div>
					</div>

				</div>

				<div class="col-lg-6">
					<div class="form-group row">

						<label for="contact_number" class="col-lg-5 col-form-label">Status</label>						
						<div class="col-lg-7">
							<label>
								<input type="radio" name="status" value="1" @if(old('status', $vendor->status)==1) checked @endif> Active
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="radio" name="status" value="0" @if(old('status', $vendor->status)==0) checked @endif> Inactive
							</label>
						</div>

					</div>
				</div>							

				<div class="col-lg-12 mg-t-20 text-right">
					<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
						Update
					</button>
				</div>
			</div>

		</form>

    </div>

    @if(count($vendor->audits()->where('event', 'updated')->get()))

    <div class="row">
    
    	<div class="mg-t-50 col-lg-12">
    		
    		<h3> Vendor Logs </h3>

    		<div class="dataTables_responsive">
    			
    			<table id="example1" class="table">
    				
    				<thead>
    					<th> Changes </th>
    					<th> Created By </th>
    					<th> Created Date and Time </th>
    					<th> Updated By </th>
    					<th> Updated Date and Time </th>
    				</thead>

    				<tbody>
    					@foreach( $vendor->audits()->where('event', 'updated')->get() as $audit )
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
    							{{ $vendor->created_by }}
    						</td>
    						<td>
    							{{ $audit->created_at }}
    						</td>
    						<td>
    							{{ array_key_exists('updated_by', $audit['new_values']) ? $audit['new_values']['updated_by'] : $vendor->updated_by }}
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

	<script type="text/javascript">

		$(document).on('click', '.remove_attachment', function () {

			var _that = $(this);

			if(confirm('Are you sure you want to delete this attachment?')) {

				$.ajax({

					url 	: "{!! env("APP_URL") !!}"+"/vendors/"+$(this).data('id'),
					headers: {'X-CSRF-Token': '{!! csrf_token() !!}' },
					method 	: 'DELETE' ,
					success : function(res) {

						_that.parent().parent().remove();

					}

				});

			}

		});

	</script>

@endsection