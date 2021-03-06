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
					<li class="breadcrumb-item"><a href="#">Petty Cash Voucher</a></li>
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
                            <textarea id="description" name="description" class="form-control bd-0 bd-bottom" rows="3" readonly style="height: 120px;">Sample Description</textarea>
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

                <div class="col-lg-12">
                    <hr class="mg-t-10 mg-b-40">
                </div>

        </div>


        <div class="row" id="account-wrapper">

            <div class="col-lg-12">

                <div data-label="{{ $pcv->account_name }}" class="df-example" id="attachment-outter-wrapper">

                    @if(count($pcv->account_transactions))

                        <div class="dataTables_responsive">
    
                            <table id="account-transactions-list" class="table dataTable no-footer">
                                    
                                <thead>
                                    <tr role="row">
                                        @foreach($pcv->account_transactions[0]['details'] as $key => $tbl_headers)
                                            <td data-rowname="{{ strtolower(str_replace(' ', '_', $key)) }}" class="tbl-header tx-uppercase"> {{ $key }} </td>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    
                                    @foreach( $pcv->account_transactions as $transaction )

                                        <tr>
                                            @foreach( $transaction['details'] as $detail )
                                                <td>{{ $detail }}</td>
                                            @endforeach
                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>
                        
                        </div>

                    @else

                        <h3 class="text-center"> No Account Transaction Found </h3>

                    @endif


                </div>

            </div>

        </div>

         <br><br>

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
                            @foreach( $pcv->attachments as $attachment )
                                <tr role="row">
                                    <td>{{ $attachment->type }}</td>
                                    <td>
                                        <a href='{{ \Storage::url("pcv/{$pcv->pcv_no}/{$attachment->attachment}") }}' target="_blank">
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


        </div>

	</div>

@endsection

@section('pagejs')
	
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script>

    </script>

@endsection