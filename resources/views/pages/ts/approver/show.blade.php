@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="{{ route('approver.ts.index') }}">Temporary Slip</a></li>
					<li class="breadcrumb-item active" aria-current="page">Show</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Temporary Slip Form</h4>
		</div>

	</div>	

	@include('components.messages')

	<div class="row">
		
		<div class="col-lg-6">
			<div class="form-group row">
				<label for="temporary-slip-no" class="col-lg-5 col-form-label">Temporary Slip No.</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" id="ts_no" name="ts_no" readonly
						value="{{ $ts->ts_no }}">
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="date" class="col-lg-2 col-form-label">Date</label>
				<div class="col-lg-10">
					<input type="text" class="form-control wd-100p wd-lg-250" readonly
						value="{{ \Carbon\Carbon::parse($ts->date_created)->toFormattedDateString() }}">
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
					<input type="text" value="{{ $ts->account_name }}" class="form-control" readonly>
				</div>
			</div>
		</div>

		<div class="col-lg-6"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="amount" class="col-lg-5 col-form-label">Amount</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" readonly value="{{ $ts->amount }}">
				</div>
			</div>
		</div>

		<div class="col-lg-6"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="description" class="col-lg-5 col-form-label">Description</label>
				<div class="col-lg-7">
					<textarea id="description" name="description" class="form-control" rows="3" readonly>{{ $ts->description }}</textarea>
				</div>
			</div>
		</div>

		<div class="col-lg-6"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="received_date" class="col-lg-5 col-form-label">Received Date</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" id="received_date" name="received_date"
						value="{{ \Carbon\Carbon::parse($ts->received_date)->toFormattedDateString() }}" readonly>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6"></div>

		<div class="col-lg-6">
			<div class="form-group row">
				<label for="received_by" class="col-lg-5 col-form-label">Received By</label>
				<div class="col-lg-7">
					<input type="text" class="form-control" id="received_by" name="received_by"
						value="{{ $ts->received_by }}" readonly>
				</div>
			</div>
		</div>

		<div class="col-lg-6"></div>

		@if($ts->user->getUserAssignTo() == 'ssc')

	        @if( auth()->user()->position == 'department head' && $ts->status == 'submitted' )

	        	<div class="col-lg-12 mg-t-20">
					<button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-approve"
						data-action="approved" data-id="{{ $ts->id }}">
						<i class="mg-r-5" data-feather="thumbs-up"></i> Approved
					</button>
					<button type="button" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-disapprove"
						data-action="disapprove" data-id="{{ $ts->id }}" data-target="#tsDisapprove" data-backdrop="static" 
						data-toggle="modal" data-dismiss="modal">
						<i class="mg-r-5" data-feather="thumbs-down"></i> Disapproved
					</button>
				</div>

	        @elseif( auth()->user()->position == 'division head' &&  ( $ts->status == 'confirmed' || $ts->status == 'approved' ) 
            && $ts->tl_approved == 1 )

            	<div class="col-lg-12 mg-t-20">
					<button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-approve"
						data-action="approved" data-id="{{ $ts->id }}">
						<i class="mg-r-5" data-feather="thumbs-up"></i> Approved
					</button>
					<button type="button" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-disapprove"
						data-action="disapprove" data-id="{{ $ts->id }}" data-target="#tsDisapprove" data-backdrop="static" 
						data-toggle="modal" data-dismiss="modal">
						<i class="mg-r-5" data-feather="thumbs-down"></i> Disapproved
					</button>
				</div>

	        @endif

		@elseif($ts->status == 'submitted')

			<div class="col-lg-12 mg-t-20">
				<button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-approve"
					data-action="approved" data-id="{{ $ts->id }}">
					<i class="mg-r-5" data-feather="thumbs-up"></i> Approved
				</button>
				<button type="button" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-disapprove"
					data-action="disapprove" data-id="{{ $ts->id }}" data-target="#tsDisapprove" data-backdrop="static" 
					data-toggle="modal" data-dismiss="modal">
					<i class="mg-r-5" data-feather="thumbs-down"></i> Disapproved
				</button>
			</div>

		@endif

    </div>

	@include('_partials.ts_popups')
	
@endsection

@section('pagejs')

	<script type="text/javascript">
		
		$(document).on('click', '.btn-submit-approve', function(e) {

			e.preventDefault();
			let _url = "";

			$('#confirm-footer').show();
			
			$.ajax({

				url 	: "{!! env('APP_URL') !!}/ts/approver/approve/"+$(this).data('id') ,
				method	: 'PUT' ,
				data 	: { _token : "{!! csrf_token() !!}" , action : $(this).data('action') } ,
				success : function (res) {
				
					if(!res.need_code) {
                        $('#confirm-footer').hide();
                        setTimeout(function(){
                            $('#ts_confirm_message').modal('hide');
                            location.reload();
                        }, 3000);
                    } 

                    $('#ts_confirm_message').modal({
                        backdrop : 'static' ,
                        show : true
                    });

                    $('#ts_message').text(res.message);

				}

			})
			
		});


		$(document).on('click', '#btn_disapproval', function(e) {

			e.preventDefault();
			let _url = "";

			$.ajax({

				url 	: "{!! env('APP_URL') !!}/ts/approver/disapprove/"+$('#ts_id').val() ,
				method	: 'PUT' ,
				data 	: { _token : "{!! csrf_token() !!}" , remarks : $('#disapprove-remarks').val() } ,
				success : function (res) {
					
					console.log(res);
					$('#ts_message').text(res.message);
					$('#confirm-footer').hide();
					$('#ts_confirm_message').modal({
						backdrop : 'static' ,
						show : true
					});

					$('#tsDisapprove').modal('hide');
					setTimeout(function(){
						$('#ts_confirm_message').modal('hide');
						location.reload();
					}, 3000);
				}

			})
			
		});
		

		$(document).on('click', '#btn_approval_code', function(e) {

			e.preventDefault();
			let _url = "";

			$.ajax({

				url 	: "{!! env('APP_URL') !!}/ts/approver/approve-with-code/"+$('#ts_id').val(),
				method	: 'PUT' ,
				data 	: { 
					_token  : "{!! csrf_token() !!}" ,
					code 	: $('#approval_code').val() ,
					name 	: $('#approver_name').val() ,
					remarks : $('#remarks').val()
				} ,
				success : function (res) {
				
					$('#ts_message').text(res.message);

					$('#ts_confirm_message').modal({
						backdrop : 'static' ,
						show : true
					});

					$('#approval_code').val('');
					$('#approval_code').val('');
					$('#remarks').val('');

					$('#confirm-footer').hide();

					$('#tsInputApprovalCode').modal('hide');

					setTimeout(function(){
						$('#ts_confirm_message').modal('hide');
						location.reload();
					}, 3000);

				}

			})
			
		});


	</script>

@endsection