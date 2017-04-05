;(function(){
	'use strict';		

	/**
	* Get control status
	* @param {Object} context
	* @param {boolean} isDefault - if true, get default (initial) control status; else - get current control status
	* @return {jQuery.fn.beList.StatusDTO}
	*/
	var getStatus = function(context, isDefault){
		
		var $option
			,status = null
			,data;	
					
		//get selected option (if default, get option with data-default=true or first option)
		if(isDefault){
		
			$option = context.$control.find('option[data-default="true"]').eq(0);
			if($option.length <= 0){
				$option =  context.$control.find('option').eq(0);
			}
		}
		else{
			$option = context.$control.find('option:selected');
		}
		
		//init status related data
		data = new jQuery.fn.beList.controls.DropdownSortDTO(
            jQuery.fn.beList.ControlFactory.getProp($option, 'path')
            ,jQuery.fn.beList.ControlFactory.getProp($option, 'type')
            ,jQuery.fn.beList.ControlFactory.getProp($option, 'order')
			,context.params.dateTimeFormat
			,context.params.ignore
		);
		
		//create status
		status = new jQuery.fn.beList.StatusDTO(
			context.name
			,context.action
			,context.type
			,data
			,context.inStorage
			,context.inAnimation
			,context.isAnimateToTop
			,context.inDeepLinking
		);
		
		return status;			
	};
	
	/**
	* Get deep link
	* @param {Object} context
	* @return {string} deep link
	*/
	var getDeepLink = function(context){
		
		var deepLink = ''
			,status
			,isDefault = false;
		
		if(context.inDeepLinking){
		
			//get status
			status = getStatus(context, isDefault);
			
			if(status.data && status.data.path && status.data.type && status.data.order){
			
				//init deep link
				deepLink = context.name + context.options.delimiter0 + 'path' + context.options.delimiter2 + 'type' + context.options.delimiter2 + 'order=' + status.data.path + context.options.delimiter2 + status.data.type + context.options.delimiter2 + status.data.order;
			}
		}
		
		return deepLink;
	};
	
	/**
	* get status by deep link
	* @param {Object} context
	* @param {string} propName - deep link property name
	* @param {string} propValue - deep link property value
	* @return {jQuery.fn.beList.StatusDTO}
	*/
	var getStatusByDeepLink = function(context, propName, propValue){
		
		var isDefault = true
			,status = null
			,sections;
			
		if(context.inDeepLinking){
		
			//get status
			status = getStatus(context, isDefault);
			
			if(status.data){
			
				if(propName === 'path' + context.options.delimiter2 + 'type' + context.options.delimiter2 + 'order'){
					
					sections = propValue.split(context.options.delimiter2);
					
					if(sections.length === 3){
						
						status.data.path = sections[0];
						status.data.type = sections[1];
						status.data.order = sections[2];
					}
				}
			}	
		}
		
		return status;
	};

    /**
     * get path
     * @param {string} path
     * @param {string} type
     * @return {jQuery.fn.beList.PathModel|null}
     */
    var getPath = function(path, type){

        var path = jQuery.trim(path)
            ,type = type || 'text';

        if(path){
            return new jQuery.fn.beList.PathModel(path, type);
        }

        return null;
    };

    /**
     * Get control paths
     * @param {Object} context
     * @param {Array.<jQuery.fn.beList.PathModel>} paths
     */
    var getPaths = function(context, paths){

        context.$control.find('option').each(function(){

            var dataPaths
                ,types
                ,$option = jQuery(this)
                ,path
                ,type;

            dataPaths = jQuery.fn.beList.ControlFactory.getProp($option, 'path');
            types = jQuery.fn.beList.ControlFactory.getProp($option, 'type');

            if(jQuery.isArray(dataPaths)){

                for(var i=0; i<dataPaths.length; i++){

                    if(i < types.length){
                        type = types[i];
                    }
                    else{
                        type = 'text';
                    }

                    path = getPath(dataPaths[i], type);

                    if(path){
                        paths.push(path);
                    }
                }
            }
            else{
                path = getPath(dataPaths, types);

                if(path){
                    paths.push(path);
                }
            }

        });
    };

    /**
	* Set control status
	* @param {Object} context
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {boolean} restoredFromStorage - is status restored from storage
	*/
	var setStatus = function(context, status, restoredFromStorage){
				
		var $option;
		
		//set active class
		if(status.data.path == 'default'){
			$option = context.$control.find('option[data-path="default"]');
		}
		else{

            var path = jQuery.fn.beList.ControlFactory.getPropPath(status.data.path, 'path');
            var type = jQuery.fn.beList.ControlFactory.getPropPath(status.data.type, 'type');
            var order = jQuery.fn.beList.ControlFactory.getPropPath(status.data.order, 'order');

			$option = context.$control.find('option' + path + type + order);
		}
		
		if($option.length > 0){
			$option.get(0).selected = true;				
		}
	};
	
	/**
	* Init control events
	* @param {Object} context
	*/
	var initEvents = function(context){
		
		/**
		* on select change
		*/
		context.$control.on('change', function(){
		
			var status
				,$selectedOption
				,dataPath;
			
			status = getStatus(context, false);
			
			//get selected option
			$selectedOption = jQuery(this).find('option:selected');
			
			if($selectedOption.length > 0){
			
				status.data.path = jQuery.fn.beList.ControlFactory.getProp($selectedOption, 'path');
				status.data.type = jQuery.fn.beList.ControlFactory.getProp($selectedOption, 'type');
				status.data.order = jQuery.fn.beList.ControlFactory.getProp($selectedOption, 'order');
			}
			
			//send status event
			context.observer.trigger(context.observer.events.knownStatusesChanged, [[status]]);
		});
	};
	
	/** 
	* Select Sort Controls
	* @constructor
	* @param {Object} context
	*/
	var Init = function(context){

        context.params = {
            dateTimeFormat: context.$control.attr('data-datetime-format') || ''
            ,ignore: context.$control.attr('data-ignore') || ''
        };

		//init events
		initEvents(context);
		
		return jQuery.extend(this, context);
	};
	
	/**
	* Get control status
	* @param {boolean} isDefault - if true, get default (initial) control status; else - get current control status
	* @return {jQuery.fn.beList.StatusDTO}
	*/
	Init.prototype.getStatus = function(isDefault){
		return getStatus(this, isDefault);
	};
	
	/**
	* Get Deep Link
	* @return {string} deep link
	*/
	Init.prototype.getDeepLink = function(){
		return getDeepLink(this);
	};
	
	/**
	* Get Paths by Deep Link
	* @param {string} propName - deep link property name
	* @param {string} propValue - deep link property value
	* @return {jQuery.fn.beList.StatusDTO}
	*/
	Init.prototype.getStatusByDeepLink = function(propName, propValue){
		return getStatusByDeepLink(this, propName, propValue);
	};
	
	/**
	* Get Paths
	* @param {Array.<jQuery.fn.beList.PathModel>} paths
	*/
	Init.prototype.getPaths = function(paths){
		getPaths(this, paths);
	};
	
	/**
	* Set Status
	* @param {jQuery.fn.beList.StatusDTO} status
	* @param {boolean} restoredFromStorage - is status restored from storage
	*/
	Init.prototype.setStatus = function(status, restoredFromStorage){
		setStatus(this, status, restoredFromStorage);
	};
	
	/** 
	* Select Sort Controls
	* @constructor
	* @param {Object} context
	*/
	jQuery.fn.beList.controls.SortSelect = function(context){
		return new Init(context);
	};	
	
	/**
	* static control registration
	*/
	jQuery.fn.beList.controlTypes['sort-select'] = {
		className: 'SortSelect'
		,options: {}
	};		
})();
