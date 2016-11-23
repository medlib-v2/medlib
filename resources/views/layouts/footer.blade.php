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
                    <li><a href="https://docs.google.com/a/etna-alternance.net/forms/d/e/1FAIpQLSdgXfiOGKYGp0Vy-ARTEX7ny0lHsXmAa315HQDyN3f-giyQqQ/viewform" target="_blank">Questionnaire de satisfaction</a></li>
                    <li><a href="{{url('/site/contact')}}">Nous contacter</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h4>Resources</h4>
                <ul class="list-unstyled">
                    <li><a href="https://medlibsite.wordpress.com" target="_blank">Blog</a></li>
                    <li><a href="{{url('/blog/resources')}}">Resource List</a></li>
                    <li><a href="{{url('/blog/category/tutorials')}}">Tutorials</a></li>
                </ul>
            </div>
            <div class="col-xs-12 col-sm-3">
                <h4>Social</h4>
                <ul class="list-unstyled">
                    <li><a href="https://www.facebook.com/Medlib-475747165961654/?ref=ts&fref=ts" target="_blank">Facebook</a></li>
                    <!--<li><a href="https://twitter.com/medlib" target="_blank">Twitter</a></li>-->
                    <li><a href="https://www.youtube.com/channel/UCiWrU8r3dvCKg15No-W15mA" target="_blank">YouTube</a></li>
                    <!--<li><a href="https://plus.google.com/+medlib/posts" target="_blank">Google+</a></li>-->
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
<div id="cookiebar"></div>
<!-- common libraries. required for every page -->
<script type="text/javascript" src="{{ App::rev('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ App::rev('js/vendors.min.js') }}"></script>
<!-- page specific js -->
@if (Auth::guest())
<script type="text/javascript">
    $(window).load(function() {
        $('.form input').on('focus blur', function(e) {
            $(this).parents('.form').toggleClass('active', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
    });
</script>

<script type="text/javascript" src="{{ App::rev('js/password.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('#password').Password({
            innerToggle: true,
            //touchSupport: Modernizr.touch,
            title: 'Click here show/hide password',
            hideToggleUntil: 'focus'
        });
    });
</script>
@endif
<!-- page specific libs -->
@yield('script')
<script type="text/javascript">
function _getCookie() {
    var key = 'medlib_cookie';
    var ca = document.cookie ? document.cookie.split('; ') : [];
    for(var i=0; i < ca.length; i++) {
                var parts = ca[i].split('='), name = decodeURIComponent(parts.shift()), cookie = parts.join('=');
                if (key === name) {
                    var result = JSON.parse(cookie);
                    return result;
                    break;
                }
            }
            return "";
}
var cookie = _getCookie();
//-- check if we do have a cookie already set
if (cookie !== "") {
    //cookie.cookieSet;
    //cookie.dismissCookie;
    if(cookie.cookieSet) {
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-80732713-1', 'auto');
        ga('send', 'pageview');
    }
} else {
  document.write('<script type="text/javascript" src=\'{{ App::rev("js/vue/cookiesbar.min.js") }}\'><\/script>')
}
</script>

@if ( config('app.debug') )
  <script type="text/javascript">
    //document.write('<script src="http://localhost:35729/livereload.js?snipver=1" type="text/javascript"><\/script>')
  </script>
@endif
