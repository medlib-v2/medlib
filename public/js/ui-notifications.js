(function(){var e,s,n,r={}.hasOwnProperty,t=function(e,s){function n(){this.constructor=e}for(var t in s)r.call(s,t)&&(e[t]=s[t]);return n.prototype=s.prototype,e.prototype=new n,e.__super__=s.prototype,e};e=jQuery,n='<div class="messenger-spinner">\n    <span class="messenger-spinner-side messenger-spinner-side-left">\n        <span class="messenger-spinner-fill"></span>\n    </span>\n    <span class="messenger-spinner-side messenger-spinner-side-right">\n        <span class="messenger-spinner-fill"></span>\n    </span>\n</div>',s=function(s){function r(){return r.__super__.constructor.apply(this,arguments)}return t(r,s),r.prototype.template=function(s){var t;return t=r.__super__.template.apply(this,arguments),t.append(e(n)),t},r}(window.Messenger.Message),window.Messenger.themes.air={Message:s}}).call(this),function(e){function s(){e(".widget").widgster();var s="air";e.globalMessenger({theme:s}),Messenger.options={theme:s};var n=["bottom","right"],r=e(".location-selector"),t=function(){for(var r="messenger-fixed",t=0;t<n.length;t++)r+=" messenger-on-"+n[t];e.globalMessenger({extraClasses:r,theme:s}),Messenger.options={extraClasses:r,theme:s}};t(),r.locationSelector().on("update",function(e){n=e,t()}),e("#show-error-message").on("click",function(){var e;return e=0,Messenger().run({errorMessage:"Error destroying alien planet",successMessage:"Alien planet destroyed!",action:function(s){return++e<3?s.error({status:500,readyState:0,responseText:0}):s.success()}}),!1}),e("#show-info-message").on("click",function(){var e=Messenger().post({message:"Launching thermonuclear war...",actions:{cancel:{label:"cancel launch",action:function(){return e.update({message:"Thermonuclear war averted",type:"success",actions:!1})}}}});return!1}),e("#show-success-message").on("click",function(){return Messenger().post({message:"Showing success message was successful!",type:"success",showCloseButton:!0}),!1})}s(),MedlibApp.onPageLoad(s)}(jQuery);