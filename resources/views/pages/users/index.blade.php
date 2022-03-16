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
					<li class="breadcrumb-item"><a href="#">Maintenance</a></li>
					<li class="breadcrumb-item"><a href="request-temporary-slip.html">Users</a></li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Users</h4>
		</div>

		<div class="d-md-block mt-4 mt-lg-0">
        	<a class="btn btn-sm pd-x-15 btn-primary btn-uppercase" href="{{ route('users.create') }}">
                <i data-feather="plus" class="wd-10 mg-r-5"></i> Create User
            </a>
        </div>

	</div>	

    @include('components.messages')

	<div class="row">

        <div class="col-lg-12">
            <table id="example1" class="table">
                
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Date Created</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)

                        <tr>
                            <td> {{ $user->lastname }} , {{ $user->firstname }} {{ $user->middlename }} </td>
                            <td> {{ $user->username }} </td>
                            <td>
                                @if($user->status == 1) 
                                    <span class="badge badge-primary tx-uppercase">Active</span>
                                @else
                                    <span class="badge badge-secondary tx-uppercase">Inactive</span>
                                @endif
                            </td>
                            <td> {{ $user->created_by }} </td>
                            <td> {{ \Carbon\Carbon::parse($user->created_at)->toFormattedDateString() }} </td>
                            <td>
                                <nav class="nav table-options">
                                    <a class="nav-link p-0 pl-2" href="{{ route('users.edit', $user->id) }}" title="Edit User">
                                        <i data-feather="external-link"></i>
                                    </a>
                                </nav>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center"> No User Found </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

	</div>

@endsection

@section('pagejs')

	<script src="{{ asset('lib/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
		$(function(){
			'use strict'

    		$('#example1').DataTable({
    			language: {
    			searchPlaceholder: 'Search',
    			sSearch: '',
    			lengthMenu: 'Show _MENU_ entries',
    			},
    			columnDefs: [
    			{ targets: 5, orderable: false }
    			],
    			dom: 'lf<"dataTables_responsive"t><"dataTables_total d-flex justify-content-end">ip'
    		});

    		// Select2
    		$('.dataTables_length select').select2({ 
                minimumResultsForSearch: Infinity 
            });
		});
    </script>

@endsection