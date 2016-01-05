 <!-- The Loader. Is shown when pjax happens -->
    <div class="loader-wrap hiding hide">
        <i class="fa fa-circle-o-notch fa-spin-fast"></i>
        <footer class="footer">
            Medlib v1.0.0 &copy; Copyright {{ date('Y') }} <a href="{{route('home')}}" rel="nofollow"><strong>MedLib Project - EIP ETNA.</strong></a>
        </footer>
    </div>

    <!-- common libraries. required for every page-->
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-pjax/jquery.pjax.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/dropdown.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js') }}"></script>
    <script src="{{ asset('vendor/jQuery-slimScroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('vendor/widgster/widgster.js') }}"></script>
    <script src="{{ asset('vendor/pace.js/pace.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-touchswipe/jquery.touchSwipe.js') }}"></script>
    <script src="{{ asset('vendor/jquery-touchswipe/jquery.touchSwipe.js') }}"></script>

    <!-- common app js -->
    <script src="{{ asset('js/settings-app.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/autocomplete.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('vendor/underscore/underscore-min.js') }}"></script>
    <script src="{{ asset('vendor/backbone/backbone.js') }}"></script>
    <script src="{{ asset('vendor/messenger/build/js/messenger.js') }}"></script>
    <script src="{{ asset('vendor/messenger/build/js/messenger-theme-flat.js') }}"></script>
    <script src="{{ asset('/vendor/messenger/docs/welcome/javascripts/location-sel.js') }}"></script>
    <script src="{{ asset('js/ui-notifications.js') }}"></script>


    <!-- page specific libs -->
    @yield('script')
    <!-- page specific js -->