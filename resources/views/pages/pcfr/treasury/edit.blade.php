@extends('layouts.app')

@section('pagecss')

    <style type="text/css">
        
        .aside-header {
            display: none;
        }

    </style>

@endsection

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="{{ route('requestor.pcfr.index') }}">Petty Cash Fund Replenishment</a></li>
					<li class="breadcrumb-item active" aria-current="page">Show</li>
				</ol>
			</nav>
		</div>

	</div>	

	<div class="row">
		
        <form method="POST" action="{{ route('treasury.pcfr.update', $pcfr->id) }}" id="pcfr_form">
            @csrf
            @method('PUT')
            
            <div class="row">

                <input type="hidden" name="pcfr_attachments" id="pcfr_attachments" value="{{ old('pcfr_attachments', $pcfr->attachments) }}" />
                <input type="hidden" name="status" id="status">

        		<div class="col-lg-6">
                    <div class="form-group row">
                        <label for="pcfr-no" class="col-lg-5 col-form-label">PCFR No.</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control" id="pcfr_no" name="pcfr_no" readonly
                          		value="{{ $pcfr->pcfr_no }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="branch" class="col-lg-5 col-form-label">Branch</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control" id="branch" name="branch" 
                          		value="{{ $pcfr->branch }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="requested-by" class="col-lg-5 col-form-label">Requested By</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control" id="requested_by" name="requested_by" 
                          		value="{{ $pcfr->user->username }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="vendor" class="col-lg-5 col-form-label">Vendor</label>
                        <div class="col-lg-7">
                            <input type="text" name="vendor" class="form-control" value="{{ $pcfr->vendor }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="doc-date" class="col-lg-5 col-form-label">Doc Date</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control" id="date_created" name="date_created" readonly
                          		value="{{ \Carbon\Carbon::parse($pcfr->doc_date)->toFormattedDateString() }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="doc-type" class="col-lg-5 col-form-label">Doc Type</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control" id="doc_type" 
                          		name="doc_type" value="{{ $pcfr->doc_type }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="batch-id" class="col-lg-5 col-form-label">Batch ID</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control" id="batch_no" name="batch_no" readonly
                          		value="{{ $pcfr->batch_no }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mg-b-20">
                    <div data-label="Period" class="df-example">
                        <div class="form-group row">
                          	<label for="period-date-from" class="col-lg-5 col-form-label">Period Date From</label>
                          	<div class="col-lg-7">
                            	<input type="text" class="form-control" readonly 
                            		value="{{ \Carbon\Carbon::parse($pcfr->from)->toFormattedDateString() }}">
                          	</div>
                        </div>
                        <div class="form-group row mb-0">
                          	<label for="period-date-to" class="col-lg-5 col-form-label">Period Date To</label>
                          	<div class="col-lg-7">
                            	<input type="text" class="form-control" readonly
                            		value="{{ \Carbon\Carbon::parse($pcfr->to)->toFormattedDateString() }}">
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
                            	@forelse( $pcfr->pcv as $pcv ) 
                            		<tr>
                            			<td> 
                                            <a href="{{ route('pcfr.show-pcv', $pcv->id) }}" target="_blank"> {{ $pcv->pcv_no }} </a> 
                                        </td>
                            			<td> {{ $pcv->description }} </td>
                            			<td> {{ $pcv->account_name  }} </td>
                            			<td> {{ $pcv->user->branch->name }} </td>
                            			<td> {{ $pcv->amount }} </td>
                            		</tr>
                            	@empty
                            		<tr>
                            			<td colspan="5" class="text-center"> No Pcv Found </td>
                            		</tr>
                            	@endforelse
                          	</tbody>
                            <tfoot>
                                <tr role="row">
                                  <td class="sorting_1"></td>
                                  <td></td>
                                  <td></td>
                                  <td class="tx-bold align-middle">Total Amount</td>
                                  <td>
                                    <input type="number" class="form-control tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" 
                                        value="{{ number_format($pcfr->pcv()->sum('amount'), 2, '.', ',') }}" readonly="" name="amount" id="amount">
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
                          	<input type="text" class="form-control bd-0 bd-bottom text-right" 
                          		id="temporary_slip" name="temporary_slip" value="{{ number_format($pcfr->total_temp_slip, 2, '.', ',') }}" >
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="total-replenishment" class="col-lg-5 col-form-label">Total Replenishment</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control bd-0 bd-bottom text-right" 
                          		id="total_replenishment" name="total_replenishment" 
                          		value="{{ number_format($pcfr->total_replenishment, 2, '.', ',') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="atm-balance" class="col-lg-5 col-form-label">ATM Balance</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control text-right" id="atm_balance" name="atm_balance"
                          		value="{{ number_format($pcfr->atm_balance, 2, '.', ',') }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="pending-replenishment" class="col-lg-5 col-form-label">Pending Replenishment</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control bd-0 bd-bottom text-right" 
                          		id="pending_replenishment" name="pending_replenishment" readonly
                          			value="{{ number_format($pcfr->total_pending_replenishment, 2, '.', ',') }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="cash-on-hand" class="col-lg-5 col-form-label">Cash on Hand</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control text-right" id="cash_on_hand" name="cash_on_hand"
                          		value="{{ number_format($pcfr->cash_on_hand, 2, '.', ',') }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="unreplenished" class="col-lg-5 col-form-label">Unreplenished</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control bd-0 bd-bottom text-right" id="unreplenished" 
                          		name="unreplenished" value="{{ number_format($pcfr->total_unreplenished, 2, '.', ',') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                   	<div class="form-group row">
                        <label for="pcf-accounted-for" class="col-lg-5 col-form-label">PCF Accounted For</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control bd-0 bd-bottom text-right" 
                          		id="pcf_accounted_for" name="pcf_accounted_for" value="{{ number_format($pcfr->total_accounted, 2, '.', ',') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                  	<div class="form-group row">
        	            <label for="unapproved-pcvs" class="col-lg-5 col-form-label">Unapproved PCVs</label>
        	            <div class="col-lg-7">
        	              	<input type="text" class="form-control bd-0 bd-bottom text-right" 
        	              		id="unapproved_pcvs" name="unapproved_pcvs" value="{{ number_format($pcfr->total_unapproved_pcv, 2, '.', ',') }}" readonly>
        	            </div>
                  	</div>
                </div>

                <div class="col-lg-6">
        	        <div class="form-group row">
        	            <label for="pcf-accountability" class="col-lg-5 col-form-label">PCF Accountability</label>
        	            <div class="col-lg-7">
        	              	<input type="text" class="form-control bd-0 bd-bottom text-right" 
        	              		id="pcf_accountability" name="pcf_accountability" value="{{ number_format($pcfr->pcf_accountability, 2, '.', ',') }}" readonly>
        	            </div>
        	        </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="returned-pcvs" class="col-lg-5 col-form-label">Returned PCVs</label>
                        <div class="col-lg-7">
                          	<input type="text" class="form-control bd-0 bd-bottom text-right" 
                          		id="returned_pcvs" name="returned_pcvs" value="{{ number_format($pcfr->total_returned_pcv, 2, '.', ',') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                  	<div class="form-group row">
        	            <label for="overage-shortage" class="col-lg-5 col-form-label">Overage/Shortage</label>
        	            <div class="col-lg-7">
        	              	<input type="text" class="form-control bd-0 bd-bottom text-right" 
        	              		id="overage_shortage" name="overage_shortage" value="{{ number_format($pcfr->pcf_diff, 2, '.', ',') }}" readonly>
        	            </div>
                  	</div>
                </div>

            </div>

        </form>

        <div class="col-lg-6"></div>

        <div class="col-lg-12">
          	<hr class="mg-t-20 mg-b-40">
        </div>

        <!-- <div class="col-lg-12">
			<div data-label="Current Attachments" class="df-example">
			
				<table class="table mn-wd-550-f">

                    <thead>
                        <tr role="row">
                            <th class="tx-uppercase">Attachment Type</th>
                            <th class="tx-uppercase">Document</th>
                            <th class="tx-uppercase">Doc. Ref No.</th>
                            <th class="tx-uppercase">Doc. Date</th>
                            <th class="tx-uppercase">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach( $pcfr->attachments as $attachment )
                            <tr role="row">
                                <td>{{ $attachment->type }}</td>
                                <td>
                                    <a href='{{ \Storage::url("pcfr/{$pcfr->pcfr_no}/{$attachment->attachment}") }}' target="_blank">
                                        {{ $attachment->attachment }}
                                    </a>
                                </td>
                                <td>{{ $attachment->ref }}</td>
                                <td>{{ \Carbon\Carbon::parse($attachment->date)->toFormattedDateString() }}</td>
                                <td>
                                    <a class="nav-link p-0 pl-2" href="javascript:void(0);" class="remove_curr_attachment">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
				
			</div>
		</div> -->

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
            <button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit"
                data-action="saved" data-id="{{ $pcfr->id }}"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Saved
            </button>   
			@if($pcfr->status == 'saved' || \Str::contains($pcfr->status , 'disapproved' ))	            
                <button type="submit" class="btn btn-primary mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit"
                data-action="submitted" data-id="{{ $pcfr->id }}"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send mg-r-5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>   
                    Submit
                </button>     
	        @endif
	    </div>

    </div>
	
@endsection

@section('pagejs')
	
	<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
	<script type="text/javascript">
		
		var dateFormat = 'mm/dd/yy';
		var account_attachments = [];
		var current_id = 0;
		var pcv_ids = [];
        var _total = {!! $pcfr->total_temp_slip !!} + {!! $pcfr->atm_balance !!} + {!! $pcfr->cash_on_hand !!};
        var _total_replenishment = $('#total_replenishment').val();
        var _pending_replenishment = $('#pending_replenishment').val();
        var _unreplenished = $('#unreplenished').val();
        var _unapproved_pcvs = $('#unapproved_pcvs').val();
        var _returned_pcvs = $('#returned_pcvs').val();

        $(document).ready(function() {

            setTimeout(function(){               
                if($('#pcv_attachments').val() != '')
                    getAttachments();
            }, 2000);

        });
      	
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
			
			// format data of attachments
			$('.attachment-wrapper').each(function(i, o) {

				if(ctr == 0) {
													
					account_attachments.push({
						'type'			: $('#type').val() ,
						'ref'			: $('#docref').val() ,
						'date'			: $('#docdate').val() ,
						'attachment'	: $('#docrefstring').val()
					});					

				} else {

					if(ctr<10) { 

						account_attachments.push({
							'type'			: $('#type_0'+ctr).val() ,
							'ref'			: $('#docref_0'+ctr).val() ,
							'date'			: $('#docdate_0'+ctr).val() ,
							'attachment'	: $('#docrefstring_0'+ctr).val()
						});

					} else {

						account_attachments.push({
							'type'			: $('#type_'+ctr).val() ,
							'ref'			: $('#docref_'+ctr).val() ,
							'date'			: $('#docdate_'+ctr).val() ,
							'attachment'	: $('#docrefstring_'+ctr).val()
						});

					}

				}

				ctr++;

			});

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

            var _pcf_accounted_for = accounting.unformat(_total_replenishment) + accounting.unformat(_pending_replenishment) + accounting.unformat(_unreplenished) + accounting.unformat(_unapproved_pcvs) + accounting.unformat(_returned_pcvs);

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
            $(this).val(accounting.format(atm_bal, 2, ',', '.'));

        });

        $(document).on('blur', '#cash_on_hand', function() {

            var _pcf_accounted_for = accounting.unformat(_total_replenishment) + accounting.unformat(_pending_replenishment) + accounting.unformat(_unreplenished) + accounting.unformat(_unapproved_pcvs) + accounting.unformat(_returned_pcvs);

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
            $(this).val(accounting.format(cash_on_hand, 2, ',', '.'));

        });

        $(document).on('blur', '#temporary_slip', function() {

            var _pcf_accounted_for = accounting.unformat(_total_replenishment) + accounting.unformat(_pending_replenishment) + accounting.unformat(_unreplenished) + accounting.unformat(_unapproved_pcvs) + accounting.unformat(_returned_pcvs);

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
            $(this).val(accounting.format(temp_slip, 2, ',', '.'));

        });

        $(document).on('click', '.btn-submit', function() {

            var ctr = 0;
            account_attachments = [];
            
            // format data of attachments
            $('.attachment-wrapper').each(function(i, o) {

                if(ctr == 0) {
                                                    
                    account_attachments.push({
                        'type'          : $('#type').val() ,
                        'ref'           : $('#docref').val() ,
                        'date'          : $('#docdate').val() ,
                        'attachment'    : $('#docrefstring').val()
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
                            'type'          : $('#type_0'+ctr).val() ,
                            'ref'           : $('#docref_0'+ctr).val() ,
                            'date'          : $('#docdate_0'+ctr).val() ,
                            'attachment'    : $('#docrefstring_0'+ctr).val()
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
                            'type'          : $('#type_'+ctr).val() ,
                            'ref'           : $('#docref_'+ctr).val() ,
                            'date'          : $('#docdate_'+ctr).val() ,
                            'attachment'    : $('#docrefstring_'+ctr).val()
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
            //$('#pcv_ids').val(JSON.stringify(pcv_ids));
            // check if can save multiple transaction accounts
            $('#status').val($(this).data('action'));
            $('#pcfr_form').submit();

        });

        function getAttachments() {

            let account_attachments = JSON.parse($('#pcfr_attachments').val());
            let _base_url = "{!! env('APP_URL') !!}";

            $.each(account_attachments, function(i, data){

                if( i > 0 ) {
                    
                    nextElement($('#attachment-inner-wrapper'));

                    if(i<10){
                        $('#type_0'+i).val(data.type);
                        $('#docrefstring_0'+i).val(data.attachment);
                        $('#docrefstring_0'+i).siblings("label").text(data.attachment);
                        $('#docdata_0'+i).val(moment(data.date).format('YYYY-MM-DD'));
                        $('#docref_0'+i).val(data.ref);
                    } else {
                        $('#type_'+i).val(data.type);
                        $('#docrefstring_'+i).val(data.attachment);
                        $('#docrefstring_'+i).siblings("label").text(data.attachment);
                        $('#docdate_'+i).val(moment(data.date).format('YYYY-MM-DD'));
                        $('#docref_'+i).val(data.ref);
                    }

                } else {

                    $('#type').val(data.type);
                    $('#docrefstring').val(data.attachment);
                    $('#docrefstring').siblings("label").text(data.attachment);
                    $('#docdate').val(moment(data.date).format('YYYY-MM-DD'));
                    $('#docref').val(data.ref);

                }

            });


        }

	</script>

@endsection