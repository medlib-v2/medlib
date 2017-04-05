;(function(){
	'use strict';
	
	/**
	 * render html
	 * @param {Object} context
	 * @param {jQuery.fn.beList.Dataitems} collection
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} statuses
     * @param {jQuery.fn.beList.StatusDTO} lastStatus
     * @return {jQueryObject} $dataview
	 */
	var render = function(context, collection, statuses, lastStatus){
		
		var $dataitems = collection.dataitemsToJqueryObject()
			,$dataview = collection.dataviewToJqueryObject()
			,lastStatusNotInAnimation = false
			,options
			,optionsZeroDuration = jQuery.extend(true, {}, context.options, {
				duration: 0
			});
		
		//no results found
		if($dataitems.length <=0 || $dataview.length <= 0){
		
			context.$noResults.removeClass('beList-hidden');
			context.$itemsBox.addClass('beList-hidden');
			
			//redraw callback
			if(jQuery.isFunction(context.redrawCallback)){
				context.redrawCallback(collection, $dataview, statuses);
			}
		}
		else{
			context.$noResults.addClass('be-list-hidden');
			context.$itemsBox.removeClass('be-list-hidden');
			
			if(context.effect && jQuery.fn.beList.animation){

                if(lastStatus && !(lastStatus.inAnimation)){
                    lastStatusNotInAnimation = true;
                }
			
				if(lastStatusNotInAnimation){
					options = optionsZeroDuration;
				}
				else{
					options = context.options;					
				}
				
				//animate items
				jQuery.fn.beList.animation.drawItems(
					options //user options
					,context.$itemsBox //scene
					,$dataitems
					,$dataview //new items
					,context.effect //animation effect
					,function(){
												
						//redraw callback
						if(jQuery.isFunction(context.redrawCallback)){
							context.redrawCallback(collection, $dataview, statuses);
						}
					}
					,context.observer
				);				
			}
			else{			
				$dataitems.detach();
				context.$itemsBox.append($dataview);
								
				//redraw callback
				if(jQuery.isFunction(context.redrawCallback)){
					context.redrawCallback(collection, $dataview, statuses);
				}
			}
		}

        return $dataview;
	};	
			
	/**
	 * DOM View
	 * @constructor
	 * @param {jQueryObject} $root - beList jquery element
	 * @param {Object} options - beList options
	 * @param {Object} observer
	 */
	jQuery.fn.beList.DOMView = function($root
                                         ,options
                                         ,observer
                                         ,itemsBoxPath
                                         ,noResultsPath
                                         ,redrawCallback
                                         ,effect){
	
		this.options = options;	//user options	
		this.$root = $root; //beList container
		this.observer = observer;
		this.redrawCallback = redrawCallback;
        this.effect = effect;
		this.$itemsBox = $root.find(itemsBoxPath).eq(0);
		this.$noResults = $root.find(noResultsPath);
	};
	
	/**
	 * render view
	 * @param {jQuery.fn.beList.Dataitems} collection
	 * @param {Array.<jQuery.fn.beList.StatusDTO>} statuses
     * @param {jQuery.fn.beList.StatusDTO} lastStatus
     * @return {jQueryObject}
	 */
	jQuery.fn.beList.DOMView.prototype.render = function(collection, statuses, lastStatus){
		return render(this, collection, statuses, lastStatus);
	};
})();