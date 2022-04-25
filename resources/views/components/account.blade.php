@foreach( $account_data['fields'] as $field )

	<div class="col-lg-6">
	  	<div class="form-group row">
	  		@if($field['name'] != 'hidden')
		    	<label for="account" class="col-lg-5 col-form-label">{{ $field['name'] }}</label>
		    @endif
	    	<div class="col-lg-7">

	    		@if($field['type'] == 'select')

	    				@php
	    					$isChargeTo = false;
							if( $field['name'] == 'Vendor' ) { 
								$detailss = json_decode(json_encode(\App\Models\Vendor::getVendors()->toArray()) , true);
							} elseif( $field['name'] == 'Charge To' ) {			
								$isChargeTo = true;					
								$detailss = json_decode(json_encode(\App\Helpers\Helper::chargeTo()->toArray()) , true);	
							}
						@endphp

					@if(!$isChargeTo)
						<select class="custom-select custom-inputs" id="{{ strtolower(str_replace(' ', '_', $field['name'])) }}" 
							data-name="{{ strtolower(str_replace(' ', '_', $field['name'])) }}">
								<option value="">Select</option>
							@foreach( $detailss as $data )
								<option value="{{ $data['name'] }}">{{ $data['name'] }}</option>
							@endforeach
						</select>
					@else
						<select class="custom-select custom-inputs" id="{{ strtolower(str_replace(' ', '_', $field['name'])) }}" 
							data-name="{{ strtolower(str_replace(' ', '_', $field['name'])) }}">
								<option value="">Select</option>
							@foreach( $detailss as $data )
								<option value="{{ $data['CUSTOMER_NAME'] }}">{{ $data['CUSTOMER_NAME'] }}</option>
							@endforeach
						</select>
					@endif

				@elseif($field['type'] == 'text' || $field['type'] == 'number')

					@if($account_data['name'] == 'Delivery Charges' && $field['name'] == 'POS Transaction No')
						<input type="{{ $field['type'] }}" data-name="{{ strtolower(str_replace(' ', '_', $field['name'])) }}" 
							class="form-control custom-inputs" id='pos_transaction_no' disabled>
					@else 
						<input type="{{ $field['type'] }}" data-name="{{ strtolower(str_replace(' ', '_', $field['name'])) }}" 
							class="form-control custom-inputs">
					@endif

				@elseif($field['type'] == 'date')

					@if($account_data['name'] == 'Staff House Rental')
						<input type="{{$field['type']}}" data-name="{{ strtolower(str_replace(' ', '_', $field['name'])) }}" 
							class="form-control custom-inputs" value="{{ date('Y-m-d') }}" 
							id="{{ strtolower(str_replace(' ', '_', $field['name'])) }}">
					@else
						<input type="{{$field['type']}}" data-name="{{ strtolower(str_replace(' ', '_', $field['name'])) }}" 
							class="form-control custom-inputs" value="{{ date('Y-m-d') }}">
					@endif

				@elseif($field['type'] == 'textarea')

					<textarea data-name="{{ strtolower(str_replace(' ', '_', $field['name'])) }}" class="form-control custom-inputs" rows="5"></textarea>

				@elseif($field['type'] == 'checkbox' )

					<input type="{{ $field['type'] }}" data-name="{{ strtolower(str_replace(' ', '_', $field['name'])) }}" 
						class="custom-inputs" @if($field['name'] == 'From POS') id='from_pos' @endif>

				@elseif($field['type'] == 'hidden')

					<input type="{{$field['type']}}" class="form-control custom-inputs">

				@elseif($field['type'] == 'file')
					<div class="col-lg-12">
						<input type="{{$field['type']}}" data-name="{{ strtolower(str_replace(' ', '_', $field['name'])) }}"  
							class="custom-file-input document-f" data-from="account">
						<label class="custom-file-label" for="document">Choose file</label>						
						<input type="hidden" class="custom-inputs" 
							data-name="{{ strtolower(str_replace(' ', '_', $field['name'])) }}"  
							id="{{ strtolower(str_replace(' ', '_', $field['name'])) }}_attachment">
					</div>
				@endif


			</div>
	  	</div>
	</div>

@endforeach

@if($account_data['add_multiple'])
	
	@if($account_data['name'] != 'Installation')
		<div class="col-lg-12 mg-b-20">

			<button type="button" class="btn btn-brand-01 d-inline wd-150 tx-13 mg-t-20" id="btn-add-account-details"
			@if($account_data['name'] == 'Stripping Charge') style="display: none !important;" @endif>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
				stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
				<line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add
			</button>
		
		</div>
	@endif

	<div class="col-lg-12">

		<div class="dataTables_responsive">
	
		<table id="account-transactions-list" class="table dataTable no-footer">
                
            <thead>
                <tr role="row">
                	@foreach($account_data['table_fields']['rows'] as $row)
                		<td data-rowname="{{ strtolower(str_replace(' ', '_', $row)) }}" class="tbl-header tx-uppercase"> {{ $row }} </td>
                	@endforeach
                </tr>
            </thead>

            <tbody>
            	
            </tbody>

        </table>
		
	    </div>

	</div>	


@endif


@if($account_data['has_attachment_section'] && $account_data['name'] != 'Delivery Charges')

	
	<div class="col-lg-12 mg-t-50">
		<div data-label="Attachment" class="df-example" id="attachment-outter-wrapper">
	
			<button type="button" class="btn btn-brand-01 d-inline wd-150 tx-13 mg-t-20" id="btn-add-account-attachment">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
				stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
				<line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> Add
			</button>

			<div class="attachment-wrapper mg-t-20" id="attachment-inner-wrapper">
				<div class="pd-15 pt-4 border mg-b-20">
					<div class="row row-xs">
			
						<div class="col-lg-3">
							<div class="form-group">
							
							<label for="attachment-type" class="d-block tx-14">Attachment Type</label>
							
							<select class="custom-select" id="type">
								<option value='' selected>--Select--</option>
								<option value="acknowledgement receipt">Acknowledgement Receipt</option>
								<option value="temporary slip">Temporary Slip</option>
								<option value="delivery instruction">Delivery Instruction</option>
								<option value="statement of account/bill">Statement of Account/Bill</option>
								<option value="extra labor summary">Extra Labor Summary</option>
								<option value="completion report">Completion Report</option>
								<option value="pcv signed">PCV Signed</option>
								<option value="back office copy">Back Office Copy</option>
								<option value="out of work authorization form">Out of Work Authorization Form</option>
								<option value="overtime form">Overtime Form</option>
								<option value="approved travel liquidation">Approved Travel Liquidation</option>
								<option value="fuel requisition slip">Fuel Requisition Slip</option>
								<option value="others">Others</option>
							</select>

							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group">
								<label class="d-block tx-14">Document</label>
								<div class="custom-file">
									<input type="file" class="custom-file-input document-f" id="document" data-from="pcv">
									<label class="custom-file-label" for="document">Choose file</label>
									<input type="hidden" id="docrefstring" />
								</div>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group">
								<label for="doc-ref-date" class="d-block tx-14">Doc. Ref Date</label>
								<input type="text" class="form-control doc-reft-data ref-date" id="docdate" value="{{ date('m/d/Y') }}">
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group">
								<label for="doc-ref-no" class="d-block tx-14">Doc. Ref No.</label>
								<input type="text" class="form-control doc-reft-data ref-doc" id="docref">
							</div>
						</div>

						<div class="col-lg-1">
							<label class="d-block tx-14 tx-left tx-lg-right">Action</label>
							<nav class="nav table-options justify-content-start justify-content-lg-end mg-t-15">
								<a class="nav-link p-0 pl-2 remove_attachment" href="javascript:void(0);" title="Remove">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
								</a>
							</nav>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>


@endif	

<script type="text/javascript">
	$("#charge_to").select2({
	    tags: true,
	    tokenSeparators: [',']
	});
	$("#vendor").select2({
	    tags: true,
	    tokenSeparators: [',']
	});
	
</script>