@extends('layouts.app')

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
                	<input type="text" readonly value="{{ $pcfr->vendor }}" class="form-control">
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
                  	<input type="text" class="form-control" id="doc_type" readonly 
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
                    			<td> {{ $pcv->pcv_no }} </td>
                    			<td> to be addedd </td>
                    			<td> {{ $pcv->account_name }} </td>
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
                          <td class="tx-bold text-right align-middle">Total Amount</td>
                          <td>
                            <input type="number" class="form-control tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" 
                                value="{{ $pcfr->pcv()->sum('amount') }}" readonly="" name="amount" id="amount">
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
                  		id="temporary_slip" name="temporary_slip" value="{{ $pcfr->total_temp_slip }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="total-replenishment" class="col-lg-5 col-form-label">Total Replenishment</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" 
                  		id="total_replenishment" name="total_replenishment" 
                  		value="{{ $pcfr->total_replenishment }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="atm-balance" class="col-lg-5 col-form-label">ATM Balance</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control text-right" id="atm_balance" name="atm_balance"
                  		readonly value="{{ $pcfr->atm_balance }}">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="pending-replenishment" class="col-lg-5 col-form-label">Pending Replenishment</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" 
                  		id="pending_replenishment" name="pending_replenishment" readonly
                  			value="{{ $pcfr->total_pending_replenishment }}">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="cash-on-hand" class="col-lg-5 col-form-label">Cash on Hand</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control text-right" id="cash_on_hand" name="cash_on_hand"
                  		value="{{ $pcfr->cash_on_hand }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="unreplenished" class="col-lg-5 col-form-label">Unreplenished</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" id="unreplenished" 
                  		name="unreplenished" value="{{ $pcfr->total_unreplenished }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
           	<div class="form-group row">
                <label for="pcf-accounted-for" class="col-lg-5 col-form-label">PCF Accounted For</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" 
                  		id="pcf_accounted_for" name="pcf_accounted_for" value="{{ $pcfr->total_accounted }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
          	<div class="form-group row">
	            <label for="unapproved-pcvs" class="col-lg-5 col-form-label">Unapproved PCVs</label>
	            <div class="col-lg-7">
	              	<input type="number" class="form-control bd-0 bd-bottom text-right" 
	              		id="unapproved_pcvs" name="unapproved_pcvs" value="{{ $pcfr->total_unapproved_pcv }}" readonly>
	            </div>
          	</div>
        </div>

        <div class="col-lg-6">
	        <div class="form-group row">
	            <label for="pcf-accountability" class="col-lg-5 col-form-label">PCF Accountability</label>
	            <div class="col-lg-7">
	              	<input type="number" class="form-control bd-0 bd-bottom text-right" 
	              		id="pcf_accountability" name="pcf_accountability" value="{{ $pcfr->pcf_accountability }}" readonly>
	            </div>
	        </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="returned-pcvs" class="col-lg-5 col-form-label">Returned PCVs</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" 
                  		id="returned_pcvs" name="returned_pcvs" value="{{ $pcfr->total_returned_pcv }}" readonly>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
          	<div class="form-group row">
	            <label for="overage-shortage" class="col-lg-5 col-form-label">Overage/Shortage</label>
	            <div class="col-lg-7">
	              	<input type="number" class="form-control bd-0 bd-bottom text-right" 
	              		id="overage_shortage" name="overage_shortage" value="{{ $pcfr->pcf_diff }}" readonly>
	            </div>
          	</div>
        </div>

        <div class="col-lg-6"></div>

        <div class="col-lg-12">
          	<hr class="mg-t-20 mg-b-40">
        </div>

        <div class="col-lg-12 mg-t-50">
			<div data-label="Attachment" class="df-example" id="attachment-outter-wrapper">
			
				<table class="table dataTable no-footer mn-wd-550-f">

                    <thead>
                        <tr role="row">
                            <th class="tx-uppercase">Attachment Type</th>
                            <th class="tx-uppercase">Document</th>
                            <th class="tx-uppercase">Doc. Ref No.</th>
                            <th class="tx-uppercase">Doc. Date</th>
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
				
			</div>
		</div>

    	<div class="col-lg-12 mg-t-20"> 
			@if($pcfr->status == 'saved')
	            <form action="{{ route('requestor.pcfr.status-update', $pcfr->id) }}" method="POST" class="d-lg-inline">
	                @csrf
	                @method('PUT')
	                <input type="hidden" name="action" value="submitted">
	            
	                <button type="submit" class="btn btn-primary mr-lg-1 mb-2 mb-lg-0 d-lg-inline wd-100p wd-lg-150"> 
	                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send mg-r-5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>Submit
	                </button>                           
	            </form>
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