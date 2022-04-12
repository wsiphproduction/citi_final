<div class="col-lg-6 offset-3" id="DivIdToPrint">

	<h3 class="text-center"> PETTY CASH EXPENSES </h3>		
	<p class="text-center"> {{ $request['company'] }} </p>	
	<p class="text-center"> {{ $request['branch'] }} </p>
	<p class="text-center"> {{ $from }} - {{ $to }} </p>

	<table class="table">
	
		<thead>
			<tr>
				<td> NO </td>
				<td> Account Name </td>
				<td> Amount </td>
			</tr>
		</thead>

		<tbody>
			@php $total = 0; @endphp
			@forelse($pcv as $key => $account)					
				<tr>
					<td>{{ $key + 1 }}</td>
					<td>{{ $account->account_name }}</td>
					<td>{{ $account->amount }}</td>
				</tr>
				@php $total = $total + $account->amount; @endphp
			@empty
				<tr>
					<td colspan="3" class="text-center"> No Account Found </td>
				</tr>
			@endforelse

		</tbody>

		<tfoot>
			<tr>
				<td></td>
				<td> Total Amount </td>
				<td>{{ $total }}</td>
			</tr>
		</tfoot>


	</table>

	<br><br>


	<div class="row">

		<div class="col-lg-6">
			<p> Printed By: <span>{{ auth()->user()->username }}</span></p>
		</div>

		<div class="col-lg-6">
			<p> Printed Date & Time: <span>{{ \Carbon\Carbon::now()->format('Y-m-d h:i:s') }}</span></p>
		</div>

	</div>


</div>

<div class="col-md-12 text-center mg-t-50">
	
	<button class="btn btn-secondary"> Export to Excel </button>
	<button class="btn btn-primary" onclick='printDiv();'> Print </button>

</div>


<script type="text/javascript">
	
	function printDiv() 
	{

		var divToPrint=document.getElementById('DivIdToPrint');

		var newWin=window.open('','Print-Window');

		newWin.document.open();

		newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

		newWin.document.close();

		setTimeout(function(){newWin.close();},10);

	}
</script>



