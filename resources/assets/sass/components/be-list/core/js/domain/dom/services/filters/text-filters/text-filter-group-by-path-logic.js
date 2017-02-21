;(function(){
	'use strict';	
	
	/**
	* textGroupFilter - filter dataview by text group - used for checkboxes text filter
	* filter group of text values in the given (single) path
	* @param {Array.<string>} textGroup - list of text values
	* @param {Array.<jQuery.fn.beList.DataItemModel>} dataview - collection dataview
    * @param {string} logic - 'or' / 'and'
    * @param {string} dataPath - data-path attribute
    * @param {string} ignoreRegex
	* @param {string} mode: startsWith, endsWith, contains, advanced
	* @return {Array.<jQuery.fn.beList.DataItemModel>}
	*/
	jQuery.fn.beList.FiltersService.textGroupFilter = function(textGroup, logic, dataPath, ignoreRegex, dataview, mode){

        var txtValue
			,dataitem
            ,pathitem
            ,pathItemText
            ,formattedTxt
            ,pathObj
			,resultDataview = []
            ,tempList
            ,txt;

		if(textGroup.length <= 0){
			return dataview;
		}
		else{

            //create path object
            pathObj = new jQuery.fn.beList.PathModel(dataPath, null);

			for(var i=0; i<dataview.length; i++){

				//get dataitem
				dataitem = dataview[i];

                //find value by path
                pathitem = dataitem.findPathitem(pathObj);

                if(pathObj.jqPath === 'default'){

                    //default drop down choice
                    resultDataview.push(dataitem);
                }
                else{
                    //if path is found
				    if(pathitem){

                        //get text from the pathitem
                        pathItemText = jQuery.fn.beList.HelperService.removeCharacters(pathitem.text, ignoreRegex);

                        if(logic === 'or'){

                            for(txt=0; txt<textGroup.length; txt++){

                                //get text value
                                txtValue = textGroup[txt];

                                //remove 'ignore characters' from the text value
                                formattedTxt = jQuery.fn.beList.HelperService.removeCharacters(txtValue, ignoreRegex);

								/*
                                //pathitem text contains text value?
                                if(pathItemText.indexOf(formattedTxt) !== -1){
                                    resultDataview.push(dataitem);
                                    break;
                                }
								*/
								
								//pathitem text contains text value?
								if(jQuery.fn.beList.FiltersService.advancedSearchParse(pathItemText, formattedTxt)){
									resultDataview.push(dataitem);
									break;
								}
                            }
                        }
                        else{  
						
							//logic === 'and'
                            tempList = [];

                            for(txt=0; txt<textGroup.length; txt++){

                                //get text value
                                txtValue = textGroup[txt];

                                 //remove 'ignore characters' from the text value
                                formattedTxt = jQuery.fn.beList.HelperService.removeCharacters(txtValue, ignoreRegex);
								
								//pathitem text contains text value?
								if(jQuery.fn.beList.FiltersService.advancedSearchParse(pathItemText, formattedTxt)){
									tempList.push(formattedTxt);
								}
                            }

                            if(tempList.length === textGroup.length){
                                resultDataview.push(dataitem);
                            }
                        }
                    }
                }
			}
		}

		return resultDataview;
    };
	
})();	
