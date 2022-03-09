@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item"><a href="#">Petty Cash Fund Replenishment</a></li>
					<li class="breadcrumb-item active" aria-current="page">Create</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Petty Cash Fund Replenishment Form</h4>
		</div>

	</div>	

	<div class="row">
		
		<div class="col-lg-6">
            <div class="form-group row">
                <label for="pcfr-no" class="col-lg-5 col-form-label">PCFR No.</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="pcfr-no" name="pcfr-no" value="PCFR-13013-20210101-1">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="branch" class="col-lg-5 col-form-label">Branch</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="branch" name="branch" value="Store A">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="requested-by" class="col-lg-5 col-form-label">Requested By</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="requested-by" name="requested-by" value="Sample Requestor">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="vendor" class="col-lg-5 col-form-label">Vendor</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="vendor" name="vendor" value="Sample Vendor">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="doc-date" class="col-lg-5 col-form-label">Doc Date</label>
                <div class="col-lg-7">
                  	<input type="date" class="form-control" id="doc-date" name="doc-date" value="XX/XX/XXXX">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="doc-type" class="col-lg-5 col-form-label">Doc Type</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="doc-type" name="doc-type" value="Invoice">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="batch-id" class="col-lg-5 col-form-label">Batch ID</label>
                <div class="col-lg-7">
                  	<input type="text" class="form-control" id="batch-id" name="batch-id" value="PCF-04/10/2021-13013-1">
                </div>
            </div>
        </div>

        <div class="col-lg-6 mg-b-20">
            <div data-label="Period" class="df-example">
                <div class="form-group row">
                  	<label for="period-date-from" class="col-lg-5 col-form-label">Period Date From</label>
                  	<div class="col-lg-7">
                    	<input type="text" class="form-control" id="periodDateFrom" name="period-date-from" placeholder="From">
                  	</div>
                </div>
                <div class="form-group row mb-0">
                  	<label for="period-date-to" class="col-lg-5 col-form-label">Period Date To</label>
                  	<div class="col-lg-7">
                    	<input type="text" class="form-control" id="periodDateTo" name="period-date-to" placeholder="To">
                  	</div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
          	<hr class="mg-t-10 mg-b-30">
        </div>

        <div class="col-lg-12">
            <div class="dataTables_responsive">
                <table class="table dataTable no-footer">
                  	<thead>
                      	<tr role="row">
	                        <th class="wd-20p sorting_1 tx-uppercase">PCV No.</th>
	                        <th class="wd-20p tx-uppercase">Description</th>
	                        <th class="wd-20p tx-uppercase">Account</th>
	                        <th class="wd-20p tx-uppercase">Store</th>
	                        <th class="wd-20p tx-uppercase">Amount</th>
	                    </tr>
                  	</thead>
                  	<tbody>
                    	
                  	</tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-12">
          	<hr class="mg-t-30 mg-b-30">
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="temporary-slip" class="col-lg-5 col-form-label">Temporary Slip</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" id="temporary-slip" name="temporary-slip" value="0.00" disabled>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="total-replenishment" class="col-lg-5 col-form-label">Total Replenishment</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" id="total-replenishment" name="total-replenishment" value="00000.00" disabled>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="atm-balance" class="col-lg-5 col-form-label">ATM Balance</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control" id="atm-balance" name="atm-balance">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="pending-replenishment" class="col-lg-5 col-form-label">Pending Replenishment</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" id="pending-replenishment" name="pending-replenishment" value="0.00" disabled>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="cash-on-hand" class="col-lg-5 col-form-label">Cash on Hand</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control" id="cash-on-hand" name="cash-on-hand">
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="unreplenished" class="col-lg-5 col-form-label">Unreplenished</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" id="unreplenished" name="unreplenished" value="0.00" disabled>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
           	<div class="form-group row">
                <label for="pcf-accounted-for" class="col-lg-5 col-form-label">PCF Accounted For</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" id="pcf-accounted-for" name="pcf-accounted-for" value="0.00" disabled>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
          	<div class="form-group row">
	            <label for="unapproved-pcvs" class="col-lg-5 col-form-label">Unapproved PCVs</label>
	            <div class="col-lg-7">
	              	<input type="number" class="form-control bd-0 bd-bottom text-right" id="unapproved-pcvs" name="unapproved-pcvs" value="0.00" disabled>
	            </div>
          	</div>
        </div>

        <div class="col-lg-6">
	        <div class="form-group row">
	            <label for="pcf-accountability" class="col-lg-5 col-form-label">PCF Accountability</label>
	            <div class="col-lg-7">
	              	<input type="number" class="form-control bd-0 bd-bottom text-right" id="pcf-accountability" name="pcf-accountability" value="0.00" disabled>
	            </div>
	        </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group row">
                <label for="returned-pcvs" class="col-lg-5 col-form-label">Returned PCVs</label>
                <div class="col-lg-7">
                  	<input type="number" class="form-control bd-0 bd-bottom text-right" id="returned-pcvs" name="returned-pcvs" value="0.00" disabled>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
          	<div class="form-group row">
	            <label for="overage-shortage" class="col-lg-5 col-form-label">Overage/Shortage</label>
	            <div class="col-lg-7">
	              	<input type="number" class="form-control bd-0 bd-bottom text-right" id="overage-shortage" name="overage-shortage" value="0.00" disabled>
	            </div>
          	</div>
        </div>

        <div class="col-lg-6"></div>

        <div class="col-lg-12">
          	<hr class="mg-t-20 mg-b-40">
        </div>

        <div class="col-lg-12">

          	<div data-label="Attachment" class="df-example">

	            <button type="button" class="btn btn-brand-01 d-inline wd-150 tx-13 mg-t-20">
	              <i data-feather="plus"></i> Add
	            </button>

            <div class="attachment-wrapper mg-t-20">
	            <div class="pd-15 pt-4 border mg-b-20">
	                <div class="row row-xs">
	                  	
	                  	<div class="col-lg-3">
	                    	<div class="form-group">
		                      	<label for="attachment-type" class="d-block tx-14">Attachment Type</label>
		                      	<select class="custom-select" id="attachment-type" name="attachment-type">
			                        <option selected>--Select--</option>
			                        <option value="ATM Slip">ATM Slip</option>
			                        <option value="Withdrawal Slip">Withdrawal Slip</option>
			                        <option value="Cash Count Sheet">Cash Count Sheet</option>
		                      	</select>
	                    	</div>
	                  	</div>
	                  
	                  	<div class="col-lg-3">
	                    	<div class="form-group">
		                      	<label class="d-block tx-14">Document</label>
		                      	<div class="custom-file">
		                        	<input type="file" class="custom-file-input" id="document">
		                        	<label class="custom-file-label" for="document">Choose file</label>
		                      	</div>
	                    	</div>
	                  	</div>

	                  	<div class="col-lg-3">
		                    <div class="form-group">
		                      	<label for="doc-ref-date" class="d-block tx-14">Doc. Ref Date</label>
		                      	<input type="date" class="form-control" id="doc-ref-date" name="doc-ref-date">
		                    </div>
	                  	</div>

	                  	<div class="col-lg-2">
		                    <div class="form-group">
		                      	<label for="doc-ref-no" class="d-block tx-14">Doc. Ref No.</label>
		                      	<input type="text" class="form-control" id="doc-ref-no" name="doc-ref-no">
		                    </div>
	                  	</div>

	                  	<div class="col-lg-1">
		                    <label class="d-block tx-14 tx-left tx-lg-right">Action</label>
		                    <nav class="nav table-options justify-content-start justify-content-lg-end mg-t-15">
		                      	<a class="nav-link p-0 pl-2" href="#" title="Remove">
		                        	<i data-feather="x"></i>
		                      	</a>
		                    </nav>
	                  	</div>

	                </div>
	            </div>

              	
            </div>

          </div>

        </div>

        <div class="col-lg-12 mg-t-30">
          	<button type="button" class="btn btn-white mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150">
            	<i class="mg-r-5" data-feather="save"></i> Save
          	</button>
          	<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150">
            	<i class="mg-r-5" data-feather="send"></i> Submit
          	</button>
        </div>

    </div>
	
@endsection
