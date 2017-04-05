(function(){//+
	'use strict';		
	
	/**
	* set pager arrows visibility
	* @param {Object} context
	* @param {Object} pagingObj - paging status object
	*/
	var setArrows = function(context, pagingObj){
		
		//set pagingprev visibility
		if(pagingObj.currentPage === 0){
			context.$pagingprev.addClass('be-list-hidden');
		}
		else{
			context.$pagingprev.removeClass('be-list-hidden');
		}
		
		//set pagingnext visibility
		if(pagingObj.currentPage == pagingObj.pagesNumber - 1){ 
			context.$pagingnext.addClass('be-list-hidden');
		}
		else{
			context.$pagingnext.removeClass('be-list-hidden');
		}	
	};
	
	/**
	 * draw the pagination
     * @param {Object} context
	 * @param {number} start
	 * @param {number} end
	 * @param {number} current
	 * @return {string} html
	 */
	var getHTML = function(context, start, end, current){
		
		var html = ''
			,temp
            ,title = context.$control.attr('data-number-title') || context.options.numberArrowTitle;
		
		html +=	'<div class="be-list-pagesbox" data-type="pagesbox">';
		for(var i=start; i<end; i++){
			
			html += '<button type="button" data-type="page" ';						
			if(i === current){
				html += ' class="be-list-current" data-active="true" ';
			}
			temp = i + 1;
			html += ' data-number="' + i + '" ';
            html += ' title="' + (title.replace('{number}', temp)) + '" ';
			html += '>' + temp + '</button> ';
		}
		html +=	'</div>';
		
		return html;		
	};
	
	/**
	* build standard pagination
	* @param {Object} context
	* @param {Object} pagingObj - paging status object
	*/
	var buildStandardPagination = function(context, pagingObj){
		
		var start
			,end
			,diff
			,html
			,range;
		
		//init pagination range		
		range = Number(context.$control.attr('data-range')) || context.options.range;
			
		diff = Math.floor(pagingObj.currentPage / range);
		start = range*diff;
		end = range*(diff + 1);
		
		if(end > pagingObj.pagesNumber){
			end = pagingObj.pagesNumber;
		}
		
		html = getHTML(context, start, end, pagingObj.currentPage);
		
		//set html
		context.$pagingmid.html(html);
	};
	
	/**
	* build google like pagination
	* @param {Object} context
	* @param {Object} pagingObj - paging status object
	*/
	var buildGoogleLikePagination = function(context, pagingObj){
		
		var html = ''
			,range
			,leftRange
			,start
			,end;
		
		//init pagination range		
		range = Number(context.$control.attr('data-range')) || context.options.range;
		
		//init left range
		leftRange = Math.floor((range - 1)/2);
		
		//get start value
		start = pagingObj.currentPage - leftRange;
		
		if(start < 0){
			start = 0;
		}
		
		//get end value
		end = start + range;
		
		if(end > pagingObj.pagesNumber){
			end = pagingObj.pagesNumber;
		}
		
		html = getHTML(context, start, end, pagingObj.currentPage);
		
		//set html
		context.$pagingmid.html(html);		
	};
	
	/**
	* build pager html for the given control and paging object (from event)
	* @param {Object} context
	* @param {Object} pagingObj - paging status object
	*/
	var build = function(context, pagingObj){		
					
		if(pagingObj.currentPage >= 0 && pagingObj.currentPage < pagingObj.pagesNumber){
			
			//hidden class id added if pagination has some strange error :)
			context.$control.removeClass('be-list-hidden');
			
			switch(context.mode){
				
				case 'google-like':{
					
					//build google like pagination
					buildGoogleLikePagination(context, pagingObj);
				}	
				break;
				
				default:{
				
					//build standard pagination
					buildStandardPagination(context, pagingObj);
				}
				break;
			}
			
			//set data attributes
			context.$beListPrev.attr('data-number', pagingObj.prevPage).removeClass('be-list-current');
			context.$beListNext.attr('data-number', pagingObj.nextPage).removeClass('be-list-current');
			context.$beListLast.attr('data-number', pagingObj.pagesNumber - 1).removeClass('be-list-current');
			
			if(pagingObj.pagesNumber <= 1){
				context.$control.addClass('be-list-one-page');
			}
			else{
				context.$control.removeClass('be-list-one-page');
			}
		}
		else{
			context.$control.addClass('be-list-hidden');
		}
		
		//update qrrows visibility
		setArrows(context, pagingObj);
	};
	
	/**
	* Render control html
	* @param {Object} context
	*/
	var render = function(context){
		
		var prevArrow
            ,prevArrowTitle
			,nextArrow
            ,nextArrowTitle
			,firstArrow
            ,firstArrowTitle
			,lastArrow
            ,lastArrowTitle;

		prevArrow = context.$control.attr('data-prev') || context.options.prevArrow;
        prevArrowTitle = context.$control.attr('data-prev-title') || context.options.prevArrowTitle;
		nextArrow = context.$control.attr('data-next') || context.options.nextArrow;
        nextArrowTitle = context.$control.attr('data-next-title') || context.options.nextArrowTitle;
		firstArrow = context.$control.attr('data-first') || context.options.firstArrow;
        firstArrowTitle = context.$control.attr('data-first-title') || context.options.firstArrowTitle;
		lastArrow = context.$control.attr('data-last') || context.options.lastArrow;
        lastArrowTitle = context.$control.attr('data-last-title') || context.options.lastArrowTitle;
		
		//set containers html		
		context.$control.html('<div class="be-list-pagingprev" data-type="pagingprev"></div><div class="be-list-pagingmid" data-type="pagingmid"></div><div class="be-list-pagingnext" data-type="pagingnext"></div>');
		
		//init vars
		context.$pagingprev = context.$control.find('[data-type="pagingprev"]');		
		context.$pagingmid = context.$control.find('[data-type="pagingmid"]');
		context.$pagingnext = context.$control.find('[data-type="pagingnext"]');
			
		//set arrows html
		context.$pagingprev.html('<button type="button" class="be-list-first" data-number="0" data-type="first" title="' + firstArrowTitle + '">' + firstArrow + '</button><button type="button" class="be-list-prev" data-type="prev" title="' + prevArrowTitle + '">' + prevArrow + '</button>');
		context.$pagingnext.html('<button type="button" class="be-list-next" data-type="next" title="' + nextArrowTitle + '">' + nextArrow + '</button><button type="button" class="be-list-last" data-type="last" title="' + lastArrowTitle + '">' + lastArrow + '</button>');
		
		//init vars
		context.$beListFirst = context.$pagingprev.find('[data-type="first"]');
		context.$beListPrev = context.$pagingprev.find('[data-type="prev"]');
		context.$beListNext = context.$pagingnext.find('[data-type="next"]');
		context.$beListLast = context.$pagingnext.find('[data-type="last"]');
	};
	
	/** 
	* Pagination View
	* @constructor
	* @param {jQueryObject} $control
	* @param {Object} options
	*/
	var Init = function($control, options){
			
		var context = {
			$control: $control
			,options: options
			
			,$pagingprev: null
			,$pagingmid: null
			,$pagingnext: null
			,$beListFirst: null
			,$beListPrev: null
			,$beListNext: null
			,$beListLast: null
			
			,mode: $control.attr('data-mode')
		};
		
		//render control
		render(context);

		return jQuery.extend(this, context);
	};
	
	/**
	* build pager html for the given control and paging object (from event)
	* @param {Object} pagingObj - paging status object
	*/
	Init.prototype.build = function(pagingObj){		
		build(this, pagingObj);
	};
	
	/** 
	* Pagination View
	* @constructor
	* @param {jQueryObject} $control
	* @param {Object} options
	*/
	jQuery.fn.beList.controls.PaginationView = function($control, options){
		return new Init($control, options);
	};	
	
	/**
	* static control registration
	*/
	jQuery.fn.beList.controlTypes['pagination'] = {
		className: 'Pagination'
		,options: {
		
			//paging
			range: 7
			,jumpToStart: false
			
			//arrows
			,prevArrow: '&lsaquo;'
			,nextArrow: '&rsaquo;'
			,firstArrow: '&laquo;'
			,lastArrow: '&raquo;'
            ,prevArrowTitle: ''
            ,nextArrowTitle: ''
            ,firstArrowTitle: ''
            ,lastArrowTitle: ''
            ,numberArrowTitle: ''
		}
	};		
})();

