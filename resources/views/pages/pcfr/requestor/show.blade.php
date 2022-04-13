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
            @if(\Str::contains($pcfr->status , 'disapproved'))          
                <div class="form-group row">
                    <label for="date" class="col-lg-5 col-form-label">Remarks</label>
                    <div class="col-lg-7">
                        <textarea id="description" name="description" class="form-control bd-0 bd-bottom" rows="3" readonly style="height: 120px;">{{ $pcfr->remarks }} </textarea>
                    </div>
                </div>          
            @endif
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
                          <td class="tx-bold align-middle">Total</td>
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
		
        </div>

        <div class="col-lg-12 mg-t-20"> 

            @if($pcfr->status != 'saved' && !\Str::contains($pcfr->status , 'disapproved'))
                <a href="{{ route('requestor.pcfr.print', $pcfr->id) }}" target="_blank" 
                    class="btn btn-secondary mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    Print
                </a> 
            @endif

        </div>

    </div>
	
@endsection
