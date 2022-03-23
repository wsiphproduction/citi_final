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
                    <li class="breadcrumb-item"><a href="{{ route('requestor.pcv.index') }}">Petty Cash Voucher</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
            <h4 class="mg-b-0 tx-spacing--1">Petty Cash Vouchers</h4>
        </div>

    </div>

	@include('components.messages')

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
                                            @if($pcv->account_name == 'Delivery Charges')
                                            <td></td>
                                            @endif
                                            <td class="tx-bold text-right align-middle">Total Amount</td>
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

                        </div>

                    </div>

                </div>
            <br><br>    
            @endif

            @if($pcv->account_name != 'Delivery Charges')

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
                                        <td>{{ ucfirst($attachment->type) }}</td>
                                        <td>
                                            <a href='{{ env('APP_URL')."/storage/pcv/{$pcv->pcv_no}/{$attachment->attachment}"}}' target="_blank">
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
            @endif

        </div>

	</div>

    
    <div class="col-lg-12 mg-t-20"> 
        @if($pcv->status == 'saved')
            <form action="{{ route('requestor.pcv.status-update', $pcv->id) }}" method="POST" class="d-lg-inline">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="submitted">
            
                <button type="submit" class="btn btn-primary mr-lg-1 mb-2 mb-lg-0 d-lg-inline wd-100p wd-lg-150"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send mg-r-5"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>Submit
                </button>                           
            </form>
        @endif

        @if($pcv->status == 'submitted' && !$pcv->attachments()->where('type', 'pcv signed')->first())

            <div class="row">
            <div data-label="Attachment" class="df-example col-lg-10" id="attachment-outter-wrapper">

                <form method="POST" action="{{ route('requestor.pcv.pcv-signed-attachment', $pcv->id) }}" >
                    @csrf
                    @method('PUT')

                    <div class="attachment-wrapper mg-t-20" id="attachment-inner-wrapper">
                        <div class="pd-15 pt-4 border mg-b-20">
                            <div class="row row-xs">
                    
                                <div class="col-lg-3">
                                    <div class="form-group">
                                    
                                        <label for="attachment-type" class="d-block tx-14">Attachment Type</label>
                                        
                                        <select class="custom-select" name="type" id="type" readonly>
                                            <option value="pcv signed" selected>PCV Signed</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="d-block tx-14">Document</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input document-f" id="document" data-from="pcv">
                                            <label class="custom-file-label" for="document">Choose file</label>
                                            <input type="hidden" name="docrefstring" id="docrefstring" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="doc-ref-date" class="d-block tx-14">Doc. Ref Date</label>
                                        <input type="date" class="form-control" name="docdate" id="docdate" value="{{ date('Y-m-d') }}">
                                        <input type="hidden" name="docref" value="pcv signed">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="doc-ref-date" class="d-block tx-14">&nbsp;</label>
                                        <button type="submit" class="btn btn-primary"> Upload Attachment </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </form>

            </div>
            </div>

        @endif

        @if($pcv->status == 'submitted' || $pcv->status == 'approved')
            <div class="col-lg-12 mg-t-20">     
                <a href="{{ route('requestor.pcv.print', $pcv->id) }}" target="_blank" 
                    class="btn btn-secondary mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    Print
                </a>                    
            </div>
        @endif
    </div>

    @include('_partials.request_pcv_popups')

@endsection

@section('pagejs')
	
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script>

        $(document).on('click', '#btn_received', function() {

            $('#pcvReceived').modal('hide');

            $.ajax({

                url         : "{!! env('APP_URL') !!}/pcv/requestor/received-pcv/"+{!! $pcv->id !!} ,
                method      : 'PUT' ,
                data        : {
                    _token  : "{!! csrf_token() !!}" ,
                    name    : $('#received_by').val() ,
                    date    : $('#received_date').val()
                } ,
                success     : function(res) {
                    console.log(res);

                    $('#pcv_confirm_message').modal('show');
                    $('#pcv_message').text(res.message);

                    setTimeout(function(){

                        $('#pcv_confirm_message').modal('hide');
                        location.reload();

                    }, 2000);

                }

            })

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

    </script>

@endsection