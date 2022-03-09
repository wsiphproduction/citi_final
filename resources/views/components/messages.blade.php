<div class="col-lg-12">
    <div class="row">

		@if($message = Session::get('success'))
			<div class="alert alert-success wd-100p fade show" role="alert">
				<span class="tx-12 tx-lg-16"><strong>{{ $message }}</strong></span>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                <span aria-hidden="true">×</span>
	            </button>
	        </div>
		@endif

		@if($message = Session::get('info'))
			<div class="alert alert-info wd-100p fade show" role="alert">
				<span class="tx-12 tx-lg-16"><strong>{{ $message }}</strong></span>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                <span aria-hidden="true">×</span>
	            </button>
	        </div>
		@endif

		@if($message = Session::get('warning'))
			<div class="alert alert-warning wd-100p fade show" role="alert">
				<span class="tx-12 tx-lg-16"><strong>{{ $message }}</strong></span>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                <span aria-hidden="true">×</span>
	            </button>
	        </div>
		@endif

		@if($message = Session::get('danger'))
			<div class="alert alert-danger wd-100p fade show" role="alert">
				<span class="tx-12 tx-lg-16"><strong>{{ $message }}</strong></span>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                <span aria-hidden="true">×</span>
	            </button>
	        </div>
		@endif

		@if($errors->any())
			<div class="alert alert-danger wd-100p fade show" role="alert">
				<span class="tx-12 tx-lg-16"><strong>{{ $errors->first() }}</strong></span>
	            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                <span aria-hidden="true">×</span>
	            </button>
	        </div>
		@endif

	</div>
</div>