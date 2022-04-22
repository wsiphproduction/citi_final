<div class="col-lg-6 offset-3">

<table class="table" id="DivIdToPrint">

	
		<tbody style="margin-bottom: 20px;">

			<tr style="border: none;">
				<td style="border: none;" colspan="3"><h3 class="text-center"> PETTY CASH EXPENSES </h3></td>
			</tr>
			<tr style="border: none;">
				<td style="border: none; padding: 0; text-align: center;" colspan="3">{{ $request['company'] }}</td>
			</tr>
			<tr style="border: none;">
				<td style="border: none; padding: 0; text-align: center;" colspan="3">{{ $request['branch'] }}</td>
			</tr>
			<tr style="border: none;">
				<td style="border: none; padding: 0 0 20px 0; text-align: center;" colspan="3">{{ $from }} - {{ $to }}</td>
			</tr>

		</tbody>
	
	
		<tbody>
			<tr>
				<td> NO </td>
				<td> Account Name </td>
				<td> Amount </td>
			</tr>
		</tbody>

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

		<tbody>
			<tr>
				<td></td>
				<td> Total Amount </td>
				<td>{{ $total }}</td>
			</tr>
		
		</tbody>
		
		<tbody>
			<tr style="margin-top: 30px;">
				<td>
					<p> Printed By: <span>{{ auth()->user()->firstname }}</span> <span>{{ auth()->user()->lastname }}</span></p>
				</td>
				<td></td>
				<td>
					<p> Printed Date & Time: <span>{{ \Carbon\Carbon::now()->format('Y-m-d h:i:s') }}</span></p>
				</td>
			</tr>
		</tbody>
		

</table>

</div>

<div class="col-md-12 text-center mg-t-50">
	
	<button type="button" class="btn btn-secondary" id="dataContentExportExl"> Export to Excel </button>
	<button type="button" class="btn btn-primary" id="printReport"> Print </button>

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

	$(document).on('click', '#printReport', function() {
		printDiv();
	});

	$(document).on('click', '#dataContentExportExl', function(){
		html_table_to_excel('xlsx');
	});

	function html_table_to_excel(type)
    {
        var data = document.getElementById('DivIdToPrint');

        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});

        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });

        XLSX.writeFile(file, 'file.' + type);
    }

</script>



