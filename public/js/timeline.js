!function(e){function o(){var e=new GMaps({el:"#gmap",lat:-37.813179,lng:144.950259,zoomControl:!1,panControl:!1,streetViewControl:!1,mapTypeControl:!1,overviewMapControl:!1});setTimeout(function(){e.addMarker({lat:-37.813179,lng:144.950259,animation:google.maps.Animation.DROP,draggable:!0,title:"Here we are"})},3e3)}function n(){o(),e(".event-image > a").magnificPopup({type:"image"})}n(),MedlibApp.onPageLoad(n)}(jQuery);