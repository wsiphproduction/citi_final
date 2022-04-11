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
		<h5> PCFR (Detailed) </h5>
		<h6> {{ ucfirst($pcfr->status) }} </h6>

	</div>	

	<div style="width: 90%; display: block; margin: 0 auto; margin-top: 30px;">
		
		<div class="row">

			<table class="col-lg-12">
				
				<tr>
					
					<td width="15%"> <p> <strong>PCFR No</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->pcfr_no }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Branch</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp;{{ $pcfr->user->branch->name }} </td>
					
				</tr>

				<tr>
					
					<td width="15%"> <p> <strong>Requested By</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->user->firstname }} {{ $pcfr->user->lastname }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Vendor</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp;{{ $pcfr->vendor }} </td>
					
				</tr>

				<tr>
					
					<td width="15%"> <p> <strong>Doc Date</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->date_created }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Doc Type</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp;{{ $pcfr->doc_type }} </td>
					
				</tr>

				<tr>
					
					<td width="15%"> <p> <strong>Batch ID</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->batch_no }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Period</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp; {{ $pcfr->from }} - {{ $pcfr->to  }} </td>
					
				</tr>

			</table>

			<table class="col-lg-12 mt-5" style="margin-top: 100px !important;" id="transaction">

				<tr>
					<td><strong>PCV No</strong></td>
					<td><strong>Description</strong></td>
					<td><strong>Account</strong></td>
					<td><strong>Store</strong></td>
					<td><strong>Amount</strong></td>
                </tr>

                <tbody>
                   
                   	@foreach( $pcfr->pcv as $pcv )
                   	<tr>       
                        <td>{{ $pcv->pcv_no }}</td>
                        <td>{{ $pcv->description }}</td>
                        <td>{{ $pcv->account_name }}</td>
                        <td>{{ $pcv->user->branch->name }}</td>
                        <td>{{ $pcv->amount }}</td>                        
                    </tr>    	
                    @endforeach
                   
                </tbody>

                <tfoot>
                    <tr role="row">
                        <td></td>                                        
                        <td></td>                                                                                
                        <td></td>                                        
                        <td class="tx-bold align-middle">Total Amount</td>
                        <td>
                        	{{ $pcfr->pcv()->sum('amount') }}
                        </td>                                        
                    </tr>
                </tfoot>

			</table>


			<table class="col-lg-12 mt-5" style="margin-top: 50px;">
				
				<tr>
					
					<td width="15%"> <p> <strong>Temporary Slip</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->total_temp_slip }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Total Replenishment</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp;{{ $pcfr->total_replenishment }} </td>
					
				</tr>

				<tr>
					
					<td width="15%"> <p> <strong>ATM Balance</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->atm_balance }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Pending Replenishment</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp;{{ $pcfr->total_pending_replenishment	 }} </td>
					
				</tr>

				<tr>
					
					<td width="15%"> <p> <strong>Cash On Hand</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->cash_on_hand }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Unreplished</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp;{{ $pcfr->total_unreplenished }} </td>
					
				</tr>

				<tr>
					
					<td width="15%"> <p> <strong>PCF Accounted For</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->total_accounted }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Unapproved PCVs</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp; {{ $pcfr->total_unapproved_pcv }} </td>
					
				</tr>

				<tr>
					
					<td width="15%"> <p> <strong>PCF Accountability</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->pcf_accountability }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Returned PCVs</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp; {{ $pcfr->total_returned_pcv }} </td>
					
				</tr>

				<tr>
					
					<td width="15%"> <p> <strong>Overage / Shortage</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->pcf_diff }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Attachments</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> 
						<ul class="mg-t-20">
							@foreach($pcfr->attachments as $attachment)
								<li>{{ $attachment->attachment }}</li>
							@endforeach
						</ul>
					</td>

				</tr>

				<tr>
					
					<td width="15%"> <p> <strong>Approved By</strong>: </p></td>
					<td width="25%" style="border-bottom: 1px solid #000;"> <p> {{ $pcfr->pcf_accountability }} </p></td>
					<td width="15%"></td>
					<td width="15%"> <p> <strong>Approved Date & Time</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp; {{ $pcfr->total_returned_pcv }} </td>
					
				</tr>

			</table>


			<div style="margin-top: 150px;" class="col-lg-12">
				
				<table class="col-lg-12">
				
					<tr>
						
						<td width="15%"> <p> <strong>Printed By</strong>: </p></td>
						<td width="25%" style="border-bottom: 1px solid #000;"> {{ auth()->user()->firstname }} {{ auth()->user()->lastname }} </td>
						<td width="15%"></td>
						<td width="15%"> <p> <strong>Printed Date & Time</strong>: </p></td>
						<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp;{{ date('Y-m-d h:s:i') }} </td>
						
					</tr>

				</table>

			</div>


		</div>

	</div>

@endsection