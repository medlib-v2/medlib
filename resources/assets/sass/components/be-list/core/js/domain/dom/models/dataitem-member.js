/**
* DataItem Member
*/
;(function(){
	'use strict';		
	
	/**
	* DataItem Member in the given path
	* @param {jQueryObject} $element
	* @param {jQuery.fn.beList.PathModel} path - path object
	* @constructor 
	*/
	jQuery.fn.beList.DataItemMemberModel = function($element, path){
		
		this.$element = $element;
		this.path = path;
		this.text = $element.text();
		this.html = $element.html();
	};
})();

