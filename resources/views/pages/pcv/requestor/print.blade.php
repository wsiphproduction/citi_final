@extends('layouts.app2')

@section('pagecss')

	<style type="text/css">
		
		p {
			font-size: 20px;
			margin-bottom: 0 !important;
			padding: 20px;
		}

		#transaction tr td {

			padding: 15px 0 10px 0;

		}	

		#transaction thead tr, 
		#transaction tbody tr { border: 1px solid black; padding: 20px; color: #000; }

		#transaction td { text-align: center; }

	</style>

@endsection

@section('content')
	
	<div class="col-lg-12 text-center">	

        <img src="{{ asset('img/logo (1).png') }}" alt="Citihardware logo" width="50" style="display: inline-block;">
    
		<h3 style="display: inline-block;"> Pettey Cash Fund Replenishment </h3>
		<h5> Petty Cash Voucher </h5>
		<h6> {{ ucfirst($pcv->status) }} </h6>

	</div>	

	<div style="width: 90%; display: block; margin: 0 auto; margin-top: 30px;">
		
		<div class="row">

			<table class="col-lg-12">
				
				<tr>

					<td width="98%"> 
						<p> <input type="checkbox" disabled @if(!is_null($pcv->slip_no)) checked @endif> &nbsp; Temporary Slip No. </p>
					</td>

				</tr>

			</table>

			<table class="col-lg-12">
				
				<tr>
					
					<td width="10%"> <p> <strong>Slip No</strong>: </p></td>
					<td width="20%" style="border-bottom: 1px solid #000;"> <p> {{ $pcv->slip_no }} </p></td>
					<td width="50%"></td>
					<td width="10%" style="display: none;"> <p> <strong>Change</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000; display: none;"> &nbsp;{{ $pcv->change }} </td>
					
				</tr>

			</table>

			<hr style="width: 100%; border: 1px dashed #000; margin: 50px 0 0 0;">

			<table class="col-lg-12 mt-5">
				
				<tr>
					
					<td width="10%"> <p> <strong>Account Name</strong>: </p></td>
					<td width="20%" style="border-bottom: 1px solid #000;"> <p> {{ $pcv->account_name }} </p></td>
					<td width="10%"> <p> <strong>PCV No</strong>: </p></td>
					<td width="20%" style="border-bottom: 1px solid #000;"> <p> {{ $pcv->pcv_no }} </p></td>

				</tr>

				<tr>
					
					<td width="10%"> <p> <strong>Description</strong>: </p></td>
					<td width="20%" style="border-bottom: 1px solid #000;"> <p> {{ $pcv->description }} </p></td>
					<td width="10%"> <p> <strong>Date</strong>: </p></td>
					<td width="20%" style="border-bottom: 1px solid #000;"> <p> {{ \Carbon\Carbon::parse($pcv->date_created)->toFormattedDateString() }} </p></td>

				</tr>

				@if(count($pcv->attachments))
				@if($pcv->account_name != 'Installation')
				<tr>
					
					<td width="10%"> <p> <strong>Attachments</strong>: </p></td>
					<td width="20%"> 

						<ul class="mg-t-20">
							@foreach($pcv->attachments as $attachment)
								<li>{{ $attachment->attachment }}</li>
							@endforeach
						</ul>

					</td>

				</tr>
				@endif
				@endif
				

			</table>

			@if($pcv->account_name == 'Installation')
			<hr style="width: 100%; border: 1px dashed #000; margin: 50px 0 0 0;">
			<div style="width: 100%; display: block; margin: 0;">

				<table class="col-lg-12 mt-2 mb-3">
				
					<tr>
						
						<td width="10%"> <p> <strong>Vendor</strong>: </p></td>
						<td width="20%" style="border-bottom: 1px solid #000;"> <p> {{ $pcv->account_transaction['details'][0]['vendor'] }} </p></td>
						<td width="10%"> <p> <strong>Rate Per Install</strong>: </p></td>
						<td width="20%" style="border-bottom: 1px solid #000;"> <p> {{ $pcv->account_transaction['details'][0]['rate_per_install'] }} </p></td>
						
					</tr>

					<tr>

						<td width="10%"> <p> <strong>POS Trans No</strong>: </p></td>
						<td width="20%" style="border-bottom: 1px solid #000;"> <p> {{ $pcv->account_transaction['details'][0]['pos_transaction_no'] }} </p></td>
						<td width="10%"> <p> <strong>Quantity</strong>: </p></td>
						<td width="20%" style="border-bottom: 1px solid #000;"> <p> {{ $pcv->account_transaction['details'][0]['quantity'] }} </p></td>
						
					</tr>

					<tr>
						
						<td width="10%"> <p> <strong>Total Amount</strong>: </p></td>
						<td width="20%" style="border-bottom: 1px solid #000;"> <p> {{ $pcv->account_transaction['details'][0]['amount'] }} </p></td>
						@if(count($pcv->attachments))
					
							<td width="10%"> <p> <strong>Attachments</strong>: </p></td>
							<td width="20%"> 

								<ul class="mg-t-20">
									@foreach($pcv->attachments as $attachment)
										<li>{{ $attachment->attachment }}</li>
									@endforeach
								</ul>

							</td>

						@endif
						
					</tr>

					
					

				</table>

			</div>

			<div style="width: 100%; display: block; margin: 50px 0 0;">

				<table class="col-lg-12 mt-5" style="margin-top: 0 !important;" id="transaction">

					<thead>
                        <tr role="row">     

                            @foreach($pcv->account_transaction['details'][0]['items'][0] as $key => $tbl_headers)

                           		<td data-rowname="{{ strtolower(str_replace(' ', '_', $key)) }}" class="tbl-header tx-uppercase"> 
                                	{{ str_replace('_', ' ', $key) }} 
                                </td>

                            @endforeach   

                        </tr>
                    </thead>

                    <tbody>
                       
						<tr>                       

                       	@foreach( $pcv->account_transaction['details'][0]['items'] as $item )

                       		@if(is_array($item)) 
                       			<tr>
                       			@foreach($item as $d)	                            
                            		<td>{{ $d }}</td>
                            	@endforeach
                            	</tr>
                            @else
                            	<td> {{ $item }} </td>
                            @endif
                            	
                        @endforeach

                    	</tr>
                       
                    </tbody>

				</table>

			</div>


			@else

				<div style="width: 100%; display: block; margin: 50px 0 0;">

					<table class="col-lg-12 mt-5" style="margin-top: 0 !important;" id="transaction">

						<thead>
	                        <tr role="row">
	                            @if(array_key_exists(0, $pcv->account_transaction['details']))
	                                @foreach($pcv->account_transaction['details'][0] as $key => $tbl_headers)
	                                @if($key != 'items')
	                                <td data-rowname="{{ strtolower(str_replace(' ', '_', $key)) }}" class="tbl-header tx-uppercase"> 
	                                	{{ str_replace('_', ' ', $key) }} 
	                                </td>
	                                @endif
	                                @endforeach
	                            @else
	                                @foreach($pcv->account_transaction['details'] as $key => $tbl_headers)
	                                @if($key != 'items')
	                                <td data-rowname="{{ strtolower(str_replace(' ', '_', $key)) }}" class="tbl-header tx-uppercase"> 
	                                	str_replace('_', ' ', $key) 
	                                </td>
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
	                            	{{ $pcv->amount }}
	                            </td>                                        
	                        </tr>
	                    </tfoot>

	                    @endif

					</table>

				</div>

			@endif

			<table class="col-lg-12 mt-5">
				
				<tr>
					
					<td width="100%"> <p> <strong> Received By: </strong>  {{ $pcv->received_by }} </p></td>

				</tr>

				<tr>
					
					<td width="100%"> <p> <strong> Received Date: </strong>{{ $pcv->received_date }} </p></td>
					
				</tr>

			</table>

			<table class="col-lg-12 mt-5">
				
				<tr>
					
					<td width="20%" class="text-left"> <p> <strong> Printed By: </strong> <span> {{ $pcv->user->firstname }} {{ $pcv->user->lastname }}</span></p></td>
					<td width="5%"></td>
					<td width="30%" class="text-left"> 
						<p> <strong> Printed Date & Time: </strong> <span> {{ \Carbon\Carbon::now()->toDateTimeString() }} </span> </p>
					</td>

				</tr>
				

			</table>

		</div>

	</div>

@endsection