@extends('layouts.app2')

@section('pagecss')

	<style type="text/css">
		p {
			font-size: 20px;
			margin-bottom: 0 !important;
			padding: 20px;
		}
	</style>

@endsection

@section('content')
	
	<div class="col-lg-12 text-center">	

        <img src="{{ asset('img/logo (1).png') }}" alt="Citihardware logo" width="50" style="display: inline-block;">
    
		<h3 style="display: inline-block;"> Pettey Cash Fund Replenishment </h3>
		<h5> Temporary Slip </h5>
		<h6> {{ ucfirst($ts->status) }} </h6>

	</div>	

	<div style="width: 90%; display: block; margin: 0 auto; margin-top: 30px;">
		
		<div class="row">

			<table class="col-lg-12">
				
				<tr>
					
					<td width="20%"> <p> <strong>Temporary Slip No</strong>: </p></td>
					<td width="40%" style="border-bottom: 1px solid #000;"> <p> {{ $ts->ts_no }} </p></td>
					<td width="10%"> <p> <strong>Date</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> <p> {{ $ts->created_at->toFormattedDateString() }} </p></td>

				</tr>

				<tr>
					
					<td> <p> <strong>Account Name</strong>: </p></td>
					<td style="border-bottom: 1px solid #000;"> <p> {{ $ts->account_name }} </p></td>
					<td> <p> <strong>Description</strong>: </p></td>
					<td style="border-bottom: 1px solid #000;"> <p> {{ $ts->description }} </p></td>
					
				</tr>

				<tr>
					
					<td> <p> <strong>Amount</strong>: </p></td>
					<td style="border-bottom: 1px solid #000;"> <p> {{ $ts->amount }} </p></td>

				</tr>				

			</table>

			<table class="col-lg-12 mt-5">
				
				<tr>
					
					<td width="30%" class="text-center"> <p> {{ $ts->user->username }} </p></td>
					<td width="5%"></td>
					<td width="30%" class="text-center"> <p> {{ $ts->approved_by }} </p></td>
					<td width="5%"></td>
					<td width="30%" class="text-center"> <p> {{ $ts->received_by }} </p></td>
					

				</tr>
				<tr>
					
					<td width="30%" style="border-bottom: 1px solid #000;"></td>
					<td width="5%"></td>
					<td width="30%" style="border-bottom: 1px solid #000;"></td>
					<td width="5%"></td>
					<td width="30%" style="border-bottom: 1px solid #000;"></td>

				</tr>
				<tr>
					
					<td width="30%" class="text-center"> <p><strong> Prepared By </strong></p></td>
					<td width="5%"></td>
					<td width="30%" class="text-center"> <p><strong> Approved By </strong></p></td>
					<td width="5%"></td>
					<td width="30%" class="text-center"> <p><strong> Received By </strong></p></td>

				</tr>

			</table>

			<table class="col-lg-12 mt-5">
				
				<tr>
					
					<td width="20%" class="text-left"> <p> <strong> Printed By: </strong> <span> {{ $ts->user->username }}</span></p></td>
					<td width="5%"></td>
					<td width="30%" class="text-left"> 
						<p> <strong> Printed Date & Time: </strong> <span> {{ \Carbon\Carbon::now()->toDateTimeString() }} </span> </p>
					</td>

				</tr>
				

			</table>

		</div>

	</div>


	<hr style="margin: 50px 0; border: #000 dashed 1px !important; ">


	<div class="col-lg-12 text-center">	

        <img src="{{ asset('img/logo (1).png') }}" alt="Citihardware logo" width="50" style="display: inline-block;">
    
		<h3 style="display: inline-block;"> Pettey Cash Fund Replenishment </h3>
		<h5> Temporary Slip </h5>
		<h6> {{ ucfirst($ts->status) }} </h6>

	</div>	

	<div style="width: 90%; display: block; margin: 0 auto; margin-top: 30px;">
		
		<div class="row">

			<table class="col-lg-12">
				
				<tr>
					
					<td width="20%"> <p> <strong>Temporary Slip No</strong>: </p></td>
					<td width="40%" style="border-bottom: 1px solid #000;"> <p> {{ $ts->ts_no }} </p></td>
					<td width="10%"> <p> <strong>Date</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> <p> {{ $ts->created_at->toFormattedDateString() }} </p></td>

				</tr>

				<tr>
					
					<td> <p> <strong>Account Name</strong>: </p></td>
					<td style="border-bottom: 1px solid #000;"> <p> {{ $ts->account_name }} </p></td>
					<td> <p> <strong>Description</strong>: </p></td>
					<td style="border-bottom: 1px solid #000;"> <p> {{ $ts->description }} </p></td>
					
				</tr>

				<tr>
					
					<td> <p> <strong>Amount</strong>: </p></td>
					<td style="border-bottom: 1px solid #000;"> <p> {{ $ts->amount }} </p></td>

				</tr>			

			</table>

			<table class="col-lg-12 mt-5">
				
				<tr>
					
					<td width="30%" class="text-center"> <p> {{ $ts->user->username }} </p></td>
					<td width="5%"></td>
					<td width="30%" class="text-center"> <p> {{ $ts->approved_by }} </p></td>
					<td width="5%"></td>
					<td width="30%" class="text-center"> <p> {{ $ts->received_by }} </p></td>
					

				</tr>
				<tr>
					
					<td width="30%" style="border-bottom: 1px solid #000;"></td>
					<td width="5%"></td>
					<td width="30%" style="border-bottom: 1px solid #000;"></td>
					<td width="5%"></td>
					<td width="30%" style="border-bottom: 1px solid #000;"></td>

				</tr>
				<tr>
					
					<td width="30%" class="text-center"> <p><strong> Prepared By </strong></p></td>
					<td width="5%"></td>
					<td width="30%" class="text-center"> <p><strong> Approved By </strong></p></td>
					<td width="5%"></td>
					<td width="30%" class="text-center"> <p><strong> Received By </strong></p></td>

				</tr>

			</table>

			<table class="col-lg-12 mt-5">
				
				<tr>
					
					<td width="20%" class="text-left"> <p> <strong> Printed By: </strong> <span> {{ $ts->user->username }}</span></p></td>
					<td width="5%"></td>
					<td width="30%" class="text-left"> 
						<p> <strong> Printed Date & Time: </strong> <span> {{ \Carbon\Carbon::now()->toDateTimeString() }} </span> </p>
					</td>

				</tr>
				

			</table>

		</div>
		
	</div>

@endsection