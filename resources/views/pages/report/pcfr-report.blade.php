<style type="text/css">	
	table tr td { border-top: none !important; }
</style>

<div id="DivIdToPrint">
<table class="table" style="margin-bottom: 70px;">
	
	<tbody>
		<tr>
			<td colspan="6">
				<h3 class="text-center">
					
					@if(\Str::contains($request_type, 'summary'))
						PCFR Summary
					@else
						PCFR Detailed
					@endif

				</h3>
			</td>
		</tr>
		<tr>
			<td class="text-center" colspan="6">
				{{ $request['company'] }}
			</td>
		</tr>
		<tr>
			<td class="text-center" colspan="6">
				{{ $request['branch'] }}
			</td>
		</tr>
		<tr>
			<td class="text-center" colspan="6">
				{{ $from }} - {{ $to }}
			</td>
		</tr>
	</tbody>
	
	<tbody>
		<tr>
			<td> PCFR No </td>
			<td> Branch / Company </td>
			<td> Description </td>
			<td> Account </td>
			<td> Amount </td>
			<td> Status </td>
		</tr>
	</tbody>

	<tbody>
		@php $total = 0; @endphp
		@if($pcfr)

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

			
		@else
			<tr>
				<td colspan="6" class="text-center"> No Account Found </td>
			</tr>
		@endif

	</tbody>

	<tbody>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td> Total Amount </td>
			<td>{{ $total }}</td>
			<td></td>
		</tr>
	</tbody>

@if($pcfr)
@if(\Str::contains($request_type, 'detailed'))
	
	<tbody>
					
		<tr>
			<td width="25%"> Temporary Slip: </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->total_temp_slip }}  </td>
			<td width="10%"></td>
			<td width="25%"> Total Replenishment: </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->total_replenishment }}  </td>
		</tr>
		<tr>
			<td width="25%">  ATM Balance:  </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->atm_balance }}  </td>
			<td width="10%"></td>
			<td width="25%"> Pending Replenishment: </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->total_temp_slip }}  </td>
		</tr>
		<tr>
			<td width="25%"> Cash On Hand: </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->cash_on_hand }}  </td>
			<td width="10%"></td>
			<td width="25%"> Unreplenished: </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->total_unreplenished }}  </td>
			
		</tr>
		<tr>
			<td width="25%"> PCF Accounted For: </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->total_accounted }}  </td>
			<td width="10%"></td>
			<td width="25%"> Unapproved PCVs: </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->total_unapproved_pcv }}  </td>
		</tr>				
		<tr>
			<td width="25%"> PCF Accountability: </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->pcf_accountability }}  </td>
			<td width="10%"></td>
			<td width="25%"> Returned PCVs:  </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->total_returned_pcv }}  </td>
		</tr>
		<tr>
			<td width="25%"> Overage/Shortage: </td>
			<td style="border-bottom: 1px solid;" class="text-right" width="20%"> {{ $pcfr->pcf_diff }}  </td>					
		</tr>

	</tbody>
			

@endif
@endif

</table>

</div>

<div class="col-md-12 text-center mg-t-50">
	
	<button class="btn btn-secondary" id="dataContentExportExl"> Export to Excel </button>
	<button class="btn btn-primary" id="printReport"> Print </button>

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