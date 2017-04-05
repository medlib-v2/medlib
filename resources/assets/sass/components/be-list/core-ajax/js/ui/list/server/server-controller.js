(function(){
	'use strict';
	
	/**
	 * build statuses
	 * @param {Object} context - beList controller 'this' object
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} statuses
     * @param {jQuery.fn.beList.StatusDTO} lastStatus
	 */
	var renderStatuses = function(context, statuses, lastStatus){
		
		var ajaxDataType = 'html';
		
		//update ajax data type - it could be 'html', 'xml' or 'json'
		if(context.options.dataSource && context.options.dataSource.server && context.options.dataSource.server.ajax){
		
			ajaxDataType = context.options.dataSource.server.ajax.dataType;
			
			if(!ajaxDataType){
				ajaxDataType = 'html';
			}	
		}
					
		//load data from URL
		jQuery.fn.beList.URIService.get(
			statuses
			,context.options
			
			//OK callback
			,function(content, statuses, ajax, response){
				
				var dataitem = new jQuery.fn.beList.DomainDataItemServerModel(content, ajaxDataType, response['responseText']);
									
				//udapte statuses with server data
				setServerData(context, dataitem, statuses);
					
				//update dataitem model
				context.model.set(dataitem, statuses);						
			}
			,function(statuses){
				
				//Error callback
			}
			,function(statuses){
				
				//Always callback
			}
		);			
	};
	
	/**
	 * init list observer (events object)
	 * @param {jQueryObject} $root
	 * @return {Object} observer
	 */
	var initScopeObserver = function($root){
		
		var observer = jQuery({});
		
		observer.$root = $root;
		
		observer.events = {			
			//viewReadyRedraw: 'viewReadyRedraw'
			modelChanged: 'modelChanged'
		};	
		
		return observer;
	};
	
	/**
	 * update statuses with data from server
	 * @param {Object} context
	 * @param {jQuery.fn.beList.DomainDataItemServerModel} dataitem - server data item
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} statuses
	 */
	var setServerData = function(context, dataitem, statuses){
	
		var status
			,pagingStatuses
			,paging
            ,currentPage = 0
            ,itemsPerPage = 0;
		
		//get list of pagination statuses
		pagingStatuses = jQuery.fn.beList.StatusesService.getStatusesByAction('paging', statuses);

        if(pagingStatuses.length > 0){

            for(var i=0; i<pagingStatuses.length; i++){

                //get pagination status
                status = pagingStatuses[i];

                if(status.data){

                    if(jQuery.isNumeric(status.data.currentPage)){

                        //init current page
                        currentPage = status.data.currentPage;
                    }

                    if(jQuery.isNumeric(status.data.number) || status.data.number === 'all'){

                        //init current page
                        itemsPerPage = status.data.number;
                    }
                }
            }

            //create paging object
            paging = new jQuery.fn.beList.PaginationService(currentPage, itemsPerPage, dataitem.count);

            //add paging object to the paging status
            for(var j=0; j<pagingStatuses.length; j++){

                if(pagingStatuses[j].data) {

                    pagingStatuses[j].data.paging = paging;
                }
            }
        }
		
		context.observer.trigger(context.observer.events.statusesAppliedToList, [null, statuses]);
	};
			
	/**
	 * Server Controller
	 * @constructor
	 * @param {jQueryObject} $root - beList root element
	 * @param {Object} options - beList user options
	 * @param {Object} observer
	 * @param {jQuery.fn.beList.History} history
	 * @return {Object}
	 */
	jQuery.fn.beList.ServerController = function($root, options, observer, history){
	
		this.options = options;
		this.observer = observer;
		this.history = history;

		this.scopeObserver = initScopeObserver(null);
		this.$root = $root;		
		this.view = null;
		this.model = null;
		
		//init model
		this.model = new jQuery.fn.beList.DataItemServerModel(null, null, this.scopeObserver);
		
		//init view
		this.view = new jQuery.fn.beList.ServerView($root, options, observer, this.scopeObserver, this.model, this.history);
	};
	
	/**
	 * build statuses
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} statuses
     * @param {jQuery.fn.beList.StatusDTO} lastStatus
	 */
	jQuery.fn.beList.ServerController.prototype.renderStatuses = function(statuses, lastStatus){
		renderStatuses(this, statuses, lastStatus);
	};
})();