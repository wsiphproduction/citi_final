@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="{{ route('treasury.pcfr.index') }}">Petty Cash Fund Replenishment</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Petty Cash Fund Replenishment Form</h4>
		</div>

	</div>	

	<form method="POST" action="{{ route('treasury.pcfr.store') }}" id="pcfr_form">
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
                	<select class="form-control" name="vendor">
                		<option value=""> Select Vendor </option>
                		@foreach($vendors as $vendor)
                			<option value="{{ $vendor->name }}">{{ $vendor->company_name }}</option>
                		@endforeach
                	</select>
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
                    		value="{{ \Carbon\Carbon::parse($pcv_first->date_created)->format('Y-m-d') }}">
                  	</div>
                </div>
                <div class="form-group row mb-0">
                  	<label for="period-date-to" class="col-lg-5 col-form-label">Period Date To</label>
                  	<div class="col-lg-7">
                    	<input type="text" class="form-control" id="periodDateTo" name="period_date_to" placeholder="To"
                    		value="{{ \Carbon\Carbon::parse($pcv_last->date_created)->format('Y-m-d') }}">
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
	                      <td class="tx-bold text-right align-middle">Total Amount</td>
	                      <td>
	                        <input type="number" class="form-control tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" 
	                        	value="{{ $pcvs_sum }}" readonly="" name="amount" id="amount">
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
                <label for="temporary-slip" class="col-lg-5 col-form-label">Temporary Slip</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" 
                  		id="temporary_slip" name="temporary_slip" value="{{ $unliquidated_ts1 }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="total-replenishment" class="col-lg-5 col-form-label">Total Replenishment</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" 
                  		id="total_replenishment" name="total_replenishment" 
                  		value="00000.00" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="atm-balance" class="col-lg-5 col-form-label">ATM Balance</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control" id="atm_balance" name="atm_balance">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="pending-replenishment" class="col-lg-5 col-form-label">Pending Replenishment</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" 
                  		id="pending_replenishment" name="pending_replenishment" value="{{ $for_replenishment1 }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="cash-on-hand" class="col-lg-5 col-form-label">Cash on Hand</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control" id="cash_on_hand" name="cash_on_hand">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="unreplenished" class="col-lg-5 col-form-label">Unreplenished</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" id="unreplenished" 
                  		name="unreplenished" value="{{ $unreplenished1 }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
           	<div class="form-group row">
                <label for="pcf-accounted-for" class="col-lg-5 col-form-label">PCF Accounted For</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" 
                  		id="pcf_accounted_for" name="pcf_accounted_for" value="{{ $pcv_accounted }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
          	<div class="form-group row">
	            <label for="unapproved-pcvs" class="col-lg-5 col-form-label">Unapproved PCVs</label>
	            <div class="col-lg-7">
	              	<input type="number" class="form-control bd-0 bd-bottom text-right" 
	              		id="unapproved_pcvs" name="unapproved_pcvs" value="{{ $unapproved_pcvs1 }}" readonly>
	            </div>
          	</div>
        </div>

        <div class="col-lg-6">
	        <div class="form-group row">
	            <label for="pcf-accountability" class="col-lg-5 col-form-label">PCF Accountability</label>
	            <div class="col-lg-7">
	              	<input type="number" class="form-control bd-0 bd-bottom text-right" 
	              		id="pcf_accountability" name="pcf_accountability" value="{{ $pcv_accountability }}" readonly>
	            </div>
	        </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="returned-pcvs" class="col-lg-5 col-form-label">Returned PCVs</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" 
                  		id="returned_pcvs" name="returned_pcvs" value="{{ $returned_pcvs1 }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
          	<div class="form-group row">
	            <label for="overage-shortage" class="col-lg-5 col-form-label">Overage/Shortage</label>
	            <div class="col-lg-7">
	              	<input type="number" class="form-control bd-0 bd-bottom text-right" 
	              		id="overage_shortage" name="overage_shortage" value="{{ $overage_shortage }}" readonly>
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

      	periodFrom = $('#periodDateFrom')
	      	.datepicker().on('change', function() {

	        	periodTo.datepicker('option','minDate', getDate( this ) );
	        	$('#included_pcvs tbody').empty();
	        	if( $('#periodDateTo').val() != "" && $(this).val() != "" ) {
	        		pcv_ids = [];
	        		$.ajax({

	        			url 	: "{!! env('APP_URL')!!}"+"/pcfr/requestor/generatepcrf?from="+$(this).val()+'&to='+$('#periodDateTo').val() ,
	        			method	: 'GET' ,
	        			success : function(res) {

	        				let _html  = '';
	        					
	        					if(res.pcvs.length>0) {

	        						$.each(res.pcvs, function(i, o) {
	        							_html += '<tr>';
	        							_html += '<td>'+o.pcv_no+'</td>';
	        							_html += '<td>'+o.description+'</td>';
	        							_html += '<td>'+o.account_name+'</td>';
	        							_html += '<td>'+o.user.branch.name+'</td>';
	        							_html += '<td>'+o.amount+'</td>';
	        							_html += '</tr>';
	        							console.log(o);
	        							pcv_ids.push(o.id);
	        						});

	        					} 
	        					
	        					$('#included_pcvs tbody').append(_html);	 
	        					$('#temporary_slip').val(res.unliquidated_ts);
	        					$('#total_replenishment').val(res.for_replenishment);
	        					$('#pending_replenishment').val(res.pending_replenishment);
	        					$('#unreplenished').val(res.unreplenished);
	        					$('#unapproved_pcvs').val(res.unapproved_pcvs);
	        					$('#returned_pcvs').val(res.returned_pcvs);
	        					$('#pcf_accounted_for').val(res.pcf_accounted_for);
	        					$('#pcf_accountability').val(res.pcf_accountability);
	        					$('#overage_shortage').val(res.over_short);	 

	        			}

	        		})

	        	}

	      	}),

      	periodTo = $('#periodDateTo')
      		.datepicker().on('change', function() {
        		periodFrom.datepicker('option','maxDate', getDate( this ) );
        		$('#included_pcvs tbody').empty();
        		if( $('#periodDateFrom').val() != "" && $(this).val() != "" ) {
        			pcv_ids = [];
	        		$.ajax({

	        			url 	: "{!! env('APP_URL')!!}"+"/pcfr/requestor/generatepcrf?from="+$('#periodDateFrom').val()+'&to='+$(this).val() ,
	        			method	: 'GET' ,
	        			success : function(res) {

	        				let _html  = '';
	        					
	        					if(res.pcvs.length>0) {

	        						$.each(res.pcvs, function(i, o) {
	        							_html += '<tr>';
	        							_html += '<td>'+o.pcv_no+'</td>';
	        							_html += '<td>'+o.description+'</td>';
	        							_html += '<td>'+o.account_name+'</td>';
	        							_html += '<td>'+o.user.branch.name+'</td>';
	        							_html += '<td>'+o.amount+'</td>';
	        							_html += '</tr>';

	        							console.log(o);
	        							pcv_ids.push(o.id);
	        						});

	        					} 
	        					
	        					$('#included_pcvs tbody').append(_html);	 
	        					$('#temporary_slip').val(res.unliquidated_ts);
	        					$('#total_replenishment').val(res.for_replenishment);
	        					$('#pending_replenishment').val(res.pending_replenishment);
	        					$('#unreplenished').val(res.unreplenished);
	        					$('#unapproved_pcvs').val(res.unapproved_pcvs);
	        					$('#returned_pcvs').val(res.returned_pcvs);
	        					$('#pcf_accounted_for').val(res.pcf_accounted_for);
	        					$('#pcf_accountability').val(res.pcf_accountability);
	        					$('#overage_shortage').val(res.over_short);	        					

	        			}

	        		})

	        	}

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
	        $('#docdate', newElement).attr("id", field2.split("_")[0]+"_"+id ).val(new moment().format('YYYY-MM-DD'));
	        $('#docref', newElement).attr("id", field3.split("_")[0]+"_"+id ).val('');
			$('#docrefstring', newElement).attr("id", field4.split("_")[0]+"_"+id ).val('');

	        newElement.appendTo($("#attachment-outter-wrapper"));

	    }


	</script>

@endsection