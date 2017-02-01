<br>
<footer class="footer-container">
    <div class="container" id="footer-block">
        <div class="row">
            <div class="row animated fadeInDownShort">
                <div class="footer-block col-xs-12 col-sm-3">
                    <h4>Medlib</h4>
                    <div class="toggle-footer">
                        <ul class="list-unstyled">
                            <li><a href="{{url('/site/affiliate')}}">Affiliates</a></li>
                            <li><a href="{{url('/site/about')}}">About Us</a></li>
                            <li><a href="{{url('/feed')}}">RSS Feed</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-block col-xs-12 col-sm-3">
                    <h4>Help &amp; Support</h4>
                    <div class="toggle-footer">
                        <ul class="list-unstyled">
                            <li><a href="{{url('/site/faq')}}">FAQ</a></li>
                            <li><a href="https://docs.google.com/a/etna-alternance.net/forms/d/e/1FAIpQLSdgXfiOGKYGp0Vy-ARTEX7ny0lHsXmAa315HQDyN3f-giyQqQ/viewform" target="_blank">Questionnaire de satisfaction</a></li>
                            <li><a href="{{route('contact.show')}}">Nous contacter</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-block col-xs-12 col-sm-3">
                    <h4>Resources</h4>
                    <div class="toggle-footer">
                        <ul class="list-unstyled">
                            <li><a href="https://medlibsite.wordpress.com" target="_blank">Blog</a></li>
                            <li><a href="{{url('/blog/resources')}}">Resource List</a></li>
                            <li><a href="{{url('/blog/category/tutorials')}}">Tutorials</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-block col-xs-12 col-sm-3">
                    <h4>Social</h4>
                    <div class="toggle-footer">
                        <ul class="list-unstyled">
                            <li><a href="https://www.facebook.com/Medlib-475747165961654/?ref=ts&fref=ts" target="_blank">Facebook</a></li>
                            <!--<li><a href="https://twitter.com/medlib" target="_blank">Twitter</a></li>-->
                            <li><a href="https://www.youtube.com/channel/UCiWrU8r3dvCKg15No-W15mA" target="_blank">YouTube</a></li>
                            <!--<li><a href="https://plus.google.com/+medlib/posts" target="_blank">Google+</a></li>-->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-footer">
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

