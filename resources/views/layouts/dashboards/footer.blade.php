    <!-- The Loader. Is shown when pjax happens -->
    <div class="loader-wrap hiding hide">
        <i class="fa fa-circle-o-notch fa-spin-fast"></i>
    </div>

    <!-- common libraries. required for every page-->
    <script src="{{ url('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ url('vendor/jquery-pjax/jquery.pjax.js') }}"></script>
    <script src="{{ url('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js') }}"></script>
    <script src="{{ url('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js') }}"></script>
    <script src="{{ url('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/dropdown.js') }}"></script>
    <script src="{{ url('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js') }}"></script>
    <script src="{{ url('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js') }}"></script>
    <script src="{{ url('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js') }}"></script>
    <script src="{{ url('vendor/jQuery-slimScroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ url('vendor/widgster/widgster.js') }}"></script>
    <script src="{{ url('vendor/pace.js/pace.min.js') }}"></script>
    <script src="{{ url('vendor/jquery-touchswipe/jquery.touchSwipe.js') }}"></script>
    <script src="{{ url('vendor/jquery-touchswipe/jquery.touchSwipe.js') }}"></script>

    <!-- common app js -->
    <script src="{{ url('js/settings.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>
    <script src="{{ url('js/autocomplete.js') }}"></script>

    <!-- page specific libs -->
    @yield('script')
    <!-- page specific js -->