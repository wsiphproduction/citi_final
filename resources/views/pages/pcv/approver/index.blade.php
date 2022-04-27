@extends('layouts.app')

@section('pagecss')

    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">

@endsection

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item active" aria-current="page">Petty Cash Voucher</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Petty Cash Vouchers</h4>
		</div>

	</div>	
    
    @include('components.messages')

	<div class="row">

        <div class="col-lg-12">

        	<div class="float-right">
        		<button class="btn btn-primary btn-sm mb-2" id="approve-all" > Approve All </button>
        	</div>

            <table id="example1" class="table">

                <thead>
                    <tr>
                    	<td><input type="checkbox" id="checkAllsubmitted"></td>
                        <td>Date</td>
                        <td>PCV No.</td>
                        <td>Account</td>
                        <td>Amount</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                </thead>
                
                <tbody>
                    @forelse( $pcvs as $pcv )
	                  	<tr>
	                  		<td><input type="checkbox" data-id="{{ $pcv->id }}" class="submittedData" @if($pcv->status != 'submitted') disabled @endif ></td>
	                        <td> {{ \Carbon\Carbon::parse($pcv->date_created)->toFormattedDateString() }} </td>
	                        <td> {{ $pcv->pcv_no }} </td>
	                        <td> {{ $pcv->account_name }} </td>
	                        <td> {{ number_format($pcv->amount, 2, '.', ',') }} </td>
	                        <td>
	                        	<span class="badge badge-secondary tx-uppercase"> {{ $pcv->status }} </span>
	                        </td>
	                        <td>
	                        	<nav class="nav table-options">
	                                <a class="nav-link p-0 pl-2" href="{{ route('approver.pcv.show', $pcv->id) }}" title="View Request">
	                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
	                                </a>
	                            </nav>
	                        </td>
	                  	</tr>
                    @empty
	                	<tr>
	                		<td class="text-center" colspan="6"> No PCV Found </td>
	                	</tr>
                    @endforelse
                </tbody>

            </table>
        </div>

	</div>

	<div class="modal fade" id="pcvInputApprovalCode" tabindex="-1" role="dialog" 
		aria-labelledby="pcvInputApprovalCode" aria-modal="true">

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
								<input type="hidden" id="pcv_id" >
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
					<button type="button" class="btn btn-white tx-13 tx-uppercase" data-target="#pcvInputApprovalCode" data-toggle="modal" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>

	</div>

	<div class="modal fade effect-scale" id="pcv_confirm_message" tabindex="-1" 
		role="dialog" aria-labelledby="pcv_confirm_message" 
		aria-modal="true">

		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content tx-14">
				
				<div class="modal-header">
					<h6 class="modal-title" id="exampleModalLabel3">Confirmation Message</h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>

				<div class="modal-body">
					<p class="mb-0" id="pcv_message"></p>
				</div>

			</div>
		</div>

	</div>


@endsection

@section('pagejs')
	
	<script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script>

    	var _pcvs = [];
    	var _i = 0;
    	var _approve_pcvs = [];

		$(function(){
			'use strict'

			$('#example1').DataTable({
				"aaSorting": [],
				language: {
				searchPlaceholder: 'Search',
				sSearch: '',
				lengthMenu: 'Show _MENU_ entries',
				},
				columnDefs: [
					{	 targets: [0, 6], bSortable: false }
				]
			});
		});

		$(document).on('click', '#checkAllsubmitted', function() {

			if($(this).is(':checked')) {
				$('.submittedData').not(':disabled').attr('checked', 'checked');
			} else {
				$('.submittedData').attr('checked', false);
			}

		});

		$(document).on('click', '#approve-all', function() {

			$('.submittedData').each(function(i, o) {

				if($(this).is(':checked')) {					
					
					_pcvs.push($(this).data('id'));
		           
				}

			});

			get_next();

		});

		function get_next() {
		    
		    if (!_pcvs[_i]) {
		    	$('#pcv_message').text("TS " + JSON.stringify(_approve_pcvs) + " is successfully approved");
		    	$('#pcv_confirm_message').modal({
                	backdrop : 'static' ,
                    show : true
                });
                setTimeout(function(){
                	$('#pcv_confirm_message').modal('hide');
                	location.reload();
                }, 3000);
		        return;
		    }
		    
		    $.ajax({

                url     : "{!! env('APP_URL') !!}/pcv/approver/approve/"+_pcvs[_i] ,
                method  : 'PUT' ,
                data    : { _token : "{!! csrf_token() !!}" } ,
                success : function (res) {

                	if(res.need_code) {
	                    	
                    	$('#pcv_id').val(res.pcv_id);
	                    $('#pcvInputApprovalCode').modal({
	                    	backdrop : 'static' ,
	                        show : true
	                    });

	                    _approve_pcvs.push(res.pcv_no);

		            } else {

		            	_i++;
		            	_approve_pcvs.push(res.pcv_no);
		            	get_next();

		            }

                } , 
                error: function (jqXHR, textStatus, errorThrown) {
		            // Empty most of the time...
		            _i++;
		            get_next();
		        }
            	 

            });

		}

		// async function approvePcv(id) {

		// 	let _res;
		// 	console.log(id);
		// 	_res = await $.ajax({

	 //                url     : "{!! env('APP_URL') !!}/pcv/approver/approve/"+id ,
	 //                method  : 'PUT' ,
	 //                async   : false ,
	 //                data    : { _token : "{!! csrf_token() !!}" ,
	 //                success : function (res) {
	 //                	console.log(res);
	 //                	if(res.need_code) {
		                    	
	 //                    	$('#pcv_id').val(res.pcv_id);
	

		//                     $('#pcvInputApprovalCode').modal({
		//                         backdrop : 'static' ,
		//                         show : true
		//                     });

		// 	            }
	 //                }

  //           	} 

  //           });

		// 	return _res;

		// }

		$(document).on('click', '#btn_approval_code', function(e) {

            e.preventDefault();
            let _url = "";

            if($('#approval_code').val() == '') {
                alert('Approval Code is required');
                return false;
            }

            if($('#approver_name').val() == '') {
                alert('Approver name is required');
                return false;
            }

            if($('#remarks').val() == '') {
                alert('Remarks is required');
                return false;
            }

            $.ajax({

                url     : "{!! env('APP_URL') !!}/pcv/approver/approve-with-code/"+$('#pcv_id').val(),
                method  : 'PUT' ,
                async   : false ,
                data    : { 
                    _token  : "{!! csrf_token() !!}" ,
                    code    : $('#approval_code').val() ,
                    name    : $('#approver_name').val() ,
                    remarks : $('#remarks').val()
                } ,
                success : function (res) {
                
                    // $('#pcv_message').text(res.message);

                    // $('#pcv_confirm_message').modal({
                    //     backdrop : 'static' ,
                    //     show : true
                    // });

                    $('#approver_name').val($("#approver_name option:first").val());
                    $('#approval_code').val('');
                    $('#remarks').val('');
                    $('#pcv_id').val('');

                    $("#pcvInputApprovalCode").removeClass("in");
					$(".modal-backdrop").remove();
					$('body').removeClass('modal-open');
					$('body').css('padding-right', '');
                	$('#pcvInputApprovalCode').modal('hide');

                    _i++;
                    get_next();

                }

            })
            
        });

    </script>


@endsection