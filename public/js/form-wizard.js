function validateServerLabel(e){var s=e.val(),a={};return""==s?(a.status=!1,a.msg="Please enter a label"):a.status=!0,a}function validateFQDN(e){var s=$(e),a={};return s.is(":disabled")?a.status=!0:0===s.data("lookup")?(a.status=!1,a.msg="Preform lookup first"):0===s.data("is-valid")?(a.status=!1,a.msg="Lookup Failed"):a.status=!0,a}function lookup(){$("#fqdn").data("lookup",1),$("#fqdn").data("is-valid",1),$("#ip").val("127.0.0.1")}$(function(){function e(){$(".widget").widgster(),$("#destination").inputmask({mask:"99999"}),$("#credit").inputmask({mask:"9999-9999-9999-9999"}),$("#expiration-date").datetimepicker({pickTime:!1}),$("#wizard").bootstrapWizard({onTabShow:function(e,s,a){var i=s.find("li").length,t=a+1,r=t/i*100,n=$("#wizard");n.find(".progress-bar").css({width:r+"%"}),t>=i?(n.find(".pager .next").hide(),n.find(".pager .finish").show(),n.find(".pager .finish").removeClass("disabled")):(n.find(".pager .next").show(),n.find(".pager .finish").hide()),s.find("li").removeClass("done"),e.prevAll().addClass("done")},onNext:function(e,s,a){var i=$(e.find("a[data-toggle=tab]").attr("href")),t=i.find("form");return t.length?t.parsley().validate():void 0},onTabClick:function(e,s,a,i){return s.find("li:eq("+i+")").is(".done")}}).find(".tab-pane").css({height:444}),$(".modal.wizard").remove(),$(".chzn-select").select2();var e=$("#satellite-wizard").wizard({keyboard:!1,contentHeight:400,contentWidth:700,backdrop:"static"});$("#fqdn").on("input",function(){0!=$(this).val().length?($("#ip").val("").attr("disabled","disabled"),$("#fqdn, #ip").parents(".form-group").removeClass("has-error has-success")):$("#ip").val("").removeAttr("disabled")});var s=/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/;x=46,$("#ip").on("input",function(){0!=$(this).val().length?$("#fqdn").val("").attr("disabled","disabled"):$("#fqdn").val("").removeAttr("disabled")}).keypress(function(e){return 8!=e.which&&0!=e.which&&e.which!=x&&(e.which<48||e.which>57)?(console.log(e.which),!1):void 0}).keyup(function(){var e=$(this);if(s.test(e.val())){x=0;var a=e.val().substr(e.val().length-1);"."==a&&e.val(e.val().slice(0,-1));var i=e.val().split(".");4==i.length&&(console.log("Valid IP"),e.parents(".form-group").removeClass("has-error").addClass("has-success"))}else{for(console.log("Not Valid IP"),e.parents(".form-group").removeClass("has-error has-success").addClass("has-error");-1!==e.val().indexOf("..");)e.val(e.val().replace("..","."));x=46}}),e.on("closed",function(){e.reset()}),e.on("reset",function(){e.modal.find(":input").val("").removeAttr("disabled"),e.modal.find(".form-group").removeClass("has-error").removeClass("has-succes"),e.modal.find("#fqdn").data("is-valid",0).data("lookup",0)}),e.on("submit",function(e){({hostname:$("#new-server-fqdn").val()});this.log("seralize()"),this.log(this.serialize()),this.log("serializeArray()"),this.log(this.serializeArray()),setTimeout(function(){e.trigger("success"),e.hideButtons(),e._submitting=!1,e.showSubmitCard("success"),e.updateProgressBar(0)},2e3)}),e.el.find(".wizard-success .im-done").click(function(){e.hide(),setTimeout(function(){e.reset()},250)}),e.el.find(".wizard-success .create-another-server").click(function(){e.reset()}),e.el.find(".wizard-progress-container .progress").removeClass("progress-striped").addClass("progress-xs"),$(".wizard-group-list").click(function(){alert("Disabled for demo.")}),$("#open-wizard").click(function(s){s.preventDefault(),e.show()})}e(),MedlibApp.onPageLoad(e)});