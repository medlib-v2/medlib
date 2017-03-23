@if(app()->environment('production') && ($account = config('medlib.google.account')))
    <script type="text/javascript">
        function _getCookie() {
            let key = 'medlib_cookie', result;
            let ca = document.cookie ? document.cookie.split('; ') : [];
            for(let i=0; i < ca.length; i++) {
                let parts = ca[i].split('='), name = decodeURIComponent(parts.shift()), cookie = parts.join('=');
                if (key === name) {
                    result = JSON.parse(cookie);
                    return result;
                    break;
                }
            }
            return "";
        }
        let cookie = _getCookie();
        //-- check if we do have a cookie already set
        if (cookie !== "") {
            //cookie.cookieSet;
            //cookie.dismissCookie;
            if(cookie.cookieSet) {
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

                ga('create', '{{ $account }}', 'auto');
                ga('send', 'pageview');
            }
        } else {
            document.write('<script type="text/javascript" src=\'{{ App::rev("js/cookiesbar.min.js") }}\'><\/script>')
        }
    </script>
@endif