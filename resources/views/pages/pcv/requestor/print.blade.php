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
					<td width="30%" style="border-bottom: 1px solid #000;"> <p> {{ $pcv->ts_no }} </p></td>
					<td width="20%"></td>
					<td width="10%"> <p> <strong>Change</strong>: </p></td>
					<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp;{{ $pcv->change }} </td>
					
				</tr>

			</table>

			<hr style="width: 100%; border: 1px dashed #000; margin: 50px 30px 0;">

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
				

			</table>

			<div style="border: 1px solid #000; width: 100%; display: block; margin-top: 50px;">

				<table class="col-lg-12 mt-5" style="margin-top: 0 !important;">

					<thead>
						<tr>
							@foreach($pcv->account_transaction['details'][0] as $key => $tbl_headers)
								<td> <p>{{ ucfirst(\Str::replace("_", " ", $key)) }}</p> </td>
							@endforeach
						</tr>
					</thead>

					<tbody>
						<tr>
							@foreach( $pcv->account_transaction->details as $detail ) 

								@foreach($detail as $d)
									<td><p>{{ $d}}</p></td>
								@endforeach
							@endforeach
						</tr>
					</tbody>

				</table>

			</div>

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
					
					<td width="20%" class="text-left"> <p> <strong> Printed By: </strong> <span> {{ $pcv->user->username }}</span></p></td>
					<td width="5%"></td>
					<td width="30%" class="text-left"> 
						<p> <strong> Printed Date & Time: </strong> <span> {{ \Carbon\Carbon::now()->toDateTimeString() }} </span> </p>
					</td>

				</tr>
				

			</table>

		</div>

	</div>

@endsection