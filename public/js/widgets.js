!function(e){function a(a,r){a.sparkline(r,{type:"line",width:"100%",height:"60",lineColor:Medlib.colors.gray,fillColor:"transparent",spotRadius:5,spotColor:Medlib.colors.gray,valueSpots:{"0:":Medlib.colors.gray},highlightSpotColor:Medlib.colors.white,highlightLineColor:Medlib.colors.gray,minSpotColor:Medlib.colors.gray,maxSpotColor:Medlib.colors["brand-danger"],tooltipFormat:new e.SPFormatClass('<span style="color: white">&#9679;</span> {{prefix}}{{y}}{{suffix}}'),chartRangeMin:_(r).min()-1})}function r(){a(e("#chart-simple"),[4,6,5,7,5]),MedlibApp.onResize(function(){a(e("#chart-simple"),[4,6,5,7,5])})}function o(){function a(){t.configure({width:e("#chart-changes").width(),gapSize:.5,min:"auto",strokeWidth:3}),t.render()}for(var r=100,o=[[],[],[],[],[]],l=new Rickshaw.Fixtures.RandomData(1e4),i=0;i<32;i++)l.addData(o);var t=new Rickshaw.Graph({element:document.getElementById("chart-changes"),renderer:"multi",height:r,series:[{name:"pop",data:o.shift().map(function(e){return{x:e.x,y:e.y}}),color:Medlib.lighten(Medlib.colors["brand-success"],.09),renderer:"bar"},{name:"humidity",data:o.shift().map(function(e){return{x:e.x,y:e.y*(.1*Math.random()+1.1)}}),renderer:"line",color:Medlib.colors.white}]});MedlibApp.onResize(a),a();var n=(new Rickshaw.Graph.HoverDetail({graph:t}),new Rickshaw.Graph.Behavior.Series.Highlight({graph:t}),new Rickshaw.Graph.Axis.Y({graph:t,ticksTreatment:"hide",pixelsPerTick:r}));n.render()}function l(){var a=e("#chart-changes-year"),r=[3,6,2,4,5,8,6,8],o=_(r).max(),l=r.map(function(){return o});a.sparkline(l,{type:"bar",height:26,barColor:Medlib.colors["gray-lighter"],barWidth:7,barSpacing:5,chartRangeMin:_(r).min(),tooltipFormat:new e.SPFormatClass("")}),a.sparkline(r,{composite:!0,type:"bar",barColor:Medlib.colors["brand-success"],barWidth:7,barSpacing:5})}function i(){function a(){return Math.floor(30*Math.random())+10}function r(){e.plot(e("#chart-stats-simple"),[{data:l,showLabels:!0,label:"Visitors",labelPlacement:"below",canvasRender:!0,cColor:"#FFFFFF"},{data:o,showLabels:!0,label:"Test Visitors",labelPlacement:"below",canvasRender:!0,cColor:"#FFFFFF"}],{series:{lines:{show:!0,lineWidth:1,fill:!1,fillColor:{colors:[{opacity:.001},{opacity:.5}]}},points:{show:!1,fill:!0},shadowSize:0},legend:!1,grid:{show:!1,margin:0,labelMargin:0,axisMargin:0,hoverable:!0,clickable:!0,tickColor:"rgba(255,255,255,1)",borderWidth:0},colors:[Medlib.darken(Medlib.colors["gray-lighter"],.05),Medlib.colors["brand-danger"]]})}for(var o=[],l=[],i=0;i<25;i++)o.push([i,Math.floor(5*i)+a()]);for(i=0;i<25;i++)l.push([i,Math.floor(4*i)+a()]);r(),MedlibApp.onResize(r)}function t(){function a(){return Math.floor(30*Math.random())+10}function r(){e.plot(e("#chart-stats-simple-2"),[{data:l,showLabels:!0,label:"Visitors",labelPlacement:"below",canvasRender:!0,cColor:"#FFFFFF"},{data:o,showLabels:!0,label:"Test Visitors",labelPlacement:"below",canvasRender:!0,cColor:"#FFFFFF"}],{series:{lines:{show:!0,lineWidth:1,fill:!1,fillColor:{colors:[{opacity:.001},{opacity:.5}]}},points:{show:!1,fill:!0},shadowSize:0},legend:!1,grid:{show:!1,margin:0,labelMargin:0,axisMargin:0,hoverable:!0,clickable:!0,tickColor:"rgba(255,255,255,1)",borderWidth:0},colors:["#777",Medlib.colors["brand-warning"]]})}for(var o=[],l=[],i=0;i<25;i++)o.push([i,Math.floor(5*i)+a()]);for(i=0;i<25;i++)l.push([i,Math.floor(4*i)+a()]);r(),MedlibApp.onResize(r)}function n(){"use strict";function a(){i.configure({width:e("#realtime1").width()}),i.render()}for(var r=[[],[]],o=new Rickshaw.Fixtures.RandomData(30),l=0;l<30;l++)o.addData(r);var i=new Rickshaw.Graph({element:document.getElementById("realtime1"),height:130,renderer:"area",series:[{color:Medlib.colors["gray-dark"],data:r[0],name:"Uploads"},{color:Medlib.colors.gray,data:r[1],name:"Downloads"}]});MedlibApp.onResize(a),a(),new Rickshaw.Graph.HoverDetail({graph:i,xFormatter:function(e){return new Date(1e3*e).toString()}}),setInterval(function(){o.removeData(r),o.addData(r),i.update()},1e3)}function s(){var a=e("#map-years-mapael");a.css("height",394).css("margin-bottom",-15).find(".map").css("height",parseInt(a.parents(".widget").css("height"))-40),a.mapael({map:{name:"world_countries",defaultArea:{attrs:{fill:Medlib.colors["gray-lighter"],stroke:Medlib.colors.gray},attrsHover:{fill:Medlib.colors["gray-light"],animDuration:100}},defaultPlot:{size:17,attrs:{fill:Medlib.colors["brand-warning"],stroke:"#fff","stroke-width":0,"stroke-linejoin":"round"},attrsHover:{"stroke-width":1,animDuration:100}},zoom:{enabled:!0,step:1,maxLevel:10}},legend:{area:{display:!1,slices:[{max:5e6,attrs:{fill:Medlib.lighten("#ebeff1",.04)},label:"Less than 5M"},{min:5e6,max:1e7,attrs:{fill:"#ebeff1"},label:"Between 5M and 10M"},{min:1e7,max:5e7,attrs:{fill:Medlib.colors["gray-lighter"]},label:"Between 10M and 50M"},{min:5e7,attrs:{fill:Medlib.darken("#ebeff1",.1)},label:"More than 50M"}]}},areas:fakeWorldData[2009].areas});var r=e.fn.mapael.maps.world_countries.getCoords(59.599254,8.863224);a.trigger("zoom",[6,r.x,r.y]),a.find(".map-controls > li > a").on("click",function(){return e(".map-controls > li").removeClass("active"),e(this).parents("li").addClass("active"),a.trigger("update",[fakeWorldData[e(this).data("years-map-year")],{},{},{animDuration:300}]),!1})}function c(){e(".live-tile").css("height",function(){return e(this).data("height")}).liveTile(),e(document).one("pjax:beforeReplace",function(){e(".live-tile").liveTile("destroy",!0).each(function(){var a=e(this).data("LiveTile");"undefined"!=typeof a&&(clearTimeout(a.eventTimeout),clearTimeout(a.flCompleteTimeout),clearTimeout(a.completeTimeout))})})}function d(){var e=new Skycons({color:Medlib.colors.white});e.set("clear-day","clear-day"),e.play(),e=new Skycons({color:Medlib.colors.white}),e.set("partly-cloudy-day","partly-cloudy-day"),e.play(),e=new Skycons({color:Medlib.colors.white}),e.set("rain","rain"),e.play(),e=new Skycons({color:Medlib.lighten(Medlib.colors["brand-warning"],.1)}),e.set("clear-day-3","clear-day"),e.play(),e=new Skycons({color:Medlib.colors.white}),e.set("partly-cloudy-day-3","partly-cloudy-day"),e.play(),e=new Skycons({color:Medlib.colors.white}),e.set("clear-day-1","clear-day"),e.play(),e=new Skycons({color:Medlib.colors["brand-success"]}),e.set("partly-cloudy-day-1","partly-cloudy-day"),e.play(),e=new Skycons({color:Medlib.colors.gray}),e.set("clear-day-2","clear-day"),e.play(),e=new Skycons({color:Medlib.colors["gray-light"]}),e.set("wind-1","wind"),e.play(),e=new Skycons({color:Medlib.colors["gray-light"]}),e.set("rain-1","rain"),e.play()}function h(){e(".widget-chat-list-group").slimscroll({height:"287px",size:"4px",borderRadius:"1px",opacity:.3})}function p(){e(".widget").widgster(),r(),o(),l(),i(),t(),n(),s(),c(),d(),h()}p(),MedlibApp.onPageLoad(p)}(jQuery);