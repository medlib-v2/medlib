!function(e){function n(){e("#geo-locations-number, #percent-1, #percent-2, #percent-3").each(function(){e(this).animateNumber({number:e(this).text().replace(/ /gi,""),numberStep:e.animateNumber.numberStepFactories.separator(" "),easing:"easeInQuad"},1e3)}),e(".js-progress-animate").animateProgressBar()}function t(){e(".widget").widgster(),n()}t(),MedlibApp.onPageLoad(t)}(jQuery);