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
                    <input type="text" class="form-control" readonly
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
                                <td> 
                                    <a href="{{ route('pcfr.show-pcv', $pcv->id) }}" target="_blank"> {{ $pcv->pcv_no }} </a> 
                                </td>
                                <td> {{$pcv->description }} </td>
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
                          <td class="tx-bold align-middle">Total</td>
                          <td>
                            <input type="text" class="form-control tx-brand-01 w-auto d-inline" placeholder="Total" aria-controls="total" 
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
                        id="temporary_slip" name="temporary_slip" value="{{ number_format($pcfr->total_temp_slip, 2, '.', ',') }}" readonly>
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
                        readonly value="{{ number_format($pcfr->atm_balance, 2, '.', ',') }}">
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
                        value="{{ number_format($pcfr->cash_on_hand, 2, '.', ',') }}" readonly>
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
                <label for="pcf-accounted-for" class="col-lg-5 col-form-label">PCF Accounted For </label>
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

        <div class="col-lg-6"></div>

        <div class="col-lg-12">
            <hr class="mg-t-20 mg-b-40">
        </div>

        <div class="col-lg-12 mg-t-50">
            <div data-label="Attachment" class="df-example" id="attachment-outter-wrapper">
                
                <div class="dataTables_responsive">
                    <table class="table dataTable no-footer">

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
                                        <a href='{{ env('APP_URL')."storage/pcfr/{$pcfr->pcfr_no}/{$attachment->attachment}" }}' target="_blank">
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
        </div>

    </div>
    
@endsection
