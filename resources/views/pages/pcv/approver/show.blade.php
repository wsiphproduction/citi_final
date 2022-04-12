@extends('layouts.app')

@section('pagecss')

    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">

@endsection

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="{{ route('approver.pcv.index') }}">Petty Cash Voucher</a></li>
					<li class="breadcrumb-item active" aria-current="page">Show</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Petty Cash Voucher Request</h4>
		</div>

	</div>	

	<div class="row">

        <div class="col-lg-12">
            
            <div class="row">

                <div class="col-lg-12 mg-b-20">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="with-temporary-slip" readonly disabled
                            @if(!is_null($pcv->slip_no)) checked @endif>
                        <label class="custom-control-label" for="with-temporary-slip">With Temporary Slip</label>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="slip-no" class="col-lg-5 col-form-label">Slip No.</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control bd-0 bd-bottom" id="slip-no" readonly value="{{ $pcv->slip_no }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="change" class="col-lg-5 col-form-label">Change</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control bd-0 bd-bottom" id="change" name="change" readonly value="{{ $pcv->change }}">
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
                            <input type="text" class="form-control bd-0 bd-bottom" id="account" name="account" readonly
                                value="{{ $pcv->account_name }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="pcv-no" class="col-lg-5 col-form-label">PCV No.</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control bd-0 bd-bottom" id="pcv-no" name="pcv-no" readonly
                                value="{{ $pcv->pcv_no }}">
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="description" class="col-lg-5 col-form-label">Description</label>
                        <div class="col-lg-7">
                            <textarea id="description" name="description" class="form-control bd-0 bd-bottom" rows="3" readonly style="height: 120px;">{{ $pcv->description }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="date" class="col-lg-5 col-form-label">Date</label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control bd-0 bd-bottom" id="date" name="date" readonly
                                value="{{ \Carbon\Carbon::parse($pcv->date_created)->toFormattedDateString() }}">
                        </div>
                    </div>
                </div>

                @if(\Str::contains($pcv->status , 'disapproved' ) || $pcv->status == 'cancelled')

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="date" class="col-lg-5 col-form-label">Remarks</label>
                            <div class="col-lg-7">
                                <textarea id="description" name="description" class="form-control bd-0 bd-bottom" rows="3" readonly style="height: 120px;">{{ $pcv->remarks }} </textarea>
                            </div>
                        </div>
                    </div>

                @endif

                <div class="col-lg-12">
                    <hr class="mg-t-10 mg-b-40">
                </div>

        </div>


        <div class="row" id="account-wrapper">

                <div class="col-lg-12">

                    <div data-label="{{ $pcv->account_name }}" class="df-example" id="attachment-outter-wrapper">

                        @if($pcv->account_transaction)

                            <div class="dataTables_responsive">
        
                                <table id="account-transactions-list" class="table dataTable no-footer">
                                        
                                    <thead>
                                        <tr role="row">
                                            @if(array_key_exists(0, $pcv->account_transaction['details']))
                                                @foreach($pcv->account_transaction['details'][0] as $key => $tbl_headers)
                                                @if($key != 'items')
                                                <td data-rowname="{{ strtolower(str_replace(' ', '_', $key)) }}" class="tbl-header tx-uppercase"> {{ $key }} </td>
                                                @endif
                                                @endforeach
                                            @else
                                                @foreach($pcv->account_transaction['details'] as $key => $tbl_headers)
                                                @if($key != 'items')
                                                <td data-rowname="{{ strtolower(str_replace(' ', '_', $key)) }}" class="tbl-header tx-uppercase"> {{ $key }} </td>
                                                @endif
                                                @endforeach
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        
                                        @if(array_key_exists(0, $pcv->account_transaction['details']))
                                        
                                            @foreach( $pcv->account_transaction['details'] as $transaction )
    
                                                <tr>
                                                    @if(is_array($transaction)) 
    
                                                        @foreach($transaction as $d)
                                                            @if(is_array($d))
                                                                @continue
                                                            @else
                                                                <td> {{ $d }} </td>
                                                            @endif
                                                        @endforeach
    
                                                    @else
    
                                                        <td>{{ $transaction }}</td>
    
                                                    @endif
                                                </tr>
                                                    
                                            @endforeach
                                            
                                        @else
                                            <tr>
                                            @foreach( $pcv->account_transaction['details'] as $transaction )
    
                                                
                                                    @if(is_array($transaction)) 
    
                                                        @foreach($transaction as $d)
                                                            @if(is_array($d))
                                                                @continue
                                                            @else
                                                                <td> {{ $d }} </td>
                                                            @endif
                                                        @endforeach
    
                                                    @else
    
                                                        <td>{{ $transaction }}</td>
    
                                                    @endif
                                                
                                                    
                                            @endforeach
                                            </tr>
                                        
                                        @endif

                                    </tbody>

                                    @if($pcv->account_name == 'Stripping Charge' 
                                        || $pcv->account_name == 'Delivery Charges' )

                                    <tfoot>
                                        <tr role="row">
                                            <td class="sorting_1"></td>
                                            <td></td>                                        
                                            <td></td>                                                                                
                                            <td></td>                                                                                    
                                            <td></td>
                                            <td class="tx-bold align-middle">Total</td>
                                            <td>
                                            <input type="number" class="form-control tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" 
                                            value="{{ $pcv->amount }}" readonly>
                                            </td>                                        
                                        </tr>
                                    </tfoot>

                                    @endif

                                </table>
                            
                            </div>

                        @else

                            <h3 class="text-center"> No Account Transaction Found </h3>

                        @endif

                    </div>

                </div>

            </div>

            <br><br>

            @if($pcv->account_name == 'Installation')
                <div class="row" id="account-wrapper">

                    <div class="col-lg-12">

                        <div data-label="{{ $pcv->account_name }} Items" class="df-example" id="attachment-outter-wrapper">

                            @if($pcv->account_transaction)

                                <div class="dataTables_responsive">
            
                                    <table id="account-transactions-list" class="table dataTable no-footer">
                                            
                                        <thead>
                                            <tr role="row">
                                                @if(array_key_exists(0, $pcv->account_transaction['details']))
                                                    @foreach($pcv->account_transaction['details'][0]['items'] as $key => $tbl_headers)
                                                    @if($key != 'items')
                                                    <td data-rowname="{{ strtolower(str_replace(' ', '_', $key)) }}" class="tbl-header tx-uppercase"> {{ $key }} </td>
                                                    @endif
                                                    @endforeach
                                                @else
                                                    @foreach($pcv->account_transaction['details']['items'] as $key => $tbl_headers)
                                                    @if($key != 'items')
                                                    <td data-rowname="{{ strtolower(str_replace(' ', '_', $key)) }}" class="tbl-header tx-uppercase"> {{ $key }} </td>
                                                    @endif
                                                    @endforeach
                                                @endif
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                            @foreach( $pcv->account_transaction['details'] as $transaction )

                                                <tr>

                                                    <td>{{ $transaction['items']['barcode'] }}</td>
                                                    <td>{{ $transaction['items']['description'] }}</td>
                                                    <td>{{ $transaction['items']['qty_for_installation'] }}</td>

                                                </tr>
                                                    
                                            @endforeach

                                        </tbody>

                                    </table>
                                
                                </div>

                            @else

                                <h3 class="text-center"> No Account Transaction Found </h3>

                            @endif

                            @if($pcv->account_name == 'Installation')

                                

                            @endif


                        </div>

                    </div>

                </div>

                <br><br>
            @endif

            <div class="row">
            
                <div class="col-lg-8">

                    <div data-label="Attachment" class="df-example">

                    <div class="dataTables_responsive">
                        
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

                                @forelse( $pcv->attachments as $attachment )

                                    <tr role="row">
                                        <td>{{ ucfirst($attachment->type) }}</td>
                                        <td>
                                            <a href='{{ env('APP_URL')."/storage/pcv/{$pcv->pcv_no}/{$attachment->attachment}"}}' target="_blank">
                                                {{ $attachment->attachment }}
                                            </a>
                                        </td>
                                        <td>{{ $attachment->ref }}</td>
                                        <td>{{ \Carbon\Carbon::parse($attachment->date)->toFormattedDateString() }}</td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" class="text-center"> No Attachment Found </td>
                                    </tr>

                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    </div>

                </div>

            </div>       

        </div>

	</div>

    @if($pcv->status == 'submitted' || $pcv->status == 'confirmed')

        <div class="col-lg-12 mg-t-20">
            <button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-approve"
                data-action="approved" data-id="{{ $pcv->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                Approved
            </button>
            <button type="button" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-disapprove"
                data-action="disapproved" data-id="{{ $pcv->id }}" data-target="#pcvDisapprove" data-backdrop="static" 
                data-toggle="modal" data-dismiss="modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                Disapproved
            </button>
        </div>

    @elseif($pcv->status == 'cancel')

        <div class="col-lg-12 mg-t-20">
            <button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150"
                data-action="cancelled" data-id="{{ $pcv->id }}"  data-target="#pcvApproveCancel" data-backdrop="static" 
                data-toggle="modal" data-dismiss="modal">
                <i class="mg-r-5" data-feather="thumbs-up"></i> Approved
            </button>
            <!-- <button type="button" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-disapprove"
                data-action="disapproved" data-id="{{ $pcv->id }}" data-target="#pcvDisapprove" data-backdrop="static" 
                data-toggle="modal" data-dismiss="modal">
                <i class="mg-r-5" data-feather="thumbs-down"></i> Disapproved
            </button> -->
        </div>

    @endif

    @include('_partials.pcv_popups')

@endsection

@section('pagejs')
	
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        
        $(document).on('click', '.btn-submit-approve', function(e) {

            e.preventDefault();
            let _url = "";

            $('#confirm-footer').show();
           
            $.ajax({

                url     : "{!! env('APP_URL') !!}/pcv/approver/approve/"+$(this).data('id') ,
                method  : 'PUT' ,
                data    : { _token : "{!! csrf_token() !!}" , action : $(this).data('action'),  remarks : $('#remarks').val()} ,
                success : function (res) {
                
                    if(!res.need_code) {
                        $('#confirm-footer').hide();
                        setTimeout(function(){
                            $('#pcv_confirm_message').modal('hide');
                            location.reload();
                        }, 3000);
                    } 

                    $('#pcv_confirm_message').modal({
                        backdrop : 'static' ,
                        show : true
                    });

                    $('#pcv_message').text(res.message);

                }

            })
            
        });


        $(document).on('click', '#btn_disapproval', function(e) {

            e.preventDefault();
            let _url = "";

            if($('#disapprove-remarks').val() == '') { alert('Remarks is required'); return false; }

            $.ajax({

                url     : "{!! env('APP_URL') !!}/pcv/approver/disapprove/"+$('#pcv_id').val() ,
                method  : 'PUT' ,
                data    : { _token : "{!! csrf_token() !!}" , remarks : $('#disapprove-remarks').val() } ,
                success : function (res) {
                    
                    console.log(res);
                    $('#pcv_message').text(res.message);
                    $('#confirm-footer').hide();
                    $('#pcv_confirm_message').modal({
                        backdrop : 'static' ,
                        show : true
                    });

                    $('#pcvDisapprove').modal('hide');
                    setTimeout(function(){
                        $('#pcv_confirm_message').modal('hide');
                        location.reload();
                    }, 3000);
                }

            })
            
        });


        $(document).on('click', '#btn_approve_cancel', function(e) {

            e.preventDefault();
            let _url = "";

            if($('#approve-cancel-remarks').val() == '') { alert('Remarks is required'); return false; }

            $("#pcvApproveCancel").modal('hide');

            $.ajax({

                url     : "{!! env('APP_URL') !!}/pcv/approver/approve-cancel/"+$('#pcv_id').val() ,
                method  : 'PUT' ,
                data    : { _token : "{!! csrf_token() !!}" , remarks : $('#approve-cancel-remarks').val() } ,
                success : function (res) {
                    
                    $('#pcv_message').text(res.message);
                    $('#confirm-footer').hide();
                    $('#pcv_confirm_message').modal({
                        backdrop : 'static' ,
                        show : true
                    });

                    $('#pcvDisapprove').modal('hide');
                    setTimeout(function(){
                        $('#pcv_confirm_message').modal('hide');
                        location.reload();
                    }, 3000);
                }

            })
            
        });
        

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
                data    : { 
                    _token  : "{!! csrf_token() !!}" ,
                    code    : $('#approval_code').val() ,
                    name    : $('#approver_name').val() ,
                    remarks : $('#remarks').val()
                } ,
                success : function (res) {
                
                    $('#pcv_message').text(res.message);

                    $('#pcv_confirm_message').modal({
                        backdrop : 'static' ,
                        show : true
                    });

                    $('#approval_code').val('');
                    $('#approval_code').val('');
                    $('#remarks').val('');

                    $('#confirm-footer').hide();

                    $('#pcvInputApprovalCode').modal('hide');

                    setTimeout(function(){
                        $('#pcv_confirm_message').modal('hide');
                        location.reload();
                    }, 3000);

                }

            })
            
        });


    </script>

@endsection