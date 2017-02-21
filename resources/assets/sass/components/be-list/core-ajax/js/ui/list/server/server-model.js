(function(){
	'use strict';		
		
	/**
	* data item viewmodel - used in server html list view/controller
	* @constructor
	* @param {jQuery.fn.beList.DomainDataItemServerModel|null} dataItem
	* @param {Array.<jQuery.fn.beList.StatusDTO>|null} statuses
	* @param {Object} scopeObserver - scope observer
	*/
	jQuery.fn.beList.DataItemServerModel = function(dataItem, statuses, scopeObserver){
		
		this.dataItem = dataItem;
		this.statuses = statuses;
		this.scopeObserver = scopeObserver;
	};
	
	/**
	* set data item
	* @param {jQuery.fn.beList.DomainDataItemServerModel|null} dataItem
	* @param {Array.<jQuery.fn.beList.StatusDTO>|null} statuses
	*/
	jQuery.fn.beList.DataItemServerModel.prototype.set = function(dataItem, statuses){
		
		//update properties
		this.dataItem = dataItem;
		this.statuses = statuses;

		//trigger change events
		this.scopeObserver.trigger(this.scopeObserver.events.modelChanged, [dataItem, statuses]);
	};
})();

