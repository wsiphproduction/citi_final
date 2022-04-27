@extends('layouts.app')

@section('pagecss')

    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <style type="text/css">

    	#ts_res_wrap {
    		padding: 10px;
    		display: none;
    	}

    	#ts_res_wrap ul {
    		list-style: none;
    		padding:  0;
    		max-height: 100px;
    		overflow-y: scroll;
    	}

    	#ts_res_wrap ul li {
    		padding: 5px;
    	}

    	#ts_res_wrap ul li:hover {
    		background: #999;
    		cursor: pointer;
    	}

    	.hide { display: none !important;  }
    	.show { display: block !important; }

    </style>

@endsection

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="{{ route('requestor.pcv.index') }}">Petty Cash Voucher</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Petty Cash Voucher Form  </h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<form role="form" method="POST" action="{{ route('requestor.pcv.store') }}" class="col-lg-12" id="pcv_form">
			@csrf

			<input type="hidden" name="pcv_attachments" id="pcv_attachments" value="{{ old('pcv_attachments') }}" />
			<input type="hidden" name="pcv_accounts" id="pcv_accounts" value="{{ old('pcv_accounts') }}" />
			<input type="hidden" name="pcv_action" id="pcv_action" value="{{ old('pcv_action') }}" />
			<input type="hidden" name="total_amount" id="total_amount" value="{{ old('total_amount') }}" />

		<div class="row">

			<div class="col-lg-12 mg-b-20">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input static-inputs" id="with-temporary-slip" name="withslip"
						@if(old('withslip')) checked @endif>
					<label class="custom-control-label" for="with-temporary-slip">With Temporary Slip</label>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="slip-no" class="col-lg-5 col-form-label">Slip No.</label>
					<div class="col-lg-7">
						<select name="ts_no" class="custom-select form-control" @if(is_null(old('withslip'))) disabled @endif id="ts_no">
							<option value="">Select</option>
							@foreach($ts as $slip)
								<option value="{{$slip->ts_no}}" data-name="{{$slip->account_name}}" 
									data-description="{{$slip->description}}"
									@if(old('ts_no') == $slip->ts_no) selected @endif>{{ $slip->ts_no }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>

			<div class="col-lg-6 d-none">
				<div class="form-group row">
					<label for="change" class="col-lg-5 col-form-label">Change</label>
					<div class="col-lg-7">
						<input type="number" class="form-control static-inputs @if($errors->has('change')) is-invalid @endif" 
							id="change" name="change" value="{{ old('change', 0) }}" 
							step="1" min="0" placeholder="0.00">
					</div>
				</div>
			</div>

	        <div class="col-lg-12">
	          	<hr class="mg-t-10 mg-b-30">
	        </div>

	        <div class="col-lg-6">
	          	<div class="form-group row">
	            	<label for="account" class="col-lg-5 col-form-label">Account</label>
	            	<div class="col-lg-7">

						<select class="custom-select static-inputs @if($errors->has('account_name')) is-invalid @endif" 
							id="account_name" name="account_name">
							<option value="">Select Account</option>
							@foreach( \App\Models\Account::getAccounts() as $account )
								@if(!$account['others'])
								<option value="{{ $account['name'] }}" @if(old('account_name')==$account['name']) selected @endif> 
									{{ $account['name'] }} 
								</option>
								@endif								
							@endforeach
								<option value="others" @if(old('account_name_other') != '') selected @endif>Others</option>
						</select>
						<select class="mg-t-20 custom-select static-inputs @if($errors->has('account_name_other')) is-invalid @endif @if(old('account_name_other') != '') show @else hide @endif" 
							id="account_name_other" name="account_name_other">
							<option value="">Select Account</option>
							@foreach( \App\Models\Account::getAccounts() as $account )
								@if($account['others'])
								<option value="{{ $account['name'] }}" @if(old('account_name_other')==$account['name']) selected @endif> 
									{{ $account['name'] }} 
								</option>
								@endif
							@endforeach
						</select>
					</div>
	          	</div>
	        </div>

	        <div class="col-lg-6">
	          	<div class="row row-sm">
	            <div class="col-lg-8">
	              	<div class="form-group row">
	                	<label for="date_created" class="col-lg-2 col-form-label">Date</label>
	                	<div class="col-lg-10">
	                  		<input type="date" class="form-control static-inputs" id="date_created" name="date_created" 
	                  			value="{{ old('date_created' , date('Y-m-d')) }}" readonly>
	                	</div>
	              	</div>
	            </div>
		            <div class="col-lg-4">
		              	<div class="tx-13">
		                	<a href="#copyFrom" class="btn btn-white mr-lg-1 d-block wd-100p mb-3 mb-lg-0" id="copy-from" 
		                		data-toggle="modal" data-backdrop="static">Copy from</a>
		              	</div>
		            </div>
	          	</div>
	        </div>

	        <div class="col-lg-6">
	          	<div class="form-group row">
		            <label for="pcv_no" class="col-lg-5 col-form-label">PCV No.</label>
		            <div class="col-lg-7">
		              	<input type="text" class="form-control" id="pcv_no" name="pcv_no"
		              		value="{{ old('pcv_no' ,\App\Models\Pcv::generatePCVNumber()) }}" readonly>
		            </div>
	          	</div>
	        </div>

	        <div class="col-lg-6">
	          	<div class="form-group row">
		            <label for="pcv_no" class="col-lg-5 col-form-label">Description</label>
		            <div class="col-lg-7">
		              	<textarea class="form-control @if($errors->has('description')) is-invalid @endif" id="pcv_description" 
		              		name="description" rows="5">{{ old('description') }}</textarea>
		            </div>
	          	</div>
	        </div>

	        <div class="col-lg-6"></div>

	        <div class="col-lg-12">
	          	<hr class="mg-t-10 mg-b-30">
	        </div>

	        <div class="col-lg-12">
	        		
	        	<div class="row" id="account-wrapper">
	        		
	        		

	        	</div>

	        </div>

	        <div class="col-lg-12 mg-t-20">
	          	<button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-savesubmit"
	          		data-action="saved">
	            	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
	            	Save
	          	</button>
	          	<button type="button" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-savesubmit"
	          		data-action="submitted">
	            	<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-inbox"><polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>
	            	Submit
	          	</button>
	        </div>

	    </div>

    	</form>

    </div>

    <!-- Copy From Modal -->
	<div class="modal fade" id="copyFrom" tabindex="-1" role="dialog" aria-labelledby="copyFromModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl mw-100 px-3 px-lg-5" role="document">
			<div class="modal-content tx-14">
			
				<div class="modal-header">
					<h6 class="modal-title" id="exampleModalLabel3">Cancelled PCVs</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="dataTables_responsive">
						
						<table class="table dataTable no-footer" id="cancelled-pcvs">
							
							<thead>
								<tr role="row">
									<th class="wd-10p sorting_1 tx-uppercase">PCV No.</th>
									<th class="wd-20p tx-uppercase">Description</th>
									<th class="wd-15p tx-uppercase">Date Cancelled</th>
									<th class="wd-15p tx-uppercase">Cancelled By</th>
									<th class="wd-10p tx-uppercase">Remarks</th>
									<th class="wd-15p tx-uppercase">Date Approved</th>
									<th class="wd-15p tx-uppercase">Approved By</th>
								</tr>
							</thead>
						<tbody>

						</tbody>

						</table>

					</div>
				</div>

			</div>
		</div>
	</div><!-- Copy From Modal -->

	<!-- Copy From Modal -->
	<div class="modal fade" id="pop_ups_wrap" tabindex="-1" role="dialog" aria-labelledby="copyFromModal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal mw-100 px-3 px-lg-5" role="document">
			<div class="modal-content tx-14">
			
				<div class="modal-header">
					<h6 class="modal-title" id="pop_ups_label">POS Transactions</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="dataTables_responsive">
						
						<table class="table dataTable no-footer" id="pop_ups_inner">
														

						</table>						

					</div>
					<br>

					<div class="text-right">
						<button class="btn btn-primary" id="btn-save-pos-trans"> Save </button>
						<div class="clearfix"></div>
					</div>
				
				</div>

			</div>
		</div>
	</div><!-- Copy From Modal -->

	<div class="modal fade effect-scale" id="for_message" tabindex="-1" 
		role="dialog" aria-labelledby="for_message" aria-modal="true">

		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content tx-14">
				
				<div class="modal-header">
					<h6 class="modal-title" id="exampleModalLabel3" id="message_title">Confirmation Message</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>

				<div class="modal-body">
					<p class="mb-0" id="message_content"></p>
				</div>

			</div>
		</div>

	</div>

	<div class="modal fade" id="deliveryChargeModal" tabindex="-1" role="dialog" 
		aria-labelledby="deliveryChargeModal" aria-modal="true">

		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content tx-14">
				
				<div class="modal-header">
					<h6 class="modal-title" id="exampleModalLabel3">Input Approval Code</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>

				<div class="modal-body">
					<div class="row">
						
						<div class="col-lg-12">
							<div class="form-group">
								<label for="approval-code" class="d-block">Approval Code</label>
								<input type="text" class="form-control" id="approval_code">
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<label for="approver-name" class="d-block">Approver's Name</label>
								<select class="custom-select" id="approver_name">
									<option value="">--Select--</option>
									@foreach($area_manager as $manager) 
										<option value="{{ $manager->username }}"> {{ $manager->username }} </option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<label for="remarks" class="d-block">Remarks</label>
								<textarea id="remarks" name="remarks" class="form-control" rows="3"></textarea>
							</div>
						</div>

					</div>
				</div>

				<div class="modal-footer">
					<button class="btn btn-brand-01 d-inline-block tx-13 tx-uppercase" id="btn_approval_code">Approve</button>
					<button type="button" class="btn btn-white tx-13 tx-uppercase" id="btn_disapprove_code" data-target="#deliveryChargeModal" data-toggle="modal" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>

	</div>
	
@endsection

@section('pagejs')
	
	<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
	<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
	<script type="text/javascript">
		
		var current_id = 0;
		var account_transactions = [];
		var account_attachments = [];
		var pos_items = [];
		var typingTimer;
		var doneTypingInterval = 2000;
		var attachment_eexist = false;

		$(document).ready(function() {

			if($('#account_name').val() != '' && $('#account_name').val() != 'others')
				$('#account_name').change();

			if($('#account_name_other').val() != '' )
				$('#account_name_other').change();

			setTimeout(function(){
				if($('#pcv_accounts').val() != '')
					getAccountTransactions();

				if($('#pcv_attachments').val() != '')
					getAttachments();
			}, 2000);

		});

		$(document).on('click', '#from_pos', function() {
			if( $(this).is(':checked') ) {
				$('#pos_transaction_no').prop('disabled', false);
			} else {
				$('#pos_transaction_no').prop('disabled', 'disabled');
			}
		});

		$(document).on('change', '#with-temporary-slip', function() {

			if($(this).is(':checked')) {

				$('#ts_no').removeAttr('disabled');

			} else {

				$('#ts_no').attr('disabled', 'disabled');
				$('#ts_no').prop("selectedIndex", 0);
				$('#account_name').prop("selectedIndex", 0).change();
				$('#tsNo').empty();
				$('#pcv_description').val('');

			}			

		});

		$(document).on('click', '#btn-add-account-attachment', function() {

			nextElement($('#attachment-inner-wrapper'));

		});

		$(document).on('click', '.remove_attachment', function() {

			$(this).parent().parent().parent().parent().parent().remove();

			current_id --;

		});

		$(document).on('click', '.remove_account_attachment', function() {

			account_transactions.splice($(this).index('.remove_account_attachment'), 1);
			$(this).parent().parent().parent().remove();
			calculateTotal();

		});

		$(document).on('change', '#account_name', function() {

			$('#account_name_other').prop("selectedIndex", 0).change();
			$('#account-wrapper').empty();
			account_transactions = [];

			if( $(this).val() != "Others" && $(this).val() != "others" && $(this).val() != '' ) {

				let _url = '{!! url("accounts") !!}/show/' + $(this).val();

				$.ajax({

					url 	: _url,
					method 	: 'GET' ,
					success : function(res) {

						$('#account-wrapper').append(res);

						setTimeout(function(){
							$("#docdate").datepicker({
							    maxDate: new Date()
							});					
						}, 1000);

					}

				});

				$('#account_name_other').removeClass('show').removeClass('hide');
				$('#account_name_other').addClass('hide');
			} else { 
				$('#account_name_other').removeClass('show').removeClass('hide');
				$('#account_name_other').addClass('show');
			}

		});

		$(document).on('change', '#account_name_other', function() {

			$('#account-wrapper').empty();
			account_transactions = [];

			let _url = '{!! url("accounts") !!}/show/' + $(this).val();

			if($(this).val() != '') {
				$.ajax({

					url 	: _url,
					method 	: 'GET' ,
					success : function(res) {

						$('#account-wrapper').append(res);

					}

				});
			}


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

					if( from == 'pcv' ) {
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

					} else {
						$(_that).next().html(res);
						$('#'+_that.data('name')+'_attachment').val(res);
					}

				}
			})

		});

		$(document).on('click', '.btn-savesubmit', function() {

			var ctr = 0;
			var _account_name = $('#account_name').val().trim();

			if( _account_name == 'Stripping Charge' ||
				_account_name == 'Delivery Charges') {
				account_transactions = [];
				account_attachments = [];
				$('#account-transactions-list tbody').find('tr').each(function(i, e) {
					
					let _account_trans = {};

					if(_account_name == 'Stripping Charge') {

						if($('#vendor').val() != '') {
							_account_trans['vendor'] = $('#vendor').val();
						} else {
							$('#vendor').addClass('is-invalid');
							return false;
						}

					}

					$(this).find('td').each(function(o , p) {

						let _acc_name = $(this).data('name');

						if(_acc_name == undefined) return false;

						if($(this).find('input').length) {					

							_account_trans[_acc_name] = $(this).find('input').val();
							if($(this).find('input').val() == ''){
								$(this).find('input').addClass('is-invalid');
							} else {
								$(this).find('input').removeClass('is-invalid');
							}

						} else {

							_account_trans[_acc_name] = $(this).text();

						}

					});

					account_transactions.push(_account_trans);

				});

			} else {
				
				let _data 	 = {};				
				let __items  = [];
				account_transactions = [];
				account_attachments = [];

				$('.custom-inputs').each(function() {
					let _name = $(this).data('name');
					_data[_name] = $(this).val();
					if($(this).val() == ''){
						$(this).addClass('is-invalid');
					} else {
						$(this).removeClass('is-invalid');
					}
				});

				if( _account_name == 'Installation' ) {

					$('#account-transactions-list tbody').find('tr').each(function(i, e) {

						let _items 	 = {};
						
						$(this).find('td').each(function(o , p) {

							let _acc_name = $(this).data('name');
							if(_acc_name != undefined) {
								_items[_acc_name] = $(this).text(); 
								console.log($(this).text());
							}

						});
	
						__items.push(_items);

					});

					_data['items'] = __items;
					
				}

				account_transactions.push(_data);
				
			}

			$('#pcv_accounts').val(JSON.stringify(account_transactions));

			// format data of attachments
			if($('.attachment-wrapper').length > 0){
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
			}

			$('#pcv_attachments').val(JSON.stringify(account_attachments));
			$('#pcv_action').val($(this).data('action'));

			if($('#total_amount_display').length > 0){}else {

				if($('.custom-inputs[data-name="amount"]').length) {
					$('#total_amount').val($('.custom-inputs[data-name="amount"]').val());
				} else if($('.custom-inputs[data-name="total_amount"]').length) {
					$('#total_amount').val($('.custom-inputs[data-name="total_amount"]').val());
				}

			}

			let is_null_val = false;

			$.each(account_transactions, function(i, e) {
				$.each(e, function(o, u){

					if( u =='' || u == undefined ) {
						if( ( _account_name == 'others' || _account_name == 'Pakyawan' || _account_name == 'Cellphone Expense' ||
							_account_name == 'Internet & Cable' || _account_name == 'Interbranch Deliveries') && o == 'charge_to' ) {

						} else if( _account_name == 'Delivery Charges' && o == 'pos_no_of_delivery_fee' && u == '') {

						} else {
							is_null_val = true;
						}	
					}
				});
			});

			if(account_attachments.length>0){
				$.each(account_attachments, function(i, e) {
					$.each(e, function(o, u){
						if(u =='' || u == undefined) is_null_val = true;
					});
				});
			}

			if(is_null_val || account_transactions.length == 0 ) {
				if(_account_name == 'Delivery Charges') { 
					$('#btn-add-account-details').click(); 
					return false;
				} else {
					alert('Some data on your request is missing please check it again');
					return false;
				}
			}

			if(attachment_eexist) {
				alert('Your attachment already exist please check');
				return false;
			}
			// check if can save multiple transaction accounts
			$('#pcv_form').submit();

		});

		$(document).on('keydown', '.ref-doc', function(){ $(this).removeClass('is-invalid'); });

		$(document).on('blur', '.ref-doc', function() {
			let _attachment_exist = false;
			let _vendor = $('.custom-inputs[data-name="vendor"]').val();
			let _date_no = $(this).attr('id').split("_").reverse()[0];
			let _date = '';
			let _ref = $(this).val();

			$(this).removeClass('is-invalid');

			if(!Array.isArray(_date_no)) {
				_date = $('#docdate').val();
			} else {
				_date = $('#docdate_'+_date_no).val();
			}

			let _that = $(this);

			$.ajax({
				url : '{!! route("requestor.pcv.check-attachment-exist") !!}'+'?vendor='+_vendor+'&date='+_date+'&ref='+_ref,
				method: 'GET' ,
				async: false ,
				success: function(res) {

					if(res.length>0) {

						$(_that).addClass('is-invalid');
						alert('This attachment already exist.');
						attachment_eexist = true;
						return false;

					}

				}
			});

		});

		$(document).on('click', '#btn-add-account-details', function () {

			let _account_name 	= $('#account_name').val();

			if(_account_name == 'Stripping Charge') return false;

			if(_account_name == 'Delivery Charges') {

				// check if amount is > 1500
				if( accounting.unformat($('.custom-inputs[data-name="amount"]').val()) > 1500 ) {

					// pop up approval modal
					$('#deliveryChargeModal').modal({
						backdrop : 'static' ,
						show 	 : true
					});

				} else {
					let _exists = false;
					let _data = getData();

					if(!_data) { alert('Some data on your request is missing please check it again'); return false; }

					$.each(account_transactions, function (x, y) {
						if(y.di_no == _data.di_no) {
							_exists = true;
							return false;
						}
					});

					if(_exists) { alert("DI no " + _data.di_no + " is already added"); return false; }
				    
					let _di_no = $('.custom-inputs[data-name="di_no"]').val();
					let _di_exist = false;

					$.ajax({
						url 	: '{!! route("requestor.pcv.search-di") !!}?search='+_di_no ,
						method 	: 'GET' ,
						success : function (res) {

							console.log(res.length);

							if(res.length>0) {
								alert('DI Already Exist.'); 
								resetAccountForm();
								return false;
							} else {
								account_transactions.push(_data);

						    	populateAccountsTable();
						    	resetAccountForm();
						    	calculateTotal();
							}

						}
		 			})
					
				}

			} else {

				let _data = getData();

		    	account_transactions.push(_data);

		    	populateAccountsTable();
		    	resetAccountForm();
		    	calculateTotal();

			}			

		});

		$(document).on('click', '#btn_disapprove_code', function() {

			resetApprovalForm();

		});

		$(document).on('click', '#btn_approval_code', function() {

			let _data = getData();

			_data.remarks = $('#remarks').val();
	    	_data.approver_name = $('#approver_name').val();
	    	_data.approval_code = $('#approval_code').val();

	    	if($('#approver_name').val() == '') { alert('Approver name is required'); return false; }
	    	if($('#approval_code').val() == '') { alert('Approval code is required'); return false; }
	    	if($('#remarks').val() == '') { alert('Remarks is required'); return false; }
	    	console.log(_data);
	    	account_transactions.push(_data);

	    	populateAccountsTable();
	    	resetAccountForm();
	    	calculateTotal();

	    	$('#deliveryChargeModal').modal('hide');

		});

		$(document).on('change', '#ts_no', function() {

			let _description = $('#ts_no option:selected').data('description');
			let _account_name = $('#ts_no option:selected').data('name');
			let is_others = true;

			$.each($("#account_name option"), function(){ 

				if(_account_name == $(this).val()) {
					is_others=false;
					return false;
				}

			});

			if(is_others) {
				$('#account_name').val('others').change();	
				$('#account_name_other').val(_account_name).change();	
			} else {
				$('#account_name').val(_account_name).change();				
			}
			$('#pcv_description').val(_description);

		});

		$(document).on('click', '#copy-from', function() {

			$('#cancelled-pcvs tbody').empty();

			$.ajax({
				url 	: '{!! route("requestor.pcv.cancelled") !!}' ,
				method 	: 'GET' ,
				success : function (res) {

					let _html = '';	

					$.each(res, function(i, data){

						_html += '<tr>';
						_html += '<td><a href="#" data-pcv="'+data.pcv_no+'" class="copy_from_ref">'+ data.pcv_no +'</a></td>';
						_html += '<td>'+ data.pcv_no +'</td>';
						_html += '<td>'+ data.date_created +'</td>';	
						_html += '<td>'+ data.cancelled_by +'</td>';																	
						_html += '<td>'+ data.pcv_no +'</td>';
						_html += '<td>'+ data.date_created +'</td>';	
						_html += '<td>'+ data.approved_by +'</td>';
						_html += '</tr>';

					});

					$('#cancelled-pcvs tbody').append(_html);

				}
 			})

		});

		$(document).on('click', '.copy_from_ref', function(e) {
			e.preventDefault();
			let _pcv_no = $(this).data('pcv');
			let _base_url = "{!! env('APP_URL') !!}";

			$.ajax({
				url 		: _base_url + '/pcv/requestor/copy-pcv/'+_pcv_no ,
				method 		: 'GET' ,
				success  	: function(res) {

					console.log(res);
					let _aTransactions = [];

					if(res.account_transaction.details.length>0) {
						$.each(res.account_transaction.details, function(i, data) {
							console.log(data);
							_aTransactions.push(data);
						});
					}
					console.log(_aTransactions);
					if(res.slip_no!=null) {
						$('#with-temporary-slip').prop('checked', 'checked');
						$('#ts_no').val(res.slip_no);
					}

					$('#change').val(res.change);					
					$('#date_created').val(moment().format('YYYY-MM-DD'));
					$('#pcv_accounts').val(JSON.stringify(_aTransactions));
					
					let is_others=true;

					$.each($("#account_name option"), function(){ 

						if(res.account_name == $(this).val()) is_others=false;

					});

					if(is_others) {
						$('#account_name_other').val(res.account_name);
						$('#account_name_other').change();
						$('#account_name select').val('others');
					} else {
						$('#account_name').val(res.account_name);
						$('#account_name').change();
					}
					

					setTimeout(function(){
						if($('#pcv_accounts').val() != '')
							getAccountTransactions();						
					}, 2000);

					$('#copyFrom').modal('hide');

				}
			})

		});

		$(document).on('click', '#check-all-barcode', function() {
			
			if($(this).is(':checked')) {
				$('.pos_trans').prop('checked', 'checked');
			} else {
				$('.pos_trans').prop('checked', false);
			}

		});

		$(document).on('click', '#btn-save-pos-trans', function() {
			
			let _hasVal		= true;	
			pos_items 		= [];
			$('#account-transactions-list tfoot').remove();

			$('#pop_ups_inner tbody tr').each(function(i, data){
			
				let _isCheck 	= false;		
				let _pos_items 	= [];
				
				$(this).find('td').each(function (){

					if($(this).find('input').length) {

						if($(this).find('input').attr('type')=='checkbox') {
							
							if($(this).find('input').is(':checked')) {
								_isCheck = true;
							} else {
								return false;
							}

						} else {

							_pos_items[$(this).data('name')] = $(this).find('input').val();
							if($(this).find('input').val() == '' || $(this).find('input').val() == undefined) _hasVal = false;

						}

					} else {

						if( _isCheck == true ) {
							if( $(this).data('name') !== undefined ) {
								_pos_items[$(this).data('name')] = $(this).text();
							}
						}

					} 

					if($('#account_name').val() == 'Stripping Charge') {
						_pos_items['slps_no'] = $(this).parent().data('slps');
					}

				});

				if( _isCheck == true ) {

					if(  !_hasVal) {
						alert('Some fields doesn\'t have value please checked');
						return false;
					}

					pos_items.push(_pos_items);
				}

			});			

			let _account_name 	= $('#account_name').val();
			let _html = '';		

			_html += '<tr>';	

			let _ctr = $('#account-transactions-list tbody tr').length;

			$.each(pos_items, function(e, a){

				$('.tbl-header').each(function(i, o) {

					if( _account_name == 'Stripping Charge') {
						if($(this).data('rowname').trim() == 'slps_no' || 
							$(this).data('rowname').trim() == 'plate_no' || 
							$(this).data('rowname').trim() == 'trucker'  ) { 
							_html += '<td data-name="'+$(this).data('rowname')+'">' + pos_items[e][$(this).data('rowname')] + '</td>';							
						} else if( $(this).data('rowname').trim() != 'action' ){

							if(_ctr == 0) {
								if($(this).data('rowname').trim() == 'charge_to_store') {
									_html += '<td data-name="'+$(this).data('rowname')+'"><input readonly data-name="'+$(this).data('rowname')+'" type="number" min="0"'; 
									_html += 'class="form-control account-user-input" id="'+ $(this).data('rowname') +'" ></td>';
								} else {
									_html += '<td data-name="'+$(this).data('rowname')+'"><input data-name="'+$(this).data('rowname')+'" type="number" min="0"'; 
									_html += 'class="form-control account-user-input" id="'+ $(this).data('rowname') +'" ></td>';
								}
							} else {
								if($(this).data('rowname').trim() == 'charge_to_store') {
									_html += '<td data-name="'+$(this).data('rowname')+'"><input readonly data-name="'+$(this).data('rowname')+'" type="number" min="0"'; 							
									_html += 'class="form-control account-user-input" id="'+ $(this).data('rowname') +_ctr+'" ></td>';
								} else {
									_html += '<td data-name="'+$(this).data('rowname')+'"><input data-name="'+$(this).data('rowname')+'" type="number" min="0"'; 							
									_html += 'class="form-control account-user-input" id="'+ $(this).data('rowname') +_ctr+'" ></td>';
								}
							}

						}
					} else {

						if( $(this).data('rowname').trim() != 'action' ){
							console.log($(this).data('rowname'));
							if(_account_name == 'Delivery Charges' && $(this).data('rowname') == 'pos_no_of_purchased_items') {
								let _url = "{!! env("APP_URL") !!}"+'/pos-transactions/show/'+pos_items[e][$(this).data('rowname')];
								_html += '<td data-name="'+$(this).data('rowname')+'" >';
								_html += '<a href="'+_url+'" target="_blank">'+ pos_items[e][$(this).data('rowname')] +'</a>';
								_html += '</td>';
							} else {
								_html += '<td data-name="'+$(this).data('rowname')+'">'+ pos_items[e][$(this).data('rowname')]  +'</td>';
							}							
						}
					}

				});

				_html += '<td>';
				_html += '<nav class="nav table-options justify-content-start">';
				_html += '<a class="nav-link p-0 pl-2 remove_account_attachment" href="javascript:void(0);" title="Remove">'; 
				_html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
				_html += '</a></nav>';
				_html += '</td>';
				_html += '</tr>';

				_ctr ++;

			});

			$('#account-transactions-list tbody').append(_html);

			if(_account_name != 'Installation') {
				$('#account-transactions-list').append(
					`<tfoot>
	                    <tr role="row">
	                      <td class="sorting_1"></td>
	                      <td></td>
	                      <td></td>
	                      <td></td>
	                      <td class="tx-bold align-middle">Total</td>
	                      <td>
	                        <input type="text" class="form-control tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" value="00000.00" readonly id="total_amount_display">
	                      </td>
	                      <td></td>
	                    </tr>
	                  </tfoot>`);
			}

			if(_account_name != 'Stripping Charge') {
				resetAccountForm();
			}

			if(_hasVal)
				$('#pop_ups_wrap').modal('hide');

		});

		$(document).on('focusout', '.account-user-input', function() {
			
			if($('#account_name').val() == 'Stripping Charge') {

				if($(this).data('name') == 'amount' || $(this).data('name') == 'rate' ) {

					let _input_id = $(this).attr('id').split($(this).data('name')).reverse();

					if($('#amount'+_input_id[0]).val() != '' && $('#amount'+_input_id[0]).val() != '') {
						$('#charge_to_store'+_input_id[0]).val($('#amount'+_input_id[0]).val() - $('#rate'+_input_id[0]).val());
					}
				}

			}

			if($(this).data('name') == 'amount') {

				calculateTotal();

			}

		});
		
		$(document).on('focusout', '#bill_date_from', function(){

			let _from = $('#bill_date_from').val();
			let _to   = $('#bill_date_to').val();

			$.ajax({

				url 	: '{!! env("APP_URL") !!}' + '/pcv/requestor/check-billing-date?from='+_from+'&to='+_to ,
				method 	: 'GET' ,
				success : function (res) {

					if(res == 'yes') {
						alert('Billing Date From already covered last payment');
						resetAccountForm();
					}
					
				}

			});

		});

		
		$(document).on('blur', '#bill_date_to', function(){

			let _from = $('#bill_date_from').val();
			let _to   = $('#bill_date_to').val();

			$.ajax({

					url 	: '{!! env("APP_URL") !!}' + '/pcv/requestor/check-billing-date?from='+_from+'&to='+_to ,
					method 	: 'GET' ,
					success : function (res) {

						if(res == 'yes') {
							alert('Billing Date From already covered last payment');
							resetAccountForm();
						}
						
					}

				});

		});

		$(document).on('blur', '.custom-inputs', function () {

			if($(this).data('name') == 'amount' || $(this).data('name') == 'total_amount') {
				$(this).val(accounting.formatNumber($(this).val() , 2, ',', '.'));
			}

		});

		$(document).on('keyup', '.custom-inputs', function () {
			
			let _account_name = $('#account_name').val();
			if( _account_name != 'Staff House Rental') {	
				clearTimeout(typingTimer);			
			  	typingTimer = setTimeout("doneTyping('"+$(this).data('name')+"','"+$(this).val()+"')", doneTypingInterval);			
			}

		});

		$(document).on('keydown', '.custom-inputs', function () {
		  	clearTimeout(typingTimer);
		});

		function doneTyping (type, val) {
			console.log('called');
			pos_items = [];
			$('#pop_ups_inner').empty();
			if(type == 'slps_no') {

				$.ajax({

					url 	: '{!! env("APP_URL") !!}' + '/truckers/search?search='+val ,
					method 	: 'GET' ,
					success : function (res) {

						if(res.length > 0) {
						
							let _html  = '';
								_html += '<thead>';
								_html += '<tr role="row">';
								_html += '<th class="sorting_1 tx-uppercase"><input type="checkbox" id="check-all-barcode"></th>';
								_html += '<th class="tx-uppercase">Van/Plate</th>';
								_html += '<th class="tx-uppercase">truckers</th>';
								_html += '<th class="tx-uppercase">Mode of Payment</th>';
								_html += '</tr>';
								_html += '</thead><tbody>';

							
							$.each(res, function(i, o) {

								_html += '<tr data-slps="'+o.SLPSNO+'">';
								_html += '<td><input type="checkbox" class="pos_trans"></td>';
								_html += '<td data-name="plate_no">'+ o.PLATENUMBER + '' + o.VANNUMBER +'</td>';
								_html += '<td data-name="trucker">'+o.TRUCKER_SHIPPER+'</td>';
								_html += '<td>'+o.NAMESHIP+'</td>';
								_html += '</tr>';

							});

							_html += '</tbody>';

							$('#pop_ups_inner').append(_html);

							$('#pop_ups_wrap').modal({
								backdrop : 'static' ,
								show 	 : true
							});						

						} else {

							$('#message_content').text('No Items Found');
							$('#for_message').modal({
								backdrop : 'static' ,
								show 	 : true
							});

							setTimeout(function(){ $('#for_message').modal('hide');}, 3000);

						}

					}

				});

			} else if(type == 'pos_transaction_no') {

				$.ajax({

					url 		: "{!! route('pos-transactions.search') !!}" + "?search="+val ,
					method 		: "GET" ,
					success 	: function(res) {

						if( res.length > 0) {

							let _html  = '';
								_html += '<thead>';
								_html += '<tr role="row">';
								_html += '<th class="sorting_1 tx-uppercase"><input type="checkbox" id="check-all-barcode"></th>';
								_html += '<th class="tx-uppercase">Barcode</th>';
								_html += '<th class="tx-uppercase">Description</th>';
								_html += '<th class="tx-uppercase">Sold Qty</th>';
								_html += '<th class="tx-uppercase">Qty w/ PCV</th>';
								_html += '<th class="wd-5p tx-uppercase">Qty for Installation</th>';
								_html += '</tr>';
								_html += '</thead><tbody>';

							$.each(res, function(i, o) {
								
								_html += '<tr>';
								if(o.original_qty > o.qty_with_pcv) {
									_html += '<td><input type="checkbox" class="pos_trans"></td>';
								} else {
									_html += '<td><input type="checkbox" class="pos_trans" disabled></td>';
								}
								_html += '<td data-name="barcode">'+o.barcode+'</td>';
								_html += '<td data-name="description">'+o.description+'</td>';
								_html += '<td>'+o.original_qty+'</td>';
								_html += '<td>'+o.qty_with_pcv+'</td>';
								if(o.original_qty > o.qty_with_pcv) {
									let _max = parseInt(o.original_qty) - parseInt(o.qty_with_pcv);
									_html += '<td data-name="qty_for_installation"><input type="number" step="1" class="form-control" max="'+_max+'"></td>';
								} else {
									_html += '<td data-name="qty_for_installation"><input disabled type="number" step="1" class="form-control"></td>';
								}
								_html += '</tr>';

							});

							_html += '</tbody>';

							$('#pop_ups_inner ').append(_html);

							$('#pop_ups_wrap').modal({
								backdrop : 'static' ,
								show 	 : true
							});

						} else {

							$('#message_content').text('No Items Found');
							$('#for_message').modal({
								backdrop : 'static' ,
								show 	 : true
							});

							setTimeout(function(){ $('#for_message').modal('hide');}, 3000);

						}

					}

				});
			} else if( type == 'job_request_no' ) {

				$.ajax({

					url 	: '{!! env("APP_URL") !!}' + '/job-request/search?search='+val ,
					method 	: 'GET' ,
					success : function (res) {

						if( res != '' ) {

							$('.custom-inputs[data-name="project_name"]').val(res.project_name);
							$('.custom-inputs[data-name="project_type"]').val(res.project_type);
							$('.custom-inputs[data-name="brand"]').val(res.brand);

						} else {

							$('.custom-inputs[data-name="job_request_no"]').val('');
							$('.custom-inputs[data-name="project_name"]').val('');
							$('.custom-inputs[data-name="project_type"]').val('');
							$('.custom-inputs[data-name="brand"]').val('');

							$('#message_content').text('Job Request No. '+val+' does not exist');
							$('#for_message').modal({
								backdrop : 'static' ,
								show 	 : true
							});

							setTimeout(function(){ $('#for_message').modal('hide');}, 3000);

						}

					}
				});

			} else if (type == 'pos_no_of_purchased_items') {

				$.ajax({

					url 		: "{!! route('pos-transactions.search') !!}" + "?search="+val ,
					method 		: "GET" ,
					success 	: function(res) {

						if( res.length > 0) {

							// const last2Str = String(res[0].universal_trx_id).slice(-2); 
							// const last2Num = Number(last2Str);

							//$('.custom-inputs[data-name="pos_no_of_delivery_fee"]').val(res[0].universal_trx_id);

						} else {

							$('.custom-inputs[data-name="pos_no_of_purchased_items"]').val('');

							$('#message_content').text('POS No. '+val+' does not exist');
							$('#for_message').modal({
								backdrop : 'static' ,
								show 	 : true
							});

							setTimeout(function(){ $('#for_message').modal('hide');}, 3000);

						}

					}

				});

			} else if (type == 'pos_no_of_delivery_fee') {

				$.ajax({

					url 		: "{!! route('pos-transactions.search') !!}" + "?search="+val ,
					method 		: "GET" ,
					success 	: function(res) {

						if( res.length > 0) {

							// const last2Str = String(res[0].universal_trx_id).slice(-2); 
							// const last2Num = Number(last2Str);

							//$('.custom-inputs[data-name="pos_no_of_delivery_fee"]').val(res[0].universal_trx_id);

						} else {

							$('.custom-inputs[data-name="pos_no_of_delivery_fee"]').val('');

							$('#message_content').text('POS No. '+val+' does not exist');
							$('#for_message').modal({
								backdrop : 'static' ,
								show 	 : true
							});

							setTimeout(function(){ $('#for_message').modal('hide');}, 3000);

						}

					}

				});

			}

		}

		function getAccountTransactions() {

			let _account_name = $('#account_name').val();
			let _account_transactions = JSON.parse($('#pcv_accounts').val());
			let _base_url = "{!! env('APP_URL') !!}";
			let _amount_ctr = 0;

			if($('#btn-add-account-details').length > 0) {

				$.each(_account_transactions, function(i, data){
						
					let _html = '<tr>';

					$('.tbl-header').each(function(ii, res) {
						let _row_name = $(this).data('rowname').trim();

						if(_account_name == 'Stripping Charge') {
							if( _row_name != 'action') { 
								if( _row_name == 'rate' ||
									_row_name == 'charge_to_store' ||
									_row_name == 'amount' ) {
									_html += '<td data-name="'+_row_name+'" >'; 
									_html += '<input type="text" value="'+data[$(this).data('rowname')]+'"';
									if(i == 0) {
										if(_row_name == 'charge_to_store') {
											_html += 'class="form-control account-user-input" id="'+$(this).data('rowname')+'" data-name="'+$(this).data('rowname')+'" readonly>'; 
										} else {
											_html += 'class="form-control account-user-input" id="'+$(this).data('rowname')+'" data-name="'+$(this).data('rowname')+'">'; 
										}
									} else {
										if(_row_name == 'charge_to_store') {
											_html += 'class="form-control account-user-input" id="'+$(this).data('rowname')+''+i+'" data-name="'+$(this).data('rowname')+'" readonly>'; 
										} else {
											_html += 'class="form-control account-user-input" id="'+$(this).data('rowname')+''+i+'" data-name="'+$(this).data('rowname')+'">'; 
										}
									}
									_html += '</td>';	
								} else {
									_html += '<td data-name="'+_row_name+'" >' + data[$(this).data('rowname')] + '</td>';							
								}
							}	
						} else {

							if( _row_name != 'action') { 
								if(_account_name == 'Delivery Charges' && _row_name == 'pos_no_of_purchased_items') {
									let _url = "{!! env("APP_URL") !!}"+'/pos-transactions/show/'+data[_row_name];
									_html += '<td data-name="'+_row_name+'" >';
									_html += '<a href="'+_url+'" target="_blank">'+ data[_row_name] +'</a>';
									_html += '</td>';
								} else {
									_html += '<td data-name="'+_row_name+'" >' + data[_row_name] + '</td>';	
								}
							}
						}					

					});

					_html += '<td>';
					_html += '<nav class="nav table-options justify-content-start">';
					_html += '<a class="nav-link p-0 pl-2 remove_account_attachment" href="javascript:void(0);" title="Remove">'; 
					_html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
					_html += '</a></nav>';
					_html += '</td>';
					_html += '</tr>';	

					account_transactions.push(data);
					$('#account-transactions-list tbody').append(_html);	

				});

			} else {

				$('.custom-inputs').each(function(i, d) {
					$(this).val(_account_transactions[0][$(this).attr('data-name')]);
					if( $(this).attr('data-name') == 'vendor' || $(this).attr('data-name') == 'charge_to' ) { $(this).trigger('change'); }
				});

				if(_account_name == 'Installation') {

					$.each(_account_transactions[0]['items'], function(qq, ff) {

						let _html = '<tr>';
						
						$('.tbl-header').each(function(ii, res) {
							let _row_name = $(this).data('rowname').trim();
							if( _row_name != 'action') { 
								_html += '<td data-name="'+_row_name+'" >' + _account_transactions[0]['items'][qq][$(this).data('rowname')] + '</td>';	
							}						
						});

						_html += '<td>';
						_html += '<nav class="nav table-options justify-content-start">';
						_html += '<a class="nav-link p-0 pl-2 remove_account_attachment" href="javascript:void(0);" title="Remove">'; 
						_html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
						_html += '</a></nav>';
						_html += '</td>';

						_html += '</tr>';

						$('#account-transactions-list tbody').append(_html);

					});
				}

			}


			if($('#btn-add-account-details').length > 0) {
			if(_account_name != 'Installation') {
				if(_account_name == 'Stripping Charge') {
					$('#account-transactions-list').append(
						`<tfoot>
		                    <tr role="row">
		                      <td class="sorting_1"></td>
		                      <td></td>
		                      <td></td>
		                      <td></td>
		                      <td class="tx-bold align-middle">Total</td>
		                      <td>
		                        <input type="text" class="form-control tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" value="00000.00" readonly id="total_amount_display">
		                      </td>
		                      <td></td>
		                    </tr>
		                  </tfoot>`);
				} else {
					$('#account-transactions-list').append(
						`<tfoot>
		                    <tr role="row">
		                      <td class="sorting_1"></td>
		                      <td></td>
		                      <td></td>
		                      <td></td>
		                      <td></td>
		                      <td class="tx-bold align-middle">Total</td>
		                      <td>
		                        <input type="text" class="form-control tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" value="00000.00" readonly id="total_amount_display">
		                      </td>
		                      <td></td>
		                    </tr>
		                  </tfoot>`);
				}

				calculateTotal();
			}}



		}

		function getAttachments() {

			let account_attachments = JSON.parse($('#pcv_attachments').val());
			let _base_url = "{!! env('APP_URL') !!}";

			$.each(account_attachments, function(i, data){

				if( i > 0 ) {
					
					nextElement($('#attachment-inner-wrapper'));

					if(i<10){
						$('#type_0'+i).val(data.type);
						$('#docrefstring_0'+i).val(data.attachment);
						$('#docrefstring_0'+i).siblings("label").text(data.attachment);
						$('#docdate_0'+i).val(moment(data.date).format('MM/DD/YYYY'));
						$('#docref_0'+i).val(data.ref);

						setTimeout(function(){
							$('#docdate_0'+i).removeClass('hasDatepicker')
								.removeData('datepicker')
								.unbind()
								.datepicker({
									maxDate : new Date()
								});		
						}, 1000);
					} else {
						$('#type_'+i).val(data.type);
						$('#docrefstring_'+i).val(data.attachment);
						$('#docrefstring_'+i).siblings("label").text(data.attachment);
						$('#docdate_'+i).val(moment(data.date).format('MM/DD/YYYY'));
						$('#docref_'+i).val(data.ref);

						setTimeout(function(){
							$('#docdate_'+i).removeClass('hasDatepicker')
								.removeData('datepicker')
								.unbind()
								.datepicker({
									maxDate : new Date()
								});		
						}, 1000);
					}

				} else {

					$('#type').val(data.type);
					$('#docrefstring').val(data.attachment);
					$('#docrefstring').siblings("label").text(data.attachment);
					$('#docdate').val(moment(data.date).format('MM/DD/YYYY'));
					$('#docref').val(data.ref);

					setTimeout(function(){
						$('#docdate').removeClass('hasDatepicker')
							.removeData('datepicker')
							.unbind()
							.datepicker({
								maxDate : new Date()
							});		
					}, 1000);

				}


			});


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
	        $('#docdate', newElement).attr("id", field2.split("_")[0]+"_"+id ).val(new moment().format('MM/DD/YYYY'));
	        $('#docref', newElement).attr("id", field3.split("_")[0]+"_"+id ).val('');
			$('#docrefstring', newElement).attr("id", field4.split("_")[0]+"_"+id ).val('');
			
	        newElement.appendTo($("#attachment-outter-wrapper"));
	        $('#'+field4.split("_")[0]+"_"+id).siblings('label').html('');

	        setTimeout(function(){
				$('#'+field2.split("_")[0]+"_"+id).removeClass('hasDatepicker')
					.removeData('datepicker')
					.unbind()
					.datepicker({
						maxDate : new Date()
					});		
			}, 1000);

	    }	

	    function populateAccountsTable() {

	    	$('#account-transactions-list tfoot').remove();
	    	$('#account-transactions-list tbody').empty();

			let _html = '';		
			console.log(account_transactions);
			$.each(account_transactions, function (x, y) {
			
				_html += '<tr>';	
				
				$('.tbl-header').each(function(i, o) {
						
					let _row_name = $(this).data('rowname').trim();
					console.log(_row_name);

					if( _row_name != "action" && _row_name != "line_no") {
						if( _row_name == 'pos_no_of_purchased_items' || _row_name == 'pos_no_of_delivery_fee' ) {
							_html += '<td data-name="'+_row_name+'" >';
							let _url = "{!! env("APP_URL") !!}"+'/pos-transactions/show/'+account_transactions[x][_row_name];
							_html += '<a href="'+_url+'" target="_blank">';
							_html += account_transactions[x][_row_name] +'</a>';
							_html += '</td>';
						} else if( _row_name == 'attachment' ) {
							_html += '<td data-name="'+_row_name+'" >';
							let _url = "{!! env("APP_URL") !!}"+'/storage/temp/'+{!! auth()->user()->id !!}+'/account/'+account_transactions[x][_row_name];
							_html += '<a href="'+_url+'" target="_blank">';
							_html += account_transactions[x][_row_name] +'</a>';
							_html += '</td>';
						} else {
							_html += '<td data-name="'+_row_name+'" >' + account_transactions[x][_row_name] + '</td>';	
						}
						
					} else if(_row_name == 'line_no') {
						_html += '<td data-name="'+_row_name+'">' + ( x + 1 ) + '</td>';	
					}			

				});

				_html += '<td>';
				_html += '<nav class="nav table-options justify-content-start">';
				_html += '<a class="nav-link p-0 pl-2 remove_account_attachment" href="javascript:void(0);" title="Remove">'; 
				_html += '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
				_html += '</a></nav>';
				_html += '</td>';
				_html += '</tr>';

			});

			$('#account-transactions-list tbody').append(_html);

			if($('#account-transactions-list tfoot').length>0){}else {
				$('#account-transactions-list').append(
					`<tfoot>
	                    <tr role="row">
		                    <td class="sorting_1"></td>
		                    <td></td>
		                    <td></td>
		                    <td></td>
		                    <td></td>
		                    <td class="tx-bold align-middle">Total</td>
		                    <td>
	                        	<input type="text" class="form-control tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" value="00000.00" readonly id="total_amount_display">
	                      	</td>
	                      	<td></td>
	                    </tr>
	                </tfoot>`);
			}

	    }

	    function getData() {
	    	let _data 	 		= {};
	    	let _hasEmptyVal    = false;

	    	$('.custom-inputs').each(function() {
				let _name = $(this).data('name');
				_data[_name] = $(this).val();
				if($(this).val() == '' || $(this).val() == undefined) {
					if(_name != 'pos_no_of_delivery_fee'){
						console.log(_name);
						console.log('-- from get data --');
						$(this).addClass('is-invalid');
						_hasEmptyVal = true;
					}
				} else {
					$(this).removeClass('is-invalid');
				}
			});

			if( _hasEmptyVal ) return false;

			return _data;
	    }

	    function resetAccountForm() {

	    	$('.custom-inputs').each(function() {

	    		if($(this).data('name') == 'attachment') {
	    			$(this).siblings('label').text('');
	    			$('#attachment_attachment').val('');
	    		}

	    		if($(this).is("select")) {
	    			$(this).val($(this).find("option:first-child").val());
	    		} else if($(this).attr('type') == 'date') {
	    			let _date = moment.now();
					$(this).val(moment(_date).format('YYYY-MM-DD'));
	    		} else if($(this).is('type') != 'date') {
	    			if($(this).data('name') != 'pos_transaction_no') 
		    			$(this).val('');
	    		}

	    	});

	    }

	    function resetApprovalForm() {

	    	$('#remarks').val('');
	    	$('#approver_name')[0].selectedIndex=0;
	    	$('#approval_code').val('');

	    }

	    function calculateTotal() {

	    	let _total = 0;
	    	if($('#account_name').val() == 'Stripping Charge') {
		    	$('.account-user-input[data-name="amount"]').each(function(e) {

					let _amount = accounting.unformat($(this).val()); 

					if( isNaN(_amount) ) {
						_amount = 0;
					}

					_total = parseFloat(_total) +  _amount;

				});
		    } else {

		    	$('#account-transactions-list tr').find('td').each(function() {

		    		if($(this).data('name') == 'amount' || $(this).data('name') == 'total_amount') {
			    		_total = _total + accounting.unformat($(this).text());
			    	}

		    	});


		    }
			$('#total_amount').val(_total);
			console.log(accounting.formatNumber(_total));
			$('#total_amount_display').val(accounting.formatNumber(_total, 2, ',', '.'));

	    }

	</script>

@endsection


