function GetXmlHttpObject(t){var e=null;if(navigator.userAgent.indexOf("Opera")>=0)return void alert("This example doesn't work in Opera");if(navigator.userAgent.indexOf("MSIE")>=0){var i="Msxml2.XMLHTTP";navigator.appVersion.indexOf("MSIE 5.5")>=0&&(i="Microsoft.XMLHTTP");try{return e=new ActiveXObject(i),e.onreadystatechange=t,e}catch(n){return void alert("Error. Scripting for ActiveX might be disabled")}}return navigator.userAgent.indexOf("Mozilla")>=0?(e=new XMLHttpRequest,e.onload=t,e.onerror=t,e):void 0}var sitepath="http://www.coupay.com.sg/",url=sitepath+"track_status.php?",csloginjs=csloginjs||function(){var t={};return{init:function(e){t=e},validateCsApi:function(){function e(t,e){var i=t.split("?");if(i.length>=2){for(var n=encodeURIComponent(e)+"=",s=i[1].split(/[&;]/g),r=s.length;r-- >0;)-1!==s[r].lastIndexOf(n,0)&&s.splice(r,1);return t=i[0]+"?"+s.join("&")}return t}function i(t,e){xmlHttp_149=GetXmlHttpObject(n),xmlHttp_149.open("GET",url+"like_url="+encodeURIComponent(t)+"&site_id="+s+"&is_like="+e),xmlHttp_149.send(null)}function n(){4==xmlHttp_149.readyState&&alert(xmlHttp_149.responseText)}if("m6NGeEub36"!=t[0]||"5"!=t[1]||"bcY4JJaoUl"!=t[2]||"coupay.com"!=t[3])return void alert("Authentication fail.");document.write('<div id="fb-root"></div>');var s="1";window.fbAsyncInit=function(){FB.init({appId:"532241270201105",status:!0,cookie:!0,xfbml:!0}),FB.Event.subscribe("edge.create",function(t,n){var s=e(document.URL,"csid"),r=e(s,"site_id"),a=e(r,"is_fb"),o=e(a,"is_li"),c=e(a,"is_tw");if("?"==c.slice(-1))var l=o.slice(-1);else var l=c;i(l,"1")}),FB.Event.subscribe("edge.remove",function(t,n){var s=e(document.URL,"csid"),r=e(s,"site_id"),a=e(r,"is_fb"),o=e(a,"is_li"),c=e(a,"is_tw");if("?"==c.slice(-1))var l=o.slice(-1);else var l=c;i(l,"0")})},function(){var t=document.createElement("script");t.type="text/javascript",t.src=document.location.protocol+"//connect.facebook.net/en_US/all.js",t.async=!0,document.getElementById("fb-root").appendChild(t)}(),document.writeln('<script src="https://platform.twitter.com/widgets.js" type="text/javascript">'),document.writeln("</script>"),document.writeln('<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>'),document.writeln('<script src="https://apis.google.com/js/platform.js" async defer></script>'),setTimeout(function(){twttr.ready(function(t){t.events.bind("tweet",function(t){var n=e(document.URL,"csid"),s=e(n,"site_id"),r=e(s,"is_fb"),a=e(r,"is_li"),o=e(r,"is_tw");if("?"==o.slice(-1))var c=a.slice(-1);else var c=o;i(c,"2")})})},1e3),document.write('<div id="csshareicons" style="width:auto;float:left;" ><div style="width:auto;float:left;" id="cslike" class="fb-like" data-href="'+document.URL+'" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false"></div>'),document.write('&nbsp;&nbsp;&nbsp;<div id="tw" style="width:84px;float:left;margin-left:10px;"><a href="'+document.URL+'" class="twitter-share-button"  data-lang="en">Tweet</a></div>&nbsp;&nbsp;&nbsp;'),document.write('<div id="li" style="width:auto;float:left;"><script type="IN/Share" data-counter="right"   data-onSuccess="cslisharesuccess"   data-onError="cslishareerror"  ></script></div>'),document.write('<div id="gp" style="width:40px;float:left;margin-left:4px;"><g:plusone onendinteraction="csGpshare"></g:plusone></div>'),document.write("</div>")}}}();