(function(){//+
	'use strict';		
	
	/**
	* set pager arrows visibility
	* @param {Object} context
	* @param {Object} pagingObj - paging status object
	*/
	var setArrows = function(context, pagingObj){
		
		//set prev and first arrows visibility
		if(pagingObj.currentPage === 0){
			context.$beListFirst.addClass('disabled');
			context.$beListPrev.addClass('disabled');	
		}
		else{
			context.$beListFirst.removeClass('disabled');
			context.$beListPrev.removeClass('disabled');	
		}
		
		//set last and next arrows visibility
		if(pagingObj.currentPage == pagingObj.pagesNumber - 1){
			context.$beListNext.addClass('disabled');
			context.$beListLast.addClass('disabled');
		}
		else{
			context.$beListNext.removeClass('disabled');
			context.$beListLast.removeClass('disabled');
		}	
	};
	
	/**
	* update pagination buttons
	* @param {Object} context
	* @param {number} start
	* @param {number} end
	* @param {number} current
	*/
	var updateButtons = function(context, start, end, current){
		
		var html = ''
			,temp;
		
		//remove old buttons		
		context.$control.find('[data-type="page"]').remove();
				
		for(var i=start; i<end; i++){
			
			html += '<li data-type="page" ';
			
			if(i === current){
				html += ' class="be-list-current active" data-active="true" ';
			}
			
			temp = i + 1;
			html += ' data-number="' + i + '" ';			
			html += '><a href="#">' + temp + '</a></li>';	
		}	
		
		//append new buttons..
		context.$beListPrev.after(html);
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
			,range;
		
		//init pagination range		
		range = Number(context.$control.attr('data-range')) || context.options.range;
			
		diff = Math.floor(pagingObj.currentPage / range);
		start = range*diff;
		end = range*(diff + 1);
		
		if(end > pagingObj.pagesNumber){
			end = pagingObj.pagesNumber;
		}
		
		//update pagination buttons
		updateButtons(context, start, end, pagingObj.currentPage);
	};
	
	/**
	* build google like pagination
	* @param {Object} context
	* @param {Object} pagingObj - paging status object
	*/
	var buildGoogleLikePagination = function(context, pagingObj){
		
		var range
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
		
		//update pagination buttons
		updateButtons(context, start, end, pagingObj.currentPage);
	};
	
	/**
	* build pager html for the given control and paging object (from event)
	* @param {Object} context
	* @param {Object} pagingObj - paging status object
	*/
	var build = function(context, pagingObj){		
					
		if(pagingObj.currentPage >= 0 && pagingObj.currentPage < pagingObj.pagesNumber){
			
			//hidden class id added if pagination has some strange error :)
			context.$control.show(); //removeClass('be-list-hidden');
			
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
			context.$control.hide(); //addClass('be-list-hidden');
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
			,nextArrow
			,firstArrow
			,lastArrow
			,html;
		
		prevArrow = context.$control.attr('data-prev') || context.options.prevArrow;
		nextArrow = context.$control.attr('data-next') || context.options.nextArrow;
		firstArrow = context.$control.attr('data-first') || context.options.firstArrow;
		lastArrow = context.$control.attr('data-last') || context.options.lastArrow;
			
		html = '';
		html += '<li class="be-list-first" data-number="0" data-type="first"><a href="#"><span aria-hidden="true">' + firstArrow + '</span><span class="sr-only">First</span></a></li>';
		html += '<li class="be-list-prev" data-type="prev"><a href="#"><span aria-hidden="true">' + prevArrow + '</span><span class="sr-only">Previous</span></a></li>';
		html += '<li class="be-list-next" data-type="next"><a href="#"><span aria-hidden="true">' + nextArrow + '</span><span class="sr-only">Next</span></a></li>';
		html += '<li class="be-list-last" data-type="last"><a href="#"><span aria-hidden="true">' + lastArrow + '</span><span class="sr-only">Last</span></a></li>';
		
		//set arrows html
		context.$control.append(html);
		
		//init vars
		context.$beListFirst = context.$control.find('[data-type="first"]');
		context.$beListPrev = context.$control.find('[data-type="prev"]');
		context.$beListNext = context.$control.find('[data-type="next"]');
		context.$beListLast = context.$control.find('[data-type="last"]');
	};
	
	/**
	* init control events
	* @param {Object} context
	*/
	var initEvents = function(context){
		
		/**
		* disable links
		*/
		context.$control.on('click', 'a', function(e){
			e.preventDefault();
		});
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
			
			,$beListFirst: null
			,$beListPrev: null
			,$beListNext: null
			,$beListLast: null
			
			,mode: $control.attr('data-mode')
		};
		
		//render control
		render(context);
		
		//init events
		initEvents(context);

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
	* Bootstrap Pagination View
	* @constructor
	* @param {jQueryObject} $control
	* @param {Object} options
	*/
	jQuery.fn.beList.controls.BootstrapPaginationView = function($control, options){
		return new Init($control, options);
	};	
})();

