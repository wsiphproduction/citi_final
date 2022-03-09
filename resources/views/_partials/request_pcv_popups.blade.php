<div class="modal fade" id="pcvReceived" tabindex="-1" role="dialog" 
	aria-labelledby="pcvReceived" aria-modal="true">

	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content tx-14">
			
			<div class="modal-header">
				<h6 class="modal-title" id="exampleModalLabel3">Received Information</h6>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="row">
					
					<div class="col-lg-12">
						<div class="form-group">
							<label for="remarks" class="d-block">Received Date</label>
							<input type="date" class="form-control" name="received_date" id="received_date" value="{{ date('Y-m-d') }}">
						</div>
					</div>

					<div class="col-lg-12">
						<div class="form-group">
							<label for="remarks" class="d-block">Received By</label>
							<input type="text" class="form-control" name="received_by" id="received_by">
						</div>
					</div>

				</div>
			</div>

			<div class="modal-footer">
				<button class="btn btn-brand-01 d-inline-block tx-13 tx-uppercase" id="btn_received">Received</button>
				<button type="button" class="btn btn-white tx-13 tx-uppercase" data-target="#pcvReceived" data-toggle="modal" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>

</div>


<div class="modal fade effect-scale" id="pcv_confirm_message" tabindex="-1" 
	role="dialog" aria-labelledby="pcv_confirm_message" 
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
				<p class="mb-0" id="pcv_message"></p>
			</div>

		</div>
	</div>

</div>