@extends('layouts.app')

@section('pagecss')

    <link href="{{ asset('lib/prismjs/themes/prism-vs.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">

@endsection

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Request</a></li>
					<li class="breadcrumb-item active">Reports</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Reports</h4>
		</div>

	</div>	

	<div class="row">

        <div class="col-lg-12">

            <div class="row">

				<div class="col-lg-4">
					<div class="form-group row">
						<label for="slip-no" class="col-lg-5 col-form-label">Report Title</label>
						<div class="col-lg-7">
							<select class="form-control custom-select" name="name" id="name">
								<option value="petty cash expense">Petty Cash Expense</option>
								<option value="pcfr detailed">PCFR (Detailed)</option>
								<option value="pcfr summary">PCFR (Summary)</option>
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-8"></div>

				<div class="col-lg-12">
					<hr class="mg-t-10 mg-b-30">
				</div>

				<div class="col-lg-4">
					<div class="form-group row">
						<label for="slip-no" class="col-lg-5 col-form-label">Company</label>
						<div class="col-lg-7">
							<select class="form-control custom-select search-input" name="company" id="company"
								@if(auth()->user()->position == 'administrator' || auth()->user()->position == 'Administrator' || 
								auth()->user()->position == 'audit' || auth()->user()->position == 'Audit') multiple @endif>
								<option value="">Select</option>
								@foreach( $company as $key => $comp )
									@if(!is_null(auth()->user()->assign_to))
										<option value="{{ $comp }}" @if($key == auth()->user()->assign_to) selected @endif> {{ $comp }}</option>
									@else
										<option value="{{ $comp }}"> {{ $comp }}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="form-group row">
						<label for="slip-no" class="col-lg-5 col-form-label">Branch</label>
						<div class="col-lg-7">
							<select class="form-control custom-select search-input" name="company" id="branch"
								@if(auth()->user()->position == 'administrator' || auth()->user()->position == 'Administrator' || 
								auth()->user()->position == 'audit' || auth()->user()->position == 'Audit') multiple @endif>
								<option value="">Select</option>
								@foreach( $branch as $key => $b )
									@if(!is_null(auth()->user()->assign_to))
										<option value="{{ $b }}" @if($key == auth()->user()->assign_to) selected @endif> {{ $b }}</option>
									@else
										<option value="{{ $b }}"> {{ $b }}</option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-4" id="for-detailed"></div>

				<div class="col-lg-4">
					<div class="form-group row">
						<label for="slip-no" class="col-lg-5 col-form-label">Date From</label>
						<div class="col-lg-7">
							<input type="date" id="date_from" class="form-control search-input" value="{{ date('Y-m-d') }}">
						</div>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="form-group row">
						<label for="slip-no" class="col-lg-5 col-form-label">Date To</label>
						<div class="col-lg-7">
							<input type="date" id="date_to" class="form-control search-input" value="{{ date('Y-m-d') }}">
						</div>
					</div>
				</div>

				<div class="col-lg-4 text-right">
					<button type="button" class="btn btn-success mr-lg-1 mb-2 mb-lg-0 d-block d-lg-inline wd-100p wd-lg-150 btn-report">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
						Generate
					</button>
				</div>

			</div>

        </div>

	</div>

	<div class="col-lg-12">
      	<hr class="mg-t-10 mg-b-30">
    </div>

	<div class="row mg-t-50">
		
		<div class="col-lg-12">
			
			<div id="report">
				


			</div>

		</div>

	</div>

@endsection


@section('pagejs')
	
	<script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>	
	<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>    
    
    <script>
			
    	$(document).on('change', '#name', function(){
    		$('#for-detailed').empty();
    		if($(this).val() != 'petty cash expense') {

    			_html  = '<div class="form-group row">';
    			_html += '<label for="slip-no" class="col-lg-5 col-form-label">PCFR</label>';
    			_html += '<div class="col-lg-7">';
    			_html += '<select class="form-control custom-select" name="pcfr_no" id="pcfr_no">';
    			_html += '<option value="saved">Select</option>';
    			_html += '</select>';
    			_html += '</div></div>'

    			$('#for-detailed').append(_html);

    		} 

    	});

    	if('{!! auth()->user()->position !!}' == 'Administrator' || '{!! auth()->user()->position !!}' == 'administrator' || '{!! auth()->user()->position !!}' == 'audit' || '{!! auth()->user()->position !!}' == 'Audit') {

    		$("#company").select2({
			    tags: true,
			    tokenSeparators: [',']
			});

			$("#branch").select2({
			    tags: true,
			    tokenSeparators: [',']
			});

    	}


    	$(document).on('click', '.btn-report', function() {

    		let _name = $('#name').val();
    		let _company = $('#company').val();
    		let _branch = $('#branch').val();
    		let _from = $('#date_from').val();
    		let _to = $('#date_to').val();
    		let _url = '{!! route("reports.search") !!}?name='+_name+'&company='+_company+'&branch='+_branch+'&from='+_from+'&to='+_to;

    		if($('#status').length) {
    			_url = _url+'&status='+$('#status').val();
    		}

    		if($('#name').val() == 'petty cash expense') {
	    		
	    		$('#report').empty();

	    		$.ajax({

					url 	: _url,
					method 	: 'GET' ,
					success : function(res) {

						console.log(res);
						$('#report').append(res);

					}

				});

	    	} else {

	    		_url = '{!! route("reports.search1") !!}?name='+_name+'&company='+_company+'&branch='+_branch+'&from='+_from+'&to='+_to+'&pcfr_no='+$('#pcfr_no').val();

	    		$('#report').empty();
	    		
	    		$.ajax({

					url 	: _url,
					method 	: 'GET' ,
					success : function(res) {

						console.log(res);
						$('#report').append(res);

					}

				});

	    	}

    	});

    	$(document).on('change', '.search-input', function() {

    		let _name = $('#name').val();
    		let _company = $('#company').val();
    		let _branch = $('#branch').val();
    		let _from = $('#date_from').val();
    		let _to = $('#date_to').val();
    		let _url = '{!! route("reports.search") !!}?name='+_name+'&company='+_company+'&branch='+_branch+'&from='+_from+'&to='+_to;

    		if($('#name').val() != 'petty cash expense') {
	    		
	    		$.ajax({

					url 	: _url,
					method 	: 'GET' ,
					success : function(res) {

						if(res.length>0) {
							console.log('yes');

							$('#pcfr_no').empty();

							var _html = '';
								_html += '<option value="">Select</option>';

							$.each(res, function(i, o) {
								console.log(o.pcfr_no);
								_html += '<option value="'+o.pcfr_no+'">'+o.pcfr_no+'</option>';

							});
							console.log(_html);
							$('#pcfr_no').append(_html);

						}

					}

				});

	    	}

    	});


    </script>

@endsection