<!DOCTYPE html>
<html lang="en">

	<head>

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">

	<title>PCFR</title>

	<!-- vendor css -->
	<link href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
	<link href="{{ asset('lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

	<!-- DashForge CSS -->
	<link rel="stylesheet" href="{{ asset('css/dashforge.css') }}">
	<link rel="stylesheet" href="{{ asset('css/dashforge.auth.css') }}">
	<!-- <link rel="stylesheet" href="assets/css/skin.dark.css"> -->

	</head>

	<body>

		<header class="navbar navbar-header navbar-header-fixed justify-content-center">

			<div class="navbar-brand pl-0 d-flex justify-content-center">

				<a href="/" class="df-logo">

					<img src="{{ asset('img/logo (1).png') }}" alt="Citi Hardware Logo">

				</a>

			</div><!-- navbar-brand -->

		</header><!-- navbar -->

		<div class="content content-fixed content-auth">
		
			<div class="container">
				
				<div class="media align-items-stretch justify-content-center ht-100p pos-relative">

				  	<div class="sign-wrapper">

						<div class="wd-100p">
					
						<p class="tx-color-03 tx-lg-24 tx-md-16 tx-14 mg-b-40">Petty Cash Fund Replenishment System</p>

						<form method="POST" action="{{ route('login') }}">
            				@csrf

							<div class="form-group">

								<label>Username</label>
								<input type="text" class="form-control" name="username" :value="old('username')" required autofocus />

							</div>
							
							<div class="form-group">
							
								<div class="d-flex justify-content-between mg-b-5">

									<label class="mg-b-0-f">Password</label>
									<a href="{{ route('password.request') }}" class="tx-13">Forgot password?</a>

								</div>
								
								<input type="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
							
							</div>
							
							<button class="btn btn-brand-02 btn-block" type="submit">Log In</button>

						</form>
						
						</div>

				  	</div><!-- sign-wrapper -->

				</div><!-- media -->

			</div><!-- container -->

		</div><!-- content -->

		<footer class="footer justify-content-center">

	      	<div>
	        	<small>&copy; Copyright {{ date('Y') }}. All Rights Reserved</small>
	      	</div>

	    </footer>

		<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
		<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
		<script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
		<script src="{{ asset('js/dashforge.js') }}"></script>

	</body>

</html>