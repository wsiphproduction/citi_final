<div class="modal fade effect-scale" id="pcfr_confirm_message" tabindex="-1" 
	role="dialog" aria-labelledby="pcfr_confirm_message" 
	aria-modal="true">

	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content tx-14">
			
			<div class="modal-header">
				<h6 class="modal-title" id="exampleModalLabel3">Confirmation Message</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body">
				<p class="mb-0" id="pcfr_message"></p>
			</div>

			<div class="modal-footer" id="confirm-footer">
				<button type="button" class="btn btn-brand-01 tx-13 tx-uppercase wd-100" data-target="#pcfrInputApprovalCode" data-toggle="modal" data-dismiss="modal" id="btn_ok">OK</button>
				<button type="button" class="btn btn-white tx-13 tx-uppercase wd-100" data-dismiss="modal">Cancel</button>
			</div>

		</div>
	</div>

</div>

<div class="modal fade" id="pcfrInputApprovalCode" tabindex="-1" role="dialog" 
	aria-labelledby="pcfrInputApprovalCode" aria-modal="true">

	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content tx-14">
			
			<div class="modal-header">
				<h6 class="modal-title" id="exampleModalLabel3">Input Approval Code</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="row">
					
					<div class="col-lg-12">
						<div class="form-group">
							<label for="approval-code" class="d-block">Approval Code</label>
							<input type="text" class="form-control" id="approval_code">
							<input type="hidden" id="pcfr_id" value="{{ $pcfr->id }}">
						</div>
					</div>

					<div class="col-lg-12">
						<div class="form-group">
							<label for="approver-name" class="d-block">Approver's Name</label>
							<select class="custom-select" id="approver_name">
								<option selected="">--Select--</option>
								@foreach($area_manager as $manager) 
									<option value="{{ $manager->firstname }} {{ $manager->lastname }}"> {{ $manager->firstname }} {{ $manager->lastname }} </option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-lg-12">
						<div class="form-group">
							<label for="remarks" class="d-block">Remarks</label>
							<textarea id="remarks" name="remarks" class="form-control" rows="3"></textarea>
						</div>
					</div>

				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-brand-01 d-inline-block tx-13 tx-uppercase" id="btn_approval_code">Approve</button>
				<button type="button" class="btn btn-white tx-13 tx-uppercase" data-target="#pcfrInputApprovalCode" data-toggle="modal" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>

</div>


<div class="modal fade" id="pcfrDisapprove" tabindex="-1" role="dialog" 
	aria-labelledby="pcfrDisapprove" aria-modal="true">

	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content tx-14">
			
			<div class="modal-header">
				<h6 class="modal-title" id="exampleModalLabel3">Input Disapproval Remarks</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="row">
					
					<div class="col-lg-12">
						<div class="form-group">
							<label for="remarks" class="d-block">Remarks</label>
							<textarea id="disapprove-remarks" class="form-control" rows="3"></textarea>
						</div>
					</div>

				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-brand-01 d-inline-block tx-13 tx-uppercase" id="btn_disapproval">Disapprove</button>
				<button type="button" class="btn btn-white tx-13 tx-uppercase" data-target="#pcfrDisapprove" data-toggle="modal" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>

</div>