@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('account-matrix.index') }}">Account Matrix</a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Edit Account Matrix Form</h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<form method="POST" action="{{ route('account-matrix.update', $matrix->id) }}" class="col-lg-12">
	        @csrf
	        @method('PUT')
	        
	        <div class="row">
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Account Name</label>
						<div class="col-lg-7">
							<select class="form-control" name="account">
								<option value=""> Select Account </option>
								@foreach( \App\Models\Account::getAccounts() as $account )
									<option value="{{ $account['FLEX_VALUE_MEANING'] }} | {{ $account['DESCRIPTION'] }}"
										@if($matrix->number == $account['FLEX_VALUE_MEANING']) selected @endif> 
										{{ $account['DESCRIPTION'] }} 
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
						<label for="name" class="col-lg-5 col-form-label">Amount</label>
						<div class="col-lg-7">
							<input type="number" name="amount" class="form-control" id="amount"  step="1" min="0" value="{{ old('amount', $matrix->amount) }}" 
								@if(old('regardless', $matrix->regardless)) disabled @endif/>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">&nbsp;</label>
						<div class="col-lg-7">
							<label>
								<input type="checkbox" id="beyond" name="beyond" value="1" 
									@if(old('beyond', $matrix->beyond)) checked @endif> Beyond
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="checkbox" id="regardless" name="regardless" value="1"
									@if(old('regardless', $matrix->regardless)) checked @endif> Regardless
							</label>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Approval Code</label>
						<div class="col-lg-7">
							<label>
								<input type="radio" name="code" value="1" 
									@if(old('code',$matrix->code) == 1 || is_null(old('code', $matrix->code))) checked @endif> Yes
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="radio" name="code" value="0" 
									@if(old('code',$matrix->code) == 0 && !is_null(old('code',$matrix->code))) checked @endif> No
							</label>
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
								<input type="radio" name="status" value="1" 
									@if(old('status',$matrix->status) == 1 || is_null(old('status',$matrix->status))) checked @endif> Active

							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="radio" name="status" value="0" 
									@if(old('status',$matrix->status) == 0 && !is_null(old('status',$matrix->status))) checked @endif> Inactive
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

    @if(count($matrix->audits()->where('event', 'updated')->get()))

    <div class="row">
    
    	<div class="mg-t-50 col-lg-12">
    		
    		<h3> Account Matrix Logs </h3>

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
    					@foreach( $matrix->audits()->where('event', 'updated')->get() as $audit )
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
    							{{ $matrix->created_by }}
    						</td>
    						<td>
    							{{ $audit->created_at }}
    						</td>
    						<td>
    							{{ array_key_exists('updated_by', $audit['new_values']) ? $audit['new_values']['updated_by'] : $matrix->updated_by }}
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
	
	$(document).on('click', '#regardless', function() {
		if($(this).is(':checked')) {
			$('#amount').attr('disabled', 'disabled');
		} else {
			$('#amount').attr('disabled', false);
		}
	});

</script>

@endsection