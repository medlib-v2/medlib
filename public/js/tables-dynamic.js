!function(e){function a(){function a(a){var t=[{name:"id",label:"ID",editable:!1,cell:Backgrid.IntegerCell.extend({orderSeparator:""})},{name:"name",label:"Name",cell:"string"},{name:"pop",label:"Population",cell:"integer"},{name:"url",label:"URL",cell:"uri"}];Sing.isScreen("xs")&&t.splice(3,1);var l=new Backgrid.Grid({columns:t,collection:a,className:"table table-striped table-editable no-margin mb-sm"}),i=new Backgrid.Extension.Paginator({slideScale:.25,goBackFirstOnSort:!1,collection:a,controls:{rewind:{label:'<i class="fa fa-angle-double-left fa-lg"></i>',title:"First"},back:{label:'<i class="fa fa-angle-left fa-lg"></i>',title:"Previous"},forward:{label:'<i class="fa fa-angle-right fa-lg"></i>',title:"Next"},fastForward:{label:'<i class="fa fa-angle-double-right fa-lg"></i>',title:"Last"}}});e("#table-dynamic").html("").append(l.render().$el).append(i.render().$el)}Backgrid.InputCellEditor.prototype.attributes.class="form-control input-sm";var t=Backbone.Model.extend({}),l=Backbone.PageableCollection.extend({model:t,url:"demo/json/pageable-territories.json",state:{pageSize:9},mode:"client"}),i=new l,n=i;SingApp.onResize(function(){a(i)}),a(i),e("#search-countries").keyup(function(){var t=e(this),i=n.fullCollection.filter(function(e){return~e.get("name").toUpperCase().indexOf(t.val().toUpperCase())});a(new l(i,{state:{firstPage:1,currentPage:1}}))}),i.fetch(),e(".input-group-transparent, .input-group-no-border").transparentGroupFocus()}function t(){e.extend(!0,e.fn.dataTable.defaults,{sDom:"<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",sPaginationType:"bootstrap",oLanguage:{sLengthMenu:"_MENU_ records per page"}}),e.extend(e.fn.dataTableExt.oStdClasses,{sWrapper:"dataTables_wrapper form-inline"}),e.fn.dataTableExt.oApi.fnPagingInfo=function(e){return{iStart:e._iDisplayStart,iEnd:e.fnDisplayEnd(),iLength:e._iDisplayLength,iTotal:e.fnRecordsTotal(),iFilteredTotal:e.fnRecordsDisplay(),iPage:e._iDisplayLength===-1?0:Math.ceil(e._iDisplayStart/e._iDisplayLength),iTotalPages:e._iDisplayLength===-1?0:Math.ceil(e.fnRecordsDisplay()/e._iDisplayLength)}},e.extend(e.fn.dataTableExt.oPagination,{bootstrap:{fnInit:function(a,t,l){var i=a.oLanguage.oPaginate,n=function(e){e.preventDefault(),a.oApi._fnPageChange(a,e.data.action)&&l(a)};e(t).append('<ul class="pagination no-margin"><li class="prev disabled"><a href="#">'+i.sPrevious+'</a></li><li class="next disabled"><a href="#">'+i.sNext+"</a></li></ul>");var o=e("a",t);e(o[0]).bind("click.DT",{action:"previous"},n),e(o[1]).bind("click.DT",{action:"next"},n)},fnUpdate:function(a,t){var l,i,n,o,s,r,d=5,c=a.oInstance.fnPagingInfo(),g=a.aanFeatures.p,p=Math.floor(d/2);for(c.iTotalPages<d?(s=1,r=c.iTotalPages):c.iPage<=p?(s=1,r=d):c.iPage>=c.iTotalPages-p?(s=c.iTotalPages-d+1,r=c.iTotalPages):(s=c.iPage-p+1,r=s+d-1),l=0,i=g.length;l<i;l++){for(e("li:gt(0)",g[l]).filter(":not(:last)").remove(),n=s;n<=r;n++)o=n==c.iPage+1?'class="active"':"",e("<li "+o+'><a href="#">'+n+"</a></li>").insertBefore(e("li:last",g[l])[0]).bind("click",function(l){l.preventDefault(),a._iDisplayStart=(parseInt(e("a",this).text(),10)-1)*c.iLength,t(a)});0===c.iPage?e("li:first",g[l]).addClass("disabled"):e("li:first",g[l]).removeClass("disabled"),c.iPage===c.iTotalPages-1||0===c.iTotalPages?e("li:last",g[l]).addClass("disabled"):e("li:last",g[l]).removeClass("disabled")}}}});var a=[];e("#datatable-table").find("thead th").each(function(){e(this).hasClass("no-sort")?a.push({bSortable:!1}):a.push(null)}),e("#datatable-table").dataTable({sDom:"<'row'<'col-md-6 hidden-xs'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",oLanguage:{sLengthMenu:"_MENU_",sInfo:"Showing <strong>_START_ to _END_</strong> of _TOTAL_ entries"},oClasses:{sFilter:"pull-right",sFilterInput:"form-control input-rounded ml-sm"},aoColumns:a}),e(".dataTables_length select").selectpicker({width:"auto"})}function l(){e(".widget").widgster(),a(),t()}l(),MedlibApp.onPageLoad(l)}(jQuery);