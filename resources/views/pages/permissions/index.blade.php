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
					<li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permissions</a></li>
				</ol>
			</nav>
			<h4 class="mg-b-0 tx-spacing--1">Permissions</h4>
		</div>

		<div class="d-md-block mt-4 mt-lg-0">
            @if(auth()->user()->position != 'Audit' && auth()->user()->position != 'audit')
        	<a class="btn btn-sm pd-x-15 btn-primary btn-uppercase" href="{{ route('roles.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg> 
                Create Roles
            </a>
            @endif
        </div>

	</div>	

	<div class="row">

        <div class="col-lg-3">

            <label for="roles"> Roles </label>
            <select id="roles" class="form-control">
                @foreach( $roles as $role )
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @if(auth()->user()->position != 'Audit' && auth()->user()->position != 'audit')
            <button class="btn btn-primary mt-2" id="save-permissions"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                Save 
            </button>
            @endif

        </div>

        <div class="col-lg-9">
            
            <p> Permissions </p>

            <table id="example1" class="table">
                
                <thead>
                    <tr class="green">
                        <th>Permission List</th>
                        @foreach( $actions as $action )
                            <th> {{ ucfirst($action) }} </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    
                    @foreach( $modules as $module )

                        <tr>
                            
                            <td> {{ $module->name }} </td>

                            @foreach( $actions as $action )
                                @php $_exist = false; @endphp
                                @foreach( $module->actions as $action1 )
                                    @if($action == $action1 )
                                        @php $_exist = true; @endphp
                                    @endif
                                @endforeach

                                @if($_exist)
                                    <td> 
                                        <input type="checkbox" name="{{ strtolower($module->name) }} {{ strtolower($action) }}" 
                                            id="{{ Str::replace(' ', '_', strtolower($module->name)) }}_{{ Str::replace(' ', '_', strtolower($action)) }}" 
                                            value="{{ strtolower($module->name) }} {{ strtolower($action) }}" 
                                            data-control="{{ strtolower($module->name) }}"
                                            class="actions"> 
                                    </td>
                                @else
                                    <td> 
                                        <input type="checkbox" name="{{ strtolower($module->name) }}_{{ strtolower($action) }}" 
                                            id="{{ strtolower($module->name) }}_{{ strtolower($action) }}" disabled>
                                    </td>
                                @endif

                            @endforeach

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

	</div>

    <div class="modal fade effect-scale" id="confirm_message" tabindex="-1" 
        role="dialog" aria-labelledby="confirm_message" 
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
                    <p class="mb-0" id="message"> Role Permission Save Successfully. </p>
                </div>

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
    <script type="text/javascript">
        
        var _actions = {};
        var _role_id = $('#roles').val();

        $(document).ready(function() {
            $('#roles').change();
        });

        $(document).on('click', '#save-permissions', function() {
                    
            // ajax call to add role permissions
            $.ajax({
                url: '{!! route('permissions.store') !!}' ,
                type: 'POST' ,
                data: {
                    role_id : _role_id ,
                    actions : _actions , 
                    _token  : '{!! csrf_token() !!}',
                },
                success: function(res) {
                    console.log(res);
                    $('#confirm_message').modal('show');
                    setTimeout(function(){
                        $('#confirm_message').modal('hide');
                    }, 3000);

                }
            });

        });

        $(document).on('change', '.actions', function() {

            checkPermissions();

        });

        $(document).on('change', '#roles', function() {

            $('.actions').prop('checked', false);
            _role_id = $('#roles').val();

            // ajax to call existing role permissions
            $.ajax({
                url     : '{!! route("roles.permissions") !!}' ,
                type    : 'POST' ,
                data    : { role_id : _role_id, _token : '{!! csrf_token() !!}'  } ,
                success : function(res) {

                    $.each(res, function(i, item) {

                        let _name = item.name.replaceAll(" ", "_");
                        console.log(_name);
                        
                        $("#"+_name).prop('checked', true);

                    });

                }

            })

        });

        function checkPermissions() {

            _actions = {};

            $('.actions').each(function() {
                
                if($(this).is(':checked')) {
                
                    let __action = $(this).data('control');

                    if(_actions[__action] !== undefined) {
                        _actions[__action].push($(this).val());                        
                    } else {
                        _actions[__action] = [];
                        _actions[__action].push($(this).val());
                    }

                }

            });

            return _actions;

        }

    </script>

@endsection