(function(){
	'use strict';	
	
	/**
	* pagination filter
	* @param {Object} pagingObj - paging object
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview - collection dataview
	* @return {Array.<jQuery.fn.beList.DataItemModel>}
	*/
	jQuery.fn.beList.FiltersService.pagerFilter = function(pagingObj, dataview){
		return dataview.slice(pagingObj.start, pagingObj.end);
	};
	
})();	