(function(){
	'use strict';		
	
	/** 
	* Checkbox Group Filter Model
	* @constructor
	* @param {Array.<string>} pathGroup - list of paths
	*/
	jQuery.fn.beList.controls.CheckboxGroupFilterDTO = function(pathGroup){
		
		return {
			pathGroup: pathGroup
			,filterType: 'pathGroup'
		};
	};	
		
})();

