/**
* DTO Mapper Service
*/
;(function(){
	'use strict';

    /**
     * DTO Mapper Service
     */
    jQuery.fn.beList.DTOMapperService = jQuery.fn.beList.DTOMapperService || {};

	/** 
	* DTO Mapper Service for filters
	* @type {Object}
	*/
	jQuery.fn.beList.DTOMapperService.filters = {};
	
	// FILTERS
	
	/**
	* text filter dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview
	* @return {Array.<jQuery.fn.beList.DataItemModel>} dataview
	*/
	jQuery.fn.beList.DTOMapperService.filters.TextFilter = function(status, dataview){
		
		var path = new jQuery.fn.beList.PathModel(status.data.path, null);

		return jQuery.fn.beList.FiltersService.textFilter(
			status.data.value
			,path
			,dataview
			,status.data.ignore
			,status.data.mode
            ,status.data.not
            ,status.data.and
            ,status.data.or
		);
	};
	
	/**
	* path filter dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview
	* @return {Array.<jQuery.fn.beList.DataItemModel>} dataview
	*/
	jQuery.fn.beList.DTOMapperService.filters.path = function(status, dataview){
		
		var path = new jQuery.fn.beList.PathModel(status.data.path, null);
		
		return jQuery.fn.beList.FiltersService.pathFilter(
			path
			,dataview
		);
	};
	
	/**
	* inverted path filter dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview
	* @return {Array.<jQuery.fn.beList.DataItemModel>} dataview
	
	jQuery.fn.beList.DTOMapperService.filters.inverted_path = function(status, dataview){
				
		return jQuery.fn.beList.FiltersService.invertedPathFilter(
			status.data.checked_checkboxes
			,dataview
		);
	};
	*/
	
	/**
	* range filter dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview
	* @return {Array.<jQuery.fn.beList.DataItemModel>} dataview
	*/
	jQuery.fn.beList.DTOMapperService.filters.range = function(status, dataview){
				
		var path = new jQuery.fn.beList.PathModel(status.data.path, null);
		
		return jQuery.fn.beList.FiltersService.rangeFilter(
			path
			,dataview
			,status.data.min
			,status.data.max
			,status.data.prev
			,status.data.next
		);
	};
	
	/**
	* date filter dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview
	* @return {Array.<jQuery.fn.beList.DataItemModel>} dataview
	*/
	jQuery.fn.beList.DTOMapperService.filters.date = function(status, dataview){
				
		var path = new jQuery.fn.beList.PathModel(status.data.path, null);
		
		return jQuery.fn.beList.FiltersService.dateFilter(
			status.data['year']
			,status.data['month']
			,status.data['day']
			,path
			,dataview
			,status.data['format']
		);
	};
	
	/**
	* date range filter dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview
	* @return {Array.<jQuery.fn.beList.DataItemModel>} dataview
	*/
	jQuery.fn.beList.DTOMapperService.filters.dateRange = function(status, dataview){
				
		var path = new jQuery.fn.beList.PathModel(status.data.path, null);
		
		return jQuery.fn.beList.FiltersService.dateRangeFilter(
			path
			,dataview
			,status.data['format']
			,status.data['prev_year']
			,status.data['prev_month']
			,status.data['prev_day']
			,status.data['next_year']
			,status.data['next_month']
			,status.data['next_day']
		);
	};
	
	/**
	* path group filter dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview
	* @return {Array.<jQuery.fn.beList.DataItemModel>} dataview
	*/
	jQuery.fn.beList.DTOMapperService.filters.pathGroup = function(status, dataview){
					
		return jQuery.fn.beList.FiltersService.pathGroupFilter(
			status.data.pathGroup
			,dataview
		);
	};

	/**
	* text group filter dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview
	* @return {Array.<jQuery.fn.beList.DataItemModel>} dataview
	*/
	jQuery.fn.beList.DTOMapperService.filters.textGroup = function(status, dataview){
						
		return jQuery.fn.beList.FiltersService.textGroupFilter(
			status.data['textGroup']
			,status.data['logic']
			,status.data['path']
			,status.data['ignoreRegex']
			,dataview
			,status.data['mode']
		);
	};

	/**
	* text filter path group dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview
	* @return {Array.<jQuery.fn.beList.DataItemModel>} dataview
	*/
	jQuery.fn.beList.DTOMapperService.filters.textFilterPathGroup = function(status, dataview){
					
		return jQuery.fn.beList.FiltersService.textFilterPathGroup(
			status.data['textAndPathsGroup']
			,status.data['ignoreRegex']
			,dataview
			,status.data['mode']
		);
	};

	// SORTING
	
	/** 
	* DTO Mapper Service for sort
	* @type {Object}
	*/
	jQuery.fn.beList.DTOMapperService.sort = {};
	
	/**
	* text sort dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {jQuery.fn.beList.DataItemModel} dataitem1
	* @param {jQuery.fn.beList.DataItemModel} dataitem2
	* @return {number}
	*/
	jQuery.fn.beList.DTOMapperService.sort.text = function(status, dataitem1, dataitem2){
		
		var path = new jQuery.fn.beList.PathModel(status.data.path, status.data.type);
						
		return jQuery.fn.beList.SortService.textHelper(
			dataitem1
			,dataitem2
			,status.data.order
			,path
			,status.data.ignore || ''
		);
	};
	
	/**
	* number sort dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {jQuery.fn.beList.DataItemModel} dataitem1
	* @param {jQuery.fn.beList.DataItemModel} dataitem2
	* @return {number}
	*/
	jQuery.fn.beList.DTOMapperService.sort.number = function(status, dataitem1, dataitem2){
		
		var path = new jQuery.fn.beList.PathModel(status.data.path, status.data.type);
						
		return jQuery.fn.beList.SortService.numbersHelper(dataitem1, dataitem2, status.data.order, path);
	};
	
	/**
	* datetime sort dto mapper
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {jQuery.fn.beList.DataItemModel} dataitem1
	* @param {jQuery.fn.beList.DataItemModel} dataitem2
	* @return {number}
	*/
	jQuery.fn.beList.DTOMapperService.sort.datetime = function(status, dataitem1, dataitem2){
		
		var path = new jQuery.fn.beList.PathModel(status.data.path, status.data.type);
						
		return jQuery.fn.beList.SortService.datetimeHelper(
			dataitem1
			,dataitem2
			,status.data.order
			,path
			,status.data.dateTimeFormat || ''
		);
	};
})();

