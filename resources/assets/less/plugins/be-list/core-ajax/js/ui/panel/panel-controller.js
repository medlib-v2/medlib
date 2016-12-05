;(function(){
	'use strict';

	// ----------------------- STICKY -----------------------------------
	
	/**
	* set sticky position
	* @param {jQueryObject} $stickyEl - sticky element on the panel
	*/
	var setStickyPosition = function($stickyEl){
		
		var scrollTop = jQuery(window).scrollTop()
			,top;
		
		//get top value
		top = Number($stickyEl.data('top'));
		
		if(!isNaN(top)){
		
			if (scrollTop > top){ 
				$stickyEl.addClass('be-list-sticky');
			}
			else{
				$stickyEl.removeClass('be-list-sticky');
			}
		}
	};
	
	/**
	* init sticky elements
	* @param {jQueryObject} $sticky - sticky elements on the panel
	*/
	var initSticky = function(context, $sticky){
			
		$sticky.each(function(){
			
			var $stickyEl = jQuery(this)
				,top = $stickyEl.offset().top;
			
			//save top value
			$stickyEl.data('top', top);
			
			//set position first time
			setStickyPosition($stickyEl);
		});
		
		jQuery(window).scroll(function(){
			
			$sticky.each(function(){
							
				//set position first time
				setStickyPosition( jQuery(this));
			});
		});
	};
	
	// ----------------------- DEEP LINKS -------------------------------
	
	/**
	* set panel controls statuses by their deep links
	* @param {Object} context
	*/
	var setStatusesByDeepLink = function(context){
		
		var params
			,isStorageEnabled = false
			,storageStatuses = [];
		
		//set deep links
		params = jQuery.fn.beList.DeepLinksService.getUrlParams(context.options);

		if(params.length <= 0){

			//try set panel controls statuses from storage
			setStatusesFromStorage(context);
		}
		else{
			context.controls.setDeepLinks(params, context.observer);
		}
	};

	/**
	* get deep links url according to panel controls
	* @param {Object} context
	* @return {string}
	*/
	var getDeepLinksURLPerControls = function(context){

		return context.controls.getDeepLinksUrl(context.options.delimiter1);
	};

	// ----------------------- STORAGE ----------------------------------

	/**
	* set panel controls statuses from storage
	* @param {Object} context
	*/
	var setStatusesFromStorage = function(context){

		var storageStatuses = []
			,isStorageEnabled;

		isStorageEnabled = (context.options.storage === 'cookies') || ((context.options.storage === 'localstorage') && jQuery.fn.beList.LocalStorageService.supported());

		//check storage
		if(isStorageEnabled){

			if(context.options.storage === 'cookies'){

				//restore statuses from storage
				storageStatuses = jQuery.fn.beList.CookiesService.restoreCookies(context.options.storageName);
			}

			if((context.options.storage === 'localstorage') && jQuery.fn.beList.LocalStorageService.supported()){

				//restore statuses from storage
				storageStatuses = jQuery.fn.beList.LocalStorageService.restore(context.options.storageName);
			}

			//send redraw event
			if(storageStatuses.length > 0){
				restoreControlsByStatuses(context, storageStatuses);
			}
			else{
				unknownStatusesChanged(context, true);
			}
		}
		else{
			unknownStatusesChanged(context, true);
		}
	};

	// ----------------------- MAIN LOGIC -------------------------------

	/**
	* set control statuses
	* @param {Object} context
	* @param {Array.<jQuery.fn.beList.StatusDTO>} statusesArray
	*/
	var setStatuses = function(context, statusesArray){

		var NOT_RESTORED_FROM_COOKIES = false;

        //update history
        context.history.addStatuses(statusesArray);

		//set statuses
		context.controls.setStatuses(statusesArray, NOT_RESTORED_FROM_COOKIES);

		//save statuses in history
		context.history.addList(statusesArray);
	};

	/**
	 * unknown status / statuses changed
	 * @param {Object} context
	 * @param {boolean} isDefault - should it render events by their default statuses
	 */
	var unknownStatusesChanged = function(context, isDefault){

		var statuses;

		//get current statuses
		statuses = context.controls.getStatuses(isDefault);

        if(statuses.length > 0){

            //trigger knownStatusesChanged event
            context.observer.trigger(context.observer.events.knownStatusesChanged, [statuses]);
        }
	};

	/**
	 * restore controls from storage by statuses
	 * @param {Object} context
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} statusesArray
	 */
	var restoreControlsByStatuses = function(context, statusesArray){

		var RESTORED_FROM_COOKIES = true
			,statusesInStorage = [];

		for(var i=0; i<statusesArray.length; i++){

			if(statusesArray[i].inStorage){
				statusesInStorage.push(statusesArray[i]);
			}
		}

		if(statusesInStorage.length > 0){

			//apply statusesInStorage on controls
			context.controls.setStatuses(statusesInStorage, RESTORED_FROM_COOKIES);

			context.observer.trigger(context.observer.events.knownStatusesChanged, [statusesInStorage]);
		}
	};

	/**
	 * get all statuses and merge them with the given statuses, then send build statuses event
	 * @param {Object} context
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} statusesToMerge
     * @return {Array.<jQuery.fn.beList.StatusDTO>}
	 */
	var mergeStatuses = function(context, statusesToMerge){

		var IS_DEFAULT = false;
		return context.controls.merge(IS_DEFAULT, statusesToMerge);
	};

	/**
	 * init controls and paths
	 * @param {Object} context
	 */
	var initControlsAndPaths = function(context){

		var $panel
			,$controls
			,paths = [];

		//init panel controls
		$panel = context.$root.find(context.options.panelPath);
		$controls = $panel.find('[data-control-type]');

		context.controls = new jQuery.fn.beList.ControlsCollection();

        context.controls.addList($controls, context.history, context.$root, context.options, context.observer);

		//get panel paths
		context.paths = context.controls.getPaths();
	};

	/**
	 * statuses are changed by deep link
	 * @param {Object} context
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} newStatuses
	 * @param {Array.<Object>} params - array of params {controlName: '...', propName: '...', propValue: '...'}
	 */
	var statusesChangedByDeepLinks = function(context, newStatuses, params){

		if(context.controls){
			context.controls.statusesChangedByDeepLinks(params);
		}
	};

    /**
     * add new control to the panel (used to add dynamic controls)
     * @param {Object} context
     * @param {jQueryObject} $control
     */
    var addControl = function(context, $control){

        //add current control
        context.controls.add($control, context.history, context.$root, context.options, context.observer);

        //update paths list
        context.paths = context.controls.getPaths();
    };

	// ----------------------- ENTRY POINT / API -------------------------------

	/**
	 * Panel constructor
	 * @param {jQueryObject} $root - beList jquery element
	 * @param {Object} options - beList options
	 * @param {jQuery.fn.beList.History} history
	 * @param {Object} observer
	 * @constructor
	 */
	jQuery.fn.beList.PanelController = function($root, options, history, observer){

		this.options = options;	//user options
		this.$root = $root; //beList container
		this.history = history;
		this.observer = observer;

		this.$sticky = null;
		this.paths = null; //all paths
		this.controls = null;

		//init controls and paths
		initControlsAndPaths(this);

		//find sticky elements
		this.$sticky = $root.find('[data-sticky="true"]');

		//init sticky
		if(this.$sticky.length > 0){
			initSticky(this, this.$sticky);
		}
	};

    /**
     * add new control to the panel (used to add dynamic controls)
     * @param {jQueryObject} $control
     */
    jQuery.fn.beList.PanelController.prototype.addControl = function($control){
        addControl(this, $control);
    };

	/**
	 * try restore panel state from query string
	 */
	jQuery.fn.beList.PanelController.prototype.setStatusesByDeepLink = function(){
		setStatusesByDeepLink(this);
	};

	/**
	 * try set panel controls statuses from storage
	 */
	jQuery.fn.beList.PanelController.prototype.setStatusesFromStorage = function(){
		setStatusesFromStorage(this);
	};

	/**
	 * set control statuses
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} statuses
	 */
	jQuery.fn.beList.PanelController.prototype.setStatuses = function(statuses){
		setStatuses(this, statuses);
	};

	/**
	 * get panel controls statuses
	 * @param {boolean} isDefault - should it render events by their default statuses
	 * @return {Array.<jQuery.fn.beList.StatusDTO>} statuses
	 */
	jQuery.fn.beList.PanelController.prototype.getStatuses = function(isDefault){
		return this.controls.getStatuses(isDefault);
	};

	/**
	 * merge give status with the other controls statuses
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} statuses
     * @return {Array.<jQuery.fn.beList.StatusDTO>}
	 */
	jQuery.fn.beList.PanelController.prototype.mergeStatuses = function(statuses){
		return mergeStatuses(this, statuses);
	};

	/**
	 * statuses are changed by deep links
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} newStatuses
	 * @param {Array.<Object>} params - array of params {controlName: '...', propName: '...', propValue: '...'}
	 */
	jQuery.fn.beList.PanelController.prototype.statusesChangedByDeepLinks = function(newStatuses, params){
		statusesChangedByDeepLinks(this, newStatuses, params);
	};

	/**
	 * get deep links url according to panel controls
	 * @return {string}
	 */
	jQuery.fn.beList.PanelController.prototype.getDeepLinksURLPerControls = function(){
		return getDeepLinksURLPerControls(this);
	};
})();