<br>
<footer class="footer">
    <div class="container footerWrap">
        <div class="row">
            <div class="col-xs-12 col-sm-3">
                <h4>Medlib</h4>
                <ul class="list-unstyled">
                    <li><a href="{{url('/site/affiliate')}}">Affiliates</a></li>
                    <li><a href="{{url('/site/about')}}">About Us</a></li>
                    <li><a href="{{url('/feed')}}">RSS Feed</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h4>Help &amp; Support</h4>
                <ul class="list-unstyled">
                    <li><a href="{{url('/site/faq')}}">FAQ</a></li>
                    <li><a href="{{url('/site/payment')}}">Payment Rates</a></li>
                    <li><a href="{{url('/site/contact')}}">Contact Support</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h4>Resources</h4>
                <ul class="list-unstyled">
                    <li><a href="{{url('/blog')}}">Blog</a></li>
                    <li><a href="{{url('/blog/resources')}}">Resource List</a></li>
                    <li><a href="{{url('/blog/category/tutorials')}}">Tutorials</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h4>Social</h4>
                <ul class="list-unstyled">
                    <li><a href="https://www.facebook.com/medlib" target="_blank">Facebook</a></li>
                    <li><a href="https://twitter.com/medlib" target="_blank">Twitter</a></li>
                    <li><a href="http://www.youtube.com/user/medlib" target="_blank">YouTube</a></li>
                    <li><a href="https://plus.google.com/+medlib/posts" target="_blank">Google+</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="subFooter">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="pull-left">
                        &copy; {{ date('Y') }} <a href="{{url('/')}}" rel="nofollow">MedLib Project - EIP ETNA.</a> |
                        <a href="{{url('/site/licenses')}}">Licenses</a> |
                        <a href="{{url('/site/terms')}}">Terms &amp; Conditions</a> |
                        <a href="{{url('site/privacy')}}">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- The Loader. Is shown when pjax happens -->
<div class="loader-wrap hiding hide">
    <i class="fa fa-circle-o-notch fa-spin-fast"></i>
</div>

<!-- common libraries. required for every page-->
<script type="text/javascript" src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery-pjax/jquery.pjax.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/transition.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/collapse.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/button.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/tooltip.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap-sass/vendor/assets/javascripts/bootstrap/alert.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jQuery-slimScroll/jquery.slimscroll.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/widgster/widgster.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/pace.js/pace.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery-touchswipe/jquery.touchSwipe.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery-touchswipe/jquery.touchSwipe.js') }}"></script>

<!-- common app js -->
<script type="text/javascript" src="{{ asset('js/settings-app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/progressbar.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.input.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.param.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.progress.js') }}"></script>

<!-- page specific js -->
<script type="text/javascript" src="{{ asset('vendor/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/form-elements-home.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jasny-bootstrap/js/fileinput.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jquery.sparkline/dist/jquery.sparkline.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tables-basic.js') }}"></script>

<!-- page specific libs -->
@yield('script')
<!-- page specific js -->