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

    @include('components.messages')

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
                            @if(auth()->user()->position == 'payables staff'
                                && is_null($pcfr->py_staff_approved) && count($pcfr->pcv) )
                                <th class="wd-20p tx-uppercase">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( $pcfr->pcv as $pcv ) 
                            <tr>
                                <td> {{ $pcv->pcv_no }} </td>
                                <td> {{$pcv->description }} </td>
                                <td> {{ $pcv->account_name }} </td>
                                <td> {{ $pcv->user->branch->name }} </td>
                                <td> {{ $pcv->amount }} </td>
                                @if(auth()->user()->position == 'payables staff' 
                                    && is_null($pcfr->py_staff_approved ))
                                <td> 

                                    <nav class="nav table-options justify-content-start">
                                        <a class="nav-link p-0 pl-2 remove_attachment" href="javascript:void(0);" title="Remove" data-target="#pcvRemove{{$pcv->id}}" data-toggle="modal" data-dismiss="modal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </a>
                                    </nav>

                                    <div class="modal fade" id="pcvRemove{{$pcv->id}}" tabindex="-1" role="dialog" 
                                        aria-labelledby="pcvRemove{{$pcv->id}}" aria-modal="true">

                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content tx-14">
                                                
                                                <div class="modal-header">
                                                    <h6 class="modal-title" id="exampleModalLabel3">Input Remarks</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">??</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">                                                        
                                                    
                                                    <form action="{{ route('payable.pcfr.pcv-remove', $pcv->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                    
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label for="remarks" class="d-block">Remarks</label>
                                                                    <textarea id="disapprove-remarks" name="remarks" 
                                                                        class="form-control" rows="3"></textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-lg-12 text-right">
                                                                <button class="btn btn-brand-01 d-inline-block tx-13 tx-uppercase">Remove</button>
                                                                <button type="button" class="btn btn-white tx-13 tx-uppercase" 
                                                                    data-target="#pcvRemove{{$pcv->id}}" data-toggle="modal" 
                                                                    data-dismiss="modal">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </div>  

                                                    </form>
                                                     
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </td>
                                @endif
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
                <label for="pcf-accounted-for" class="col-lg-5 col-form-label">PCF Accounted For </label>
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

        @if($pcfr->user->getUserAssignTo() == 'ssc')

            @if( ($pcfr->status == 'submitted' || $pcfr->status == 'confirmed') || ($pcfr->status == 'approved' && $pcfr->dh_approved) )

                <div class="col-lg-12 mg-t-20">
                    <button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-approve"
                        data-action="approved" data-id="{{ $pcfr->id }}">
                        <i class="mg-r-5" data-feather="thumbs-up"></i> Approved
                    </button>
                    <button type="button" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-disapprove"
                        data-action="disapproved" data-id="{{ $pcfr->id }}" data-target="#pcfrDisapprove" data-backdrop="static" 
                        data-toggle="modal" data-dismiss="modal">
                        <i class="mg-r-5" data-feather="thumbs-down"></i> Disapproved
                    </button>
                </div>

            @endif

        @else

            @if($pcfr->status == 'approved' && $pcfr->tl_approved == 1 && is_null($pcfr->py_staff_approved) )

                <div class="col-lg-12 mg-t-20">
                    <button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-approve"
                        data-action="approved" data-id="{{ $pcfr->id }}">
                        <i class="mg-r-5" data-feather="thumbs-up"></i> Approved
                    </button>
                    <button type="button" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150 btn-submit-disapprove"
                        data-action="disapproved" data-id="{{ $pcfr->id }}" data-target="#pcfrDisapprove" data-backdrop="static" 
                        data-toggle="modal" data-dismiss="modal">
                        <i class="mg-r-5" data-feather="thumbs-down"></i> Disapproved
                    </button>
                </div>
            @endif

        @endif

    </div>
    
    @include('_partials.payable_pcfr_popups')

@endsection

@section('pagejs')
    
    <script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/moment.js') }}"></script>
    <script type="text/javascript">
        
        $(document).on('click', '#btn_disapproval', function(e) {

            e.preventDefault();
            let _url = "";
            let _pcfr_id = {!! $pcfr->id !!};

            $.ajax({

                url     : "{!! env('APP_URL') !!}/pcfr/payables/disapprove/"+_pcfr_id,
                method  : 'PUT' ,
                data    : { _token : "{!! csrf_token() !!}" , remarks : $('#disapprove-remarks').val() } ,
                success : function (res) {
                    
                    console.log(res);
                    $('#pcfr_message').text(res.message);
                    $('#confirm-footer').hide();
                    $('#pcfr_confirm_message').modal({
                        backdrop : 'static' ,
                        show : true
                    });

                    $('#pcfrDisapprove').modal('hide');
                    setTimeout(function(){
                        $('#pcfr_confirm_message').modal('hide');
                        location.reload();
                    }, 3000);
                }

            })
            
        });

        $(document).on('click', '.btn-submit-approve', function(e) {

            e.preventDefault();
            let _url = "";
            let _pcfr_id = {!! $pcfr->id !!};

            $('#confirm-footer').show();
           
            $.ajax({

                url     : "{!! env('APP_URL') !!}/pcfr/payables/approve/"+_pcfr_id ,
                method  : 'PUT' ,
                data    : { _token : "{!! csrf_token() !!}" , action : $(this).data('action') } ,
                success : function (res) {
                
                    if(!res.need_code) {
                        $('#confirm-footer').hide();
                        setTimeout(function(){
                            $('#pcfr_confirm_message').modal('hide');
                            location.reload();
                        }, 3000);
                    } 

                    $('#pcfr_confirm_message').modal({
                        backdrop : 'static' ,
                        show : true
                    });

                    $('#pcfr_message').text(res.message);

                }

            })
            
        });

    </script>

@endsection