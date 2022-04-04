<h3 class="text-center">
	
	@if(\Str::contains($request_type, 'summary'))
		PCFR Summary
	@else
		PCFR Detailed
	@endif

</h3>

<p class="text-center"> {{ $request['company'] }} </p>	
<p class="text-center"> {{ $request['branch'] }} </p>


<table class="table">
	
		<thead>
			<tr>
				<td> PCFR No </td>
				<td> Branch / Company </td>
				<td> Description </td>
				<td> Account </td>
				<td> Amount </td>
				<td> Status </td>
			</tr>
		</thead>

		<tbody>
			@php $total = 0; @endphp
			@forelse($pcfr as $pcfr)					

				@foreach($pcfr->pcv as $pcv)

					<tr>
						<td> {{ $pcfr->pcfr_no }} </td>
						<td> {{ $pcfr->branch }} </td>
						<td> {{ $pcv->description }} </td>
						<td> {{ $pcv->account_name }} </td>
						<td> {{ $pcv->amount }} </td>
						<td> {{ $pcfr->status }} </td>
					</tr>

					@php $total = $total + $pcv->amount; @endphp
				@endforeach

				
			@empty
				<tr>
					<td colspan="6" class="text-center"> No Account Found </td>
				</tr>
			@endforelse

		</tbody>

		<tfoot>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td> Total Amount </td>
				<td>{{ $total }}</td>
				<td></td>
			</tr>
		</tfoot>


	</table>



@if(\Str::contains($request_type, 'summary'))
	
	<div class="col-lg-6 offset-3 mg-t-50">

		<div class="row">
			
			<div class="col-lg-6">
				<p> Temporary Slip: <span>{{ $pcfr->total_temp_slip }} </span></p>
				<p> ATM Balance: <span>{{ $pcfr->atm_balance }} </span></p>
				<p> Cash On Hand: <span>{{ $pcfr->cash_on_hand }} </span></p>
				<p> PCF Accounted For: <span>{{ $pcfr->total_accounted }} </span></p>
				<p> PCF Accountability: <span>{{ $pcfr->pcf_accountability }} </span></p>
				<p> Overage/Shortage: <span>{{ $pcfr->pcf_diff }} </span></p>
			</div>

			<div class="col-lg-6">
				<p> Total Replenishment: <span>{{ $pcfr->total_replenishment }} </span></p>
				<p> Pending Replenishment: <span>{{ $pcfr->total_temp_slip }} </span></p>
				<p> Unreplenished: <span>{{ $pcfr->total_inreplenished }} </span></p>
				<p> Unapproved PCVs: <span>{{ $pcfr->total_unapproved_pcv }} </span></p>
				<p> Returned PCVs: <span>{{ $pcfr->total_returned_pcv }} </span></p>

			</div>

		</div>

	</div>
	

@endif