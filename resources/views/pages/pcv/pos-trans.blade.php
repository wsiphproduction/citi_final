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

	</style>

@endsection

@section('content')
	
	<div class="row">

        <div class="col-lg-12">
            
            <h3> POS SALES TRANSACTION </h3>

        </div>

        <div class="col-lg-12 mg-t-50">

        	<div class="datatable-responsive">

				<table class="col-lg-12">
					
					<tr>
						
						<td width="15%"> <p> <strong>Customer</strong>: </p></td>
						<td width="30%" style="border-bottom: 1px solid #000;"> <p> {{ $transactions[0]->customer_name }} </p></td>
						<td width="10%"></td>
						<td width="15%"> <p> <strong>Store Name</strong>: </p></td>
						<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp;{{ $transactions[0]->store_id }} </td>
						
					</tr>

					<tr>
						
						<td width="15%"> <p> <strong>Cashier</strong>: </p></td>
						<td width="30%" style="border-bottom: 1px solid #000;"> <p> {{ $transactions[0]->cashier }} </p></td>
						<td width="10%"></td>
						<td width="15%"> <p> <strong>Transaction Date & Time</strong>: </p></td>
						<td width="30%" style="border-bottom: 1px solid #000;"> &nbsp;{{ $transactions[0]->trx_date }} </td>

					</tr>

					<tr>
						
						<td width="15%"> <p> <strong>Terminal</strong>: </p></td>
						<td width="30%" style="border-bottom: 1px solid #000;"> <p> {{ $transactions[0]->terminal_name }} </p></td>
						<td width="10%"></td>
						<td width="15%"> <p> <strong>Status</strong>: </p></td>

					</tr>

					<tr>

						<td width="15%"> <p> <strong>Sales Invoice</strong>: </p></td>
						<td width="30%" style="border-bottom: 1px solid #000;"> <p> {{ $transactions[0]->sales_invoice_receipt_no }} </p></td>

					</tr>

					<tr>

						<td width="15%"> <p> <strong>Universal TRX No</strong>: </p></td>
						<td width="30%" style="border-bottom: 1px solid #000;"> <p> {{ $transactions[0]->universal_trx_id }} </p></td>
						
					</tr>

				</table>

			</div>

		</div>

		<div class="col-lg-12 mg-t-50">
			
			<div class="datatable-responsive">

				<table class="col-lg-12">
					
					<thead>
						<th> LINE NO </th>
						<th> BARCODE </th>
						<th> DESCRIPTION </th>
						<th> ORIGINAL QTY </th>
						<th> PRICE </th>
						<th> TOTAL DISCOUNT </th>
						<th> TOTAL PRICE </th>
						<th> SALE PERSON </th>
					</thead>

					<tbody>
							
						@foreach( $transactions as $key => $transaction )

							<tr>
								<td> {{ $key + 1 }} </td>
								<td> {{ $transaction->barcode }} </td>
								<td> {{ $transaction->description }} </td>
								<td> {{ $transaction->original_qty }} </td>
								<td> {{ $transaction->original_price }} </td>
								<td> {{ $transaction->total_discount }} </td>
								<td> {{ $transaction->total_price }} </td>
								<td> {{ $transaction->sale_person }} </td>
							</tr>

						@endforeach

					</tbody>

				</table>

			</div>

		</div>


	</div>

@endsection
