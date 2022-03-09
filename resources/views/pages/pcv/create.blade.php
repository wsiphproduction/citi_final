@extends('layouts.app')

@section('pagecss')

    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <style type="text/css">
    	#tsNo {
    		display: block;
    	}
    </style>

@endsection

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="#">Petty Cash Voucher</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Petty Cash Voucher Form</h4>
		</div>

	</div>	
	@include('components.messages')
	<div class="row">
		
		<form role="form" method="POST" action="{{ route('pcv.store') }}" class="col-lg-12" id="pcv_form">
			@csrf

			<input type="hidden" name="pcv_attachments" id="pcv_attachments" value="{{ old('pcv_attachments') }}" />
			<input type="hidden" name="pcv_accounts" id="pcv_accounts" value="{{ old('pcv_accounts') }}" />
			<input type="hidden" name="pcv_action" id="pcv_action" value="{{ old('pcv_action') }}" />

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
						<input list="tsNo" type="text" class="form-control static-inputs" id="ts_no" name="ts_no"
							@if(!old('withslip')) disabled @endif value="{{ old('ts_no') }}">
						<datalist id="tsNo">

						</datalist>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="form-group row">
					<label for="change" class="col-lg-5 col-form-label">Change</label>
					<div class="col-lg-7">
						<input type="number" class="form-control static-inputs" id="change" name="change" 
							value="{{ old('change') }}" step="1" min="0" placeholder="0.00">
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
						<select class="custom-select static-inputs" id="account_name" name="account_name">
							<option value="">Select Account</option>
							@foreach( \App\Models\Account::getAccounts() as $account )
								<option value="{{ $account['name'] }}" @if(old('account_name')==$account['name']) selected @endif> 
									{{ $account['name'] }} 
								</option>
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
	                  			value="{{ old('date_created' , date('Y-m-d')) }}">
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
	            	<i class="mg-r-5" data-feather="save"></i> Save
	          	</button>
	          	<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-savesubmit"
	          		data-action="submitted">
	            	<i class="mg-r-5" data-feather="send"></i> Submit
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
	
@endsection

@section('pagejs')
	
	<script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
	<script type="text/javascript">
		
		var current_id = 0;
		var account_transactions = [];
		var account_attachments = [];
		var pos_items = [];
		var typingTimer;
		var doneTypingInterval = 2000;

		$(document).ready(function() {

			if($('#account_name').val() != '')
				$('#account_name').change();


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
				$('#ts_no').val('');
				$('#tsNo').empty();

			}			

		});


		$(document).on('click', '#btn-add-account-details', function () {

			let _account_name 	= $('#account_name').val();
			let _data 	 		= {};

			$('.custom-inputs').each(function() {
				let _name = $(this).data('name');
				_data[_name] = $(this).val();
			});


			let _html = '';		

			_html += '<tr>';	

			$('.tbl-header').each(function(i, o) {
				
				if($(this).data('rowname').trim() != 'action') { 
					console.log('aw');
					_html += '<td>' + _data[$(this).data('rowname')] + '</td>';							
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

			account_transactions.push(_data);
			console.log(account_transactions);			
			resetAccountForm();

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

		});

		$(document).on('change', '#account_name', function() {

			$('#account-wrapper').empty();
			account_transactions = [];

			let _url = '{!! url("accounts") !!}/show/' + $(this).val();

			$.ajax({

				url 	: _url,
				method 	: 'GET' ,
				success : function(res) {

					$('#account-wrapper').append(res);

				}

			});

		});

		$(document).on('change', '.document-f', function() {

			var _that = $(this);
			var formData = new FormData(); // Currently empty
			var from = $(this).data('from');
			formData.append('file',$(this)[0].files[0]);

			$.ajax({
				url : '{!! route("attachments.upload") !!}',
				headers: {'X-CSRF-Token': '{!! csrf_token() !!}' },
				type: 'POST' ,
				data: formData ,
				cache : false ,
				processData: false ,
				contentType: false ,
				success: function(res) {

					if( from == 'attachment' ) {
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
					} else {
						$('#'+_that.data('name')+'_attachment').val(res);
					}

				}
			})

		});

		$(document).on('click', '.btn-savesubmit', function() {

			var ctr = 0;
			account_attachments = [];

			// format data of account

			if($('#btn-add-account-details').length > 0) {} else {
				
				let _account_name 	= $('#account_name').val();
				let _data 	 		= {};

				$('.custom-inputs').each(function() {
					let _name = $(this).data('name');
					_data[_name] = $(this).val();
				});

				account_transactions.push(_data);
				
			}

			$('#pcv_accounts').val(JSON.stringify(account_transactions));

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

			$('#pcv_attachments').val(JSON.stringify(account_attachments));
			$('#pcv_action').val($(this).data('action'));

			// check if can save multiple transaction accounts
			$('#pcv_form').submit();

		});

		$(document).on('keyup', '#ts_no', function() {

			let _ts = $(this).val();

			if(_ts.trim().length > 2) { 

				$('#tsNo').empty();

				$.ajax({
					url 	: "{{ route('ts.search') }}?ts_no="+ _ts ,
					method 	: 'GET' ,
					async 	: false ,
					headers: {'X-CSRF-Token': '{!! csrf_token() !!}' },
					success : function(res) { 

						let _html = '';
						console.log(res.length);
						if(res.length>0) {
							$('#ts_no').attr('name', 'ts_no');
						} else {
							$('#ts_no').removeAttr('name');							
						}

						$.each(res, function(i, data){
							_html += '<option value="'+data.ts_no+'">'+data.ts_no +'</option>';
						});

						$('#tsNo').append(_html);

					}
				});

			}

		});

		$(document).on('click', '#copy-from', function() {

			$('#cancelled-pcvs tbody').empty();

			$.ajax({
				url 	: '{!! route("pcv.cancelled") !!}' ,
				method 	: 'GET' ,
				success : function (res) {

					let _html = '';	

					$.each(res, function(i, data){

						_html += '<tr>';
						_html += '<td><a href="#" data-pcv="'+data.pcv_no+'" class="copy_from_ref">'+ data.pcv_no +'</a></td>';
						_html += '<td>'+ data.pcv_no +'</td>';
						_html += '<td>'+ data.date_created +'</td>';	
						_html += '<td>'+ data.approved_by +'</td>';																	
						_html += '<td>'+ data.pcv_no +'</td>';
						_html += '<td>'+ data.date_created +'</td>';	
						_html += '<td>'+ data.approved_by +'</td>';
						_html += '</tr>';

					});

					$('#cancelled-pcvs tbody').append(_html);

				}
 			})

		});

		$(document).on('click', '.copy_from_ref', function() {

			let _pcv_no = $(this).data('pcv');
			let _base_url = "{!! env('APP_URL') !!}";

			$.ajax({
				url 		: _base_url + '/pcv/copy-pcv/'+_pcv_no ,
				method 		: 'GET' ,
				success  	: function(res) {

					console.log(res);
					let _aTransactions = [];

					if(res.account_transactions.length>0) {
						$.each(res.account_transactions, function(i, data) {
							_aTransactions.push(data.details);
						});
					}

					if(res.slip_no!=null) {
						$('#with-temporary-slip').prop('checked', 'checked');
						$('#ts_no').val(res.slip_no);
					}

					$('#change').val(res.change);
					$('#account_name').val(res.account_name);
					$('#date_created').val(moment(res.date_created).format('YYYY-MM-DD'));

					$('#pcv_attachments').val(JSON.stringify(res.attachments));
					$('#pcv_accounts').val(JSON.stringify(_aTransactions));


					$('#account_name').change();

					setTimeout(function(){
						if($('#pcv_accounts').val() != '')
							getAccountTransactions();

						if($('#pcv_attachments').val() != '')
							getAttachments();
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
			
			pos_items 		= [];

			$('#pop_ups_inner tbody tr').each(function(i, data){
			
				let _isCheck 	= false;				
				let _pos_items 	= [];
				
				$(this).find('td').each(function (){

					if($(this).find('input').length) {

						if($(this).find('input').attr('type')=='checkbox') {
							
							if($(this).find('input').is(':checked')) {
								_isCheck = true;
							}

						} else {

							_pos_items[$(this).data('name')] = $(this).find('input').val();

						}

					} else {

						if( _isCheck == true ) {
							if( $(this).data('name') !== undefined ) {
								_pos_items[$(this).data('name')] = $(this).text();
							}
						}

					} 

				});

				if( _isCheck == true ) {
					pos_items.push(_pos_items);
				}

			});

			$('#pop_ups_wrap').modal('hide');

		});


		$(document).on('keyup', '.custom-inputs', function () {
			
			clearTimeout(typingTimer);			
		  	typingTimer = setTimeout("doneTyping('"+$(this).data('name')+"','"+$(this).val()+"')", doneTypingInterval);			

		});

		$(document).on('keydown', '.custom-inputs', function () {
		  	clearTimeout(typingTimer);
		});

		function doneTyping (type, val) {

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

								_html += '<tr>';
								_html += '<td><input type="checkbox" class="pos_trans"></td>';
								_html += '<td data-name="barcode">'+o.plate_no+'</td>';
								_html += '<td data-name="description">'+o.trucker+'</td>';
								_html += '<td>'+o.mode_of_payment+'</td>';
								_html += '</tr>';

							});

							_html += '</tbody>';

							$('#pop_ups_inner ').append(_html);

							$('#pop_ups_wrap').modal({
								backdrop : 'static' ,
								show 	 : true
							});						

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
								_html += '<td><input type="checkbox" class="pos_trans"></td>';
								_html += '<td data-name="barcode">'+o.barcode+'</td>';
								_html += '<td data-name="description">'+o.description+'</td>';
								_html += '<td>'+o.s_qty+'</td>';
								_html += '<td>'+o.qty_with_pcv+'</td>';
								_html += '<td data-name="qty_for_installation"><input type="number" step="1" class="form-control"></td>';
								_html += '</tr>';

							});

							_html += '</tbody>';

							$('#pop_ups_inner ').append(_html);

							$('#pop_ups_wrap').modal({
								backdrop : 'static' ,
								show 	 : true
							});

						}

					}

				});
			}

		}

		function getAccountTransactions() {

			let _account_transactions = JSON.parse($('#pcv_accounts').val());
			let _base_url = "{!! env('APP_URL') !!}";

			$.each(_account_transactions, function(i, data){
				
				if($('#btn-add-account-details').length > 0) {
							
					let _html = '<tr>';

					$('.tbl-header').each(function(ii, res) {

						if($(this).data('rowname').trim() != 'action') { 
							_html += '<td>' + data[$(this).data('rowname')] + '</td>';							
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

				} else {
					$('.custom-inputs').each(function(i, d) {
						$(this).val(data[$(this).attr('data-name')]);
					});

				}

			});

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
						$('#docdata_0'+i).val(moment(data.date).format('YYYY-MM-DD'));
						$('#docref_0'+i).val(data.ref);
					} else {
						$('#type_'+i).val(data.type);
						$('#docrefstring_'+i).val(data.attachment);
						$('#docdate_'+i).val(moment(data.date).format('YYYY-MM-DD'));
						$('#docref_'+i).val(data.ref);
					}

				} else {

					$('#type').val(data.type);
					$('#docrefstring').val(data.attachment);
					$('#docdate').val(moment(data.date).format('YYYY-MM-DD'));
					$('#docref').val(data.ref);

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
	        $('#docdate', newElement).attr("id", field2.split("_")[0]+"_"+id ).val(new moment().format('YYYY-MM-DD'));
	        $('#docref', newElement).attr("id", field3.split("_")[0]+"_"+id ).val('');
			$('#docrefstring', newElement).attr("id", field4.split("_")[0]+"_"+id ).val('');

	        newElement.appendTo($("#attachment-outter-wrapper"));

	    }

	    function resetAccountForm() {

	    	$('.custom-inputs').each(function() {

	    		if($(this).is("select")) {
	    			$(this).val($(this).find("option:first-child").val());
	    		} else if($(this).is('type') != 'date') {
	    			$(this).val('');
	    		}

	    	});

	    }


	</script>

@endsection


