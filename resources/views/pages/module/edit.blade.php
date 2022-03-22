@extends('layouts.app')

@section('pagecss')
	<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('modules.index') }}">Modules</a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Edit Module Form</h4>
		</div>

	</div>	

	<div class="row">
		
		<form method="POST" action="{{ route('modules.update', $module->id) }}" class="col-lg-12">
	        @csrf
	        @method('PUT')
	        
	        <div class="row">
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Name</label>
						<div class="col-lg-7">
							<input type="text" name="name" class="form-control" value="{{ $module->name }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Actions ( please specify action if the action is not found on the options. )</label>
						<div class="col-lg-7">
							<select class="form-control" name="actions[]" id="actions" multiple>
								@foreach( \App\Helpers\Helper::basic_actions() as $action )
									<option @if(in_array($action, $module->actions)) selected @endif value="{{ $action }}" > {{ ucfirst($action) }} </option>
								@endforeach
								@foreach( $module->actions as $action )
									@if(!in_array($action, \App\Helpers\Helper::basic_actions()))
										<option selected value="{{ $action }}"> {{ ucfirst($action) }} </option>
									@endif
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6 mg-t-20 text-right">
					<button type="submit" class="btn btn-brand-01 d-block d-lg-inline wd-100p wd-lg-150">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> 
						Update
					</button>
				</div>
			</div>

		</form>

    </div>
	
@endsection

@section('pagejs')
	<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
    	$("#actions").select2({
		    tags: true,
		    tokenSeparators: [',']
		})
    </script>
@endsection