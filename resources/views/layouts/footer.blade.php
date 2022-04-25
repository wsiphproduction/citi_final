<footer class="footer justify-content-center">

    <div>
        <small>&copy; Copyright {{ date('Y') }}. All Rights Reserved</small>
    </div>

</footer>

<script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lib/jqueryui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lib/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('js/accounting.min.js') }}"></script>

@yield('pagejs')

<script src="{{ asset('js/dashforge.js') }}"></script>
<script src="{{ asset('js/dashforge.aside.js') }}"></script>