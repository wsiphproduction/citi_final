@extends('layouts.app')

@section('content')
	
	<div class="d-flex flex-column flex-lg-row justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
	
		<div>
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb breadcrumb-style1 mg-b-10">
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="{{ route('charges.index') }}">Charges</a></li>
					<li class="breadcrumb-item active" aria-current="page">Edit</li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Edit Charge Form</h4>
		</div>

	</div>	

	<div class="row">
		
		<form method="POST" action="{{ route('charges.update', $charge->id) }}" class="col-lg-12">
	        @csrf
	        @method('PUT')
	        
	        <div class="row">
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Account Name</label>
						<div class="col-lg-7">
							<select class="form-control" name="name">
								<option value=""> Select Account </option>
								@foreach( \App\Models\Account::getAccounts() as $account )
									<option value="{{ $account['DESCRIPTION'] }} "
										@if(old('name', $charge->name) == $account['DESCRIPTION']) selected @endif> 
										{{ $account['DESCRIPTION'] }} 
									</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
		        <div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Charge To</label>
						<div class="col-lg-7">
							<input type="text" name="charge_to" class="form-control"
								value="{{ old('charge_to', $charge->charge_to) }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Code</label>
						<div class="col-lg-7">
							<input type="text" name="code" class="form-control" 
								value="{{ old('code', $charge->code) }}" />
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="name" class="col-lg-5 col-form-label">Type</label>
						<div class="col-lg-7">
							<select class="form-control" name="type">
								@foreach(\App\Helpers\Helper::account_types() as $type)
									<option value="{{ $type }}" @if(old('type', $charge->type)) selected @endif> {{ ucfirst($type) }} </option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="col-lg-3"></div>
				<div class="offset-3"></div>

				<div class="col-lg-6">
					<div class="form-group row">
						<label for="status" class="col-lg-5 col-form-label">Status</label>
						<div class="col-lg-7">
							<label>
								<input type="radio" name="status" value="1" @if(old('status',$charge->status)==1) checked @endif> Active
							</label> &nbsp;&nbsp;&nbsp;&nbsp;
							<label>									
								<input type="radio" name="status" value="0" @if(old('status',$charge->status)==0) checked @endif> Inactive
							</label>
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
