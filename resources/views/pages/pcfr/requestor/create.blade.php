@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="{{ route('requestor.pcfr.index') }}">Petty Cash Fund Replenishment</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Petty Cash Fund Replenishment Form</h4>
		</div>

	</div>	

	<form method="POST" action="{{ route('requestor.pcfr.store') }}" id="pcfr_form">
		@csrf

		<input type="hidden" name="pcv_ids" id="pcv_ids">
		<input type="hidden" name="pcfr_attachments" id="pcfr_attachments">
		<input type="hidden" name="status" id="status">

	<div class="row">
		
		<div class="col-lg-6">
            <div class="form-group row">
                <label for="pcfr-no" class="col-lg-5 col-form-label">PCFR No.</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="pcfr_no" name="pcfr_no" readonly
                  		value="{{ \App\Models\Pcfr::generatePCFRNumber() }}">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="branch" class="col-lg-5 col-form-label">Branch</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="branch" name="branch" 
                  		value="{{ auth()->user()->branch->name }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="requested-by" class="col-lg-5 col-form-label">Requested By</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="requested_by" name="requested_by" 
                  		value="{{ auth()->user()->username }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="vendor" class="col-lg-5 col-form-label">Vendor</label>
                <div class="col-lg-7">                	
                	<input type="text" name="vendor" class="form-control" value="{{ $vendor->VENDOR_SITE_ID }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="doc-date" class="col-lg-5 col-form-label">Doc Date</label>
                <div class="col-lg-7">
                  	<input type="date" class="form-control" id="date_created" name="date_created" 
                  		value="{{ date('Y-m-d') }}">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="doc-type" class="col-lg-5 col-form-label">Doc Type</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="doc_type" name="doc_type" value="Invoice">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="batch-id" class="col-lg-5 col-form-label">Batch ID</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="batch_no" name="batch_no" readonly
                  		value="{{ \App\Models\Pcfr::generatePCFRBatchNumber() }}">
                </div>
            </div>
        </div>

        <div class="col-lg-6 mg-b-20">
            <div data-label="Period" class="df-example">
                <div class="form-group row">
                  	<label for="period-date-from" class="col-lg-5 col-form-label">Period Date From</label>
                  	<div class="col-lg-7">
                    	<input type="text" class="form-control" id="periodDateFrom" name="period_date_from" placeholder="From"
                    		value="{{ \Carbon\Carbon::parse($pcv_first->date_created)->format('d-m-Y') }}" readonly>
                  	</div>
                </div>
                <div class="form-group row mb-0">
                  	<label for="period-date-to" class="col-lg-5 col-form-label">Period Date To</label>
                  	<div class="col-lg-7">
                    	<input type="text" class="form-control" id="periodDateTo" name="period_date_to" placeholder="To"
                    		value="{{ \Carbon\Carbon::parse($pcv_last->date_created)->format('d-m-Y') }}" readonly>
                  	</div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
          	<hr class="mg-t-10 mg-b-30">
        </div>

        <div class="col-lg-12">
            <div class="dataTables_responsive">
                <table class="table dataTable no-footer" id="included_pcvs">
                  	<thead>
                      	<tr role="row">
	                        <th class="wd-20p sorting_1 tx-uppercase">PCV No.</th>
	                        <th class="wd-20p tx-uppercase">Description</th>
	                        <th class="wd-20p tx-uppercase">Account</th>
	                        <th class="wd-20p tx-uppercase">Store</th>
	                        <th class="wd-20p tx-uppercase">Amount</th>
	                    </tr>
                  	</thead>
                  	<tbody>
                    	
                  		@foreach($pcvs as $pcv)

                  			<tr>
								<td>{{ $pcv->pcv_no }}</td>
								<td>{{ $pcv->description }}</td>
								<td>{{ $pcv->account_name }}</td>
								<td>{{ $pcv->user->branch->name }}</td>
								<td>{{ $pcv->amount }}</td>
							</tr>

                  		@endforeach

                  	</tbody>

                  	<tfoot>
	                    <tr role="row">
	                      <td class="sorting_1"></td>
	                      <td></td>
	                      <td></td>
	                      <td class="tx-bold align-middle">Total Amount</td>
	                      <td>
	                        <input type="text" class="form-control tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" 
	                        	value="{{ number_format($pcvs_sum, 2, '.', ',') }}" readonly="" name="amount" id="amount">
	                      </td>
	                      <td></td>
	                    </tr>
	                  </tfoot>

                </table>
            </div>
        </div>

        <div class="col-lg-12">
          	<hr class="mg-t-30 mg-b-30">
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="temporary-slip" class="col-lg-5 col-form-label">Unliquidated Temporary Slip</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control text-right" 
                  		id="temporary_slip" name="temporary_slip" value="0.00">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="total-replenishment" class="col-lg-5 col-form-label">Total Replenishment</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control bd-0 bd-bottom text-right" 
                  		id="total_replenishment" name="total_replenishment" 
                  		value="{{ number_format($total_replenishment, 2, '.', ',') }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="atm-balance" class="col-lg-5 col-form-label">ATM Balance</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control text-right" id="atm_balance" name="atm_balance" min="0" step="1" value="0.00">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="pending-replenishment" class="col-lg-5 col-form-label">Pending Replenishment</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control bd-0 bd-bottom text-right" 
                  		id="pending_replenishment" name="pending_replenishment" value="{{ number_format($pending_replenishment, 2, '.', ',') }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="cash-on-hand" class="col-lg-5 col-form-label">Cash on Hand</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control text-right" id="cash_on_hand" name="cash_on_hand" min="0" step="1" value="0.00">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="unreplenished" class="col-lg-5 col-form-label">Unreplenished</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control bd-0 bd-bottom text-right" id="unreplenished" 
                  		name="unreplenished" value="{{ number_format($unreplenished, 2, '.', ',') }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
           	<div class="form-group row">
                <label for="pcf-accounted-for" class="col-lg-5 col-form-label">PCF Accounted For</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control bd-0 bd-bottom text-right" 
                  		id="pcf_accounted_for" name="pcf_accounted_for" value="{{ number_format($pcf_accounted_for, 2, '.', ',') }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
          	<div class="form-group row">
	            <label for="unapproved-pcvs" class="col-lg-5 col-form-label">Unapproved PCVs</label>
	            <div class="col-lg-7">
	              	<input type="text" class="form-control bd-0 bd-bottom text-right" 
	              		id="unapproved_pcvs" name="unapproved_pcvs" value="{{ number_format($unapproved_pcvs, 2, '.', ',') }}" readonly>
	            </div>
          	</div>
        </div>

        <div class="col-lg-6">
	        <div class="form-group row">
	            <label for="pcf-accountability" class="col-lg-5 col-form-label">PCF Accountability</label>
	            <div class="col-lg-7">
	              	<input type="text" class="form-control bd-0 bd-bottom text-right" 
	              		id="pcf_accountability" name="pcf_accountability" value="{{ number_format($pcv_accountability, 2, '.', ',') }}" readonly>
	            </div>
	        </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="returned-pcvs" class="col-lg-5 col-form-label">Returned PCVs</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control bd-0 bd-bottom text-right" 
                  		id="returned_pcvs" name="returned_pcvs" value="{{ number_format($returned_pcvs, 2, '.', ',') }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
          	<div class="form-group row">
	            <label for="overage-shortage" class="col-lg-5 col-form-label">Overage/Shortage</label>
	            <div class="col-lg-7">
	              	<input type="text" class="form-control bd-0 bd-bottom text-right" 
	              		id="overage_shortage" name="overage_shortage" value="{{ number_format($overage_shortage, 2, '.', ',') }}" readonly>
	            </div>
          	</div>
        </div>

        <div class="col-lg-6"></div>

        <div class="col-lg-12">
          	<hr class="mg-t-20 mg-b-40">
        </div>

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
									<option selected="">--Select--</option>
									<option value="ATM Slip">ATM Slip</option>
									<option value="Withdrawal Slip">Withdrawal Slip</option>
									<option value="Cash Count Sheet">Cash Count Sheet</option>
								</select>

								</div>
							</div>

							<div class="col-lg-3">
								<div class="form-group">
									<label class="d-block tx-14">Document</label>
									<div class="custom-file">
										<input type="file" class="custom-file-input document-f" id="document" data-from="pcfr">
										<label class="custom-file-label" for="document">Choose file</label>
										<input type="hidden" id="docrefstring" />
									</div>
								</div>
							</div>

							<div class="col-lg-3">
								<div class="form-group">
									<label for="doc-ref-date" class="d-block tx-14">Doc. Ref Date</label>
									<input type="date" class="form-control" id="docdate" value="{{ date('Y-m-d') }}">
								</div>
							</div>

							<div class="col-lg-2">
								<div class="form-group">
									<label for="doc-ref-no" class="d-block tx-14">Doc. Ref No.</label>
									<input type="text" class="form-control" id="docref">
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

        <div class="col-lg-12 mg-t-20">
          	<button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-savesubmit"
          		data-action="saved">
            	<i class="mg-r-5" data-feather="save"></i> Save
          	</button>
          	<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-savesubmit"
          		data-action="submitted">
            	<i class="mg-r-5" data-feather="send"></i> Submit
          	</button>
        </div>

    </div>
	
	</form>
@endsection

@section('pagejs')
	
	<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
	<script type="text/javascript">
		
		var dateFormat = 'mm/dd/yy';
		var account_attachments = [];
		var current_id = 0;
		var pcv_ids = {!! $pcvs->pluck('id') !!};
		var _total_replenishment = $('#total_replenishment').val();
		var _pending_replenishment = $('#pending_replenishment').val();
		var _unreplenished = $('#unreplenished').val();
		var _unapproved_pcvs = $('#unapproved_pcvs').val();
		var _returned_pcvs = $('#returned_pcvs').val();


      	// periodFrom = $('#periodDateFrom')
	      // 	.datepicker().on('change', function() {
	      //   	periodTo.datepicker('option','minDate', getDate( this ) );	        	
	      // 	}),

      	// periodTo = $('#periodDateTo')
      	// 	.datepicker().on('change', function() {
       //  		periodFrom.datepicker('option','maxDate', getDate( this ) );
      	// 	});

      	$(document).on('click', '#btn-add-account-attachment', function() {

			nextElement($('#attachment-inner-wrapper'));

		});

		$(document).on('click', '.remove_attachment', function() {

			$(this).parent().parent().parent().parent().parent().remove();

			current_id --;

		});

		$(document).on('change', '.document-f', function() {

			var _that = $(this);
			var formData = new FormData(); // Currently empty
			var from = $(this).data('from');
			formData.append('file',$(this)[0].files[0]);
			formData.append('from', from);			

			$.ajax({
				url : '{!! route("attachments.upload") !!}',
				headers: {'X-CSRF-Token': '{!! csrf_token() !!}' },
				type: 'POST' ,
				data: formData ,
				cache : false ,
				processData: false ,
				contentType: false ,
				success: function(res) {

	 				var curr_doc_id = _that.attr('id');
					var curr_doc_num = curr_doc_id.match(/\d+/);
					var _input_id = null;

					if( curr_doc_num == null) {
						_input_id = 'docrefstring';
						$('#'+_input_id).val(res);				
					} else {
						_input_id = 'docrefstring_'+ curr_doc_num[0];
						$('#'+_input_id).val(res);
					}

					$(_that).next().html(res);

				}
			})

		});

		$(document).on('click', '.btn-savesubmit', function() {

			var ctr = 0;
			account_attachments = [];

			// format data of attachments
			$('.attachment-wrapper').each(function(i, o) {

				if(ctr == 0) {
													
					account_attachments.push({
						'type'			: $('#type').val() ,
						'ref'			: $('#docref').val() ,
						'date'			: $('#docdate').val() ,
						'attachment'	: $('#docrefstring').val()
					});		

					if($('#type').val() == '' || $('#type').val() == undefined) {
						$('#type').addClass('is-invalid');
					}		
					if($('#docref').val() == '' || $('#docref').val() == undefined) {
						$('#docref').addClass('is-invalid');
					}	
					if($('#docrefstring').val() == '' || $('#docrefstring').val() == undefined) {
						$('#document').addClass('is-invalid');
					}			

				} else {

					if(ctr<10) { 

						account_attachments.push({
							'type'			: $('#type_0'+ctr).val() ,
							'ref'			: $('#docref_0'+ctr).val() ,
							'date'			: $('#docdate_0'+ctr).val() ,
							'attachment'	: $('#docrefstring_0'+ctr).val()
						});

						if($('#type_0'+ctr).val() == '' || $('#type_0'+ctr).val() == undefined) {
							$('#type_0'+ctr).addClass('is-invalid');
						}		
						if($('#docref_0'+ctr).val() == '' || $('#docref_0'+ctr).val() == undefined) {
							$('#docref_0'+ctr).addClass('is-invalid');
						}	
						if($('#docrefstring_0'+ctr).val() == '' || $('#docrefstring_0'+ctr).val() == undefined) {
							$('#document_0'+ctr).addClass('is-invalid');
						}

					} else {

						account_attachments.push({
							'type'			: $('#type_'+ctr).val() ,
							'ref'			: $('#docref_'+ctr).val() ,
							'date'			: $('#docdate_'+ctr).val() ,
							'attachment'	: $('#docrefstring_'+ctr).val()
						});

						if($('#type_'+ctr).val() == '' || $('#type_'+ctr).val() == undefined) {
							$('#type_'+ctr).addClass('is-invalid');
						}		
						if($('#docref_'+ctr).val() == '' || $('#docref_'+ctr).val() == undefined) {
							$('#docref_'+ctr).addClass('is-invalid');
						}	
						if($('#docrefstring_'+ctr).val() == '' || $('#docrefstring_'+ctr).val() == undefined) {
							$('#document_'+ctr).addClass('is-invalid');
						}	

					}

				}

				ctr++;

			});

			let is_null_val = false;

            console.log(account_attachments);
            if(account_attachments.length>0){
                $.each(account_attachments, function(i, e) {
                    $.each(e, function(o, u){
                        if(u =='' || u == undefined) is_null_val = true;
                    });
                });
            }

            if(is_null_val) {
                
                alert('Some data on your request is missing please check it again');
                return false;
                
            }

			$('#pcfr_attachments').val(JSON.stringify(account_attachments));
			$('#pcv_ids').val(JSON.stringify(pcv_ids));
			// check if can save multiple transaction accounts
			$('#status').val($(this).data('action'));
			$('#pcfr_form').submit();

		});

      	function getDate( element ) {
	        var date;
	        try {
	          date = $.datepicker.parseDate( dateFormat, element.value );
	        } catch( error ) {
	          date = null;
	        }
        	return date;
      	}

      	function nextElement(element){

	        var newElement = element.clone();
	        var id = current_id+1;
	        current_id = id;
	        
	        if(id <10)id = "0"+id;
	        
	        newElement.attr("id",element.attr("id").split("_")[0]+"_"+id);

	        var field 	= $(('#type'), newElement).attr("id");
	        var field1 	= $(('#document'), newElement).attr("id");
	        var field2 	= $(('#docdate'), newElement).attr("id");
	        var field3 	= $(('#docref'), newElement).attr("id");
	        var field4 	= $(('#docrefstring'), newElement).attr("id");	        

	        $('#type', newElement).attr("id", field.split("_")[0]+"_"+id );
	        $('#document', newElement).attr("id", field1.split("_")[0]+"_"+id );
	        $('#docdate', newElement).attr("id", field2.split("_")[0]+"_"+id ).val(new moment().format('DD-MM-YYYY'));
	        $('#docref', newElement).attr("id", field3.split("_")[0]+"_"+id ).val('');
			$('#docrefstring', newElement).attr("id", field4.split("_")[0]+"_"+id ).val('');

	        newElement.appendTo($("#attachment-outter-wrapper"));
	        $('#'+field4.split("_")[0]+"_"+id).siblings('label').html('');

	    }

	    $(document).on('blur', '#atm_balance', function() {

            var _pcf_accounted_for = parseFloat(accounting.unformat(_total_replenishment)) + parseFloat(accounting.unformat(_pending_replenishment)) + parseFloat(accounting.unformat(_unreplenished)) + parseFloat(accounting.unformat(_unapproved_pcvs)) + accounting.unformat(parseFloat(_returned_pcvs));

            let atm_bal = $(this).val();
            if(atm_bal == ''){ 
                atm_bal = 0;
                $(this).val(0);
            }

            let overage_shortage = $('#overage_shortage').val();
            let pcf_accountability = accounting.unformat($('#pcf_accountability').val());

            _pcf_accounted_for = _pcf_accounted_for + parseFloat(accounting.unformat($('#cash_on_hand').val())) + parseFloat(accounting.unformat($('#temporary_slip').val()));


            let new_pcf_accounted_for = parseFloat(atm_bal) + parseFloat(_pcf_accounted_for);
            let new_overage_shortage = parseFloat(pcf_accountability) - parseFloat(new_pcf_accounted_for);

            $('#pcf_accounted_for').val(accounting.format(new_pcf_accounted_for, 2,',', '.'));
            $('#overage_shortage').val(accounting.format(new_overage_shortage, 2,',', '.'));

        });

        $(document).on('blur', '#cash_on_hand', function() {

            var _pcf_accounted_for = parseFloat(accounting.unformat(_total_replenishment)) + parseFloat(accounting.unformat(_pending_replenishment)) + parseFloat(accounting.unformat(_unreplenished)) + parseFloat(accounting.unformat(_unapproved_pcvs)) + accounting.unformat(parseFloat(_returned_pcvs));

            let cash_on_hand = $(this).val();
            if(cash_on_hand == ''){ 
                cash_on_hand = 0;
                $(this).val(0);
            }

            let overage_shortage = $('#overage_shortage').val();
            let pcf_accountability = accounting.unformat($('#pcf_accountability').val());

            _pcf_accounted_for = _pcf_accounted_for + parseFloat(accounting.unformat($('#atm_balance').val())) + parseFloat(accounting.unformat($('#temporary_slip').val()));

            let new_pcf_accounted_for = parseFloat(cash_on_hand) + parseFloat(_pcf_accounted_for);
            let new_overage_shortage = parseFloat(pcf_accountability) - parseFloat(new_pcf_accounted_for);

            $('#pcf_accounted_for').val(accounting.format(new_pcf_accounted_for, 2,',', '.'));
            $('#overage_shortage').val(accounting.format(new_overage_shortage, 2,',', '.'));

        });

        $(document).on('blur', '#temporary_slip', function() {

            var _pcf_accounted_for = parseFloat(accounting.unformat(_total_replenishment)) + parseFloat(accounting.unformat(_pending_replenishment)) + parseFloat(accounting.unformat(_unreplenished)) + parseFloat(accounting.unformat(_unapproved_pcvs)) + accounting.unformat(parseFloat(_returned_pcvs));

            let temp_slip = $(this).val();
            if(temp_slip == ''){ 
                temp_slip = 0;
                $(this).val(0);
            }
            
            let overage_shortage = $('#overage_shortage').val();
            let pcf_accountability = accounting.unformat($('#pcf_accountability').val());

            _pcf_accounted_for = _pcf_accounted_for + parseFloat(accounting.unformat($('#atm_balance').val())) + parseFloat(accounting.unformat($('#cash_on_hand').val()));

            let new_pcf_accounted_for = parseFloat(temp_slip) + parseFloat(_pcf_accounted_for);
            let new_overage_shortage = parseFloat(pcf_accountability) - parseFloat(new_pcf_accounted_for);

            $('#pcf_accounted_for').val(accounting.format(new_pcf_accounted_for, 2,',', '.'));
            $('#overage_shortage').val(accounting.format(new_overage_shortage, 2,',', '.'));

        });


	</script>

@endsection