!function(t){function n(){t("#sparkline2").sparkline([2,4,8],{type:"pie",width:"100px",height:"100px",sliceColors:["#F5CB7B","#FAEEE5","#f0f0f0"]})}function a(t,n,a){function r(t){for(var a=1/(.1+Math.random()),r=2*Math.random()-.5,e=10/(.1+Math.random()),i=0;i<n;i++){var o=(i/n-r)*e;t[i]+=a*Math.exp(-o*o)}}return arguments.length<3&&(a=0),d3.range(t).map(function(){var t,e=[];for(t=0;t<n;t++)e[t]=a+a*Math.random();for(t=0;t<5;t++)r(e);return e.map(function(t,n){return{x:n,y:Math.max(0,t)}})})}function r(t,n){var r=(new Date).getTime(),e=864e5,i=60,o=i*e,u=r-o,n=n||45,d=i/n;return a(t.length,n,.1).map(function(n,a){return{key:t[a],values:n.map(function(t,n){return{x:u+t.x*e*d,y:Math.floor(100*t.y)}})}})}function e(){nv.addGraph(function(){var t=nv.models.multiBarChart().margin({left:28,bottom:30,right:0}).color(["#F7653F","#ddd"]);return t.xAxis.showMaxMin(!1).ticks(1e3).tickFormat(function(t){return d3.time.format("%b %d")(new Date(t))}),t.yAxis.showMaxMin(!1).ticks(0).tickFormat(d3.format(",f")),d3.select("#nvd32 svg").style("height","300px").datum(r(["Uploads","Downloads"],10).map(function(t,n){return t.area=!0,t})).transition().duration(500).call(t),MedlibApp.onResize(t.update),t})}function i(){t(".widget").widgster(),t(".sparkline").each(function(){t(this).sparkline("html",t(this).data())}),n(),e()}i()}(jQuery);