/**
 * Whether to use pjax page swithing
 * @type {boolean}
 */
window.PJAX_ENABLED = true;
/**
 * Whether to print some log information
 * @type {boolean}
 */
window.DEBUG = true;

/**
 * Plugins configuration options
 */

/**
 * Setting Widgster's body selector to theme specific
 * @type {string}
 */
$.fn.widgster.Constructor.DEFAULTS.bodySelector = '.widget-body';

$(function(){
    
   /**
     * Main app class that handles page switching, async script loading, resize & pageLoad callbacks.
     * Events:
     *   Medlib:loaded - fires after pjax request is made and ALL scripts are trully loaded
     *   Medlib:content-resize - fires when .content changes its size (e.g. switching between static & collapsing
     *     navigation states)
     * @constructor
     */
    var Medlib = function(){
        this.pjaxEnabled = window.PJAX_ENABLED;
        this.debug = window.DEBUG;
        this.navCollapseTimeout = 2500;
    }
});