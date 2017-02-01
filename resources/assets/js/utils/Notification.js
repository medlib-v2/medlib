/**
 * Big fat Notification object
 * @constructor (not really since its object literal)
 */
class Notification {

    /**
     * The Notification options to over-ride with Notification.options in "add"
     *
     * @type {{position: string, className: string, fadeInSpeed: string, fadeOutSpeed: number, time: number}}
     */
    options;
    /**
     * Private - no touchy the private parts
     */
    customTimer: number;
    itemCount: number;
    isSetup: number;
    templateClose: string;
    templateTitle: string;
    templateItem: string;
    templateWrap: string;

    /**
     * Create a new class instance.
     * @param {object} options
     */
    constructor(options: any) {
        this.customTimer = 0;
        this.itemCount = 0;
        this.isSetup = 0;
        this.templateClose = '<a class="notification-close" href="#" tabindex="1">Close Notification</a>';
        this.templateTitle = '<span class="notification-title">[[title]]</span>';
        this.templateItem = '<div id="notification-item-[[number]]" class="notification-item-wrapper [[item_class]]" style="display:none" role="alert"><div class="notification-top"></div><div class="notification-item">[[close]][[image]]<div class="[[class_name]]">[[title]]<p>[[text]]</p></div><div style="clear:both"></div></div><div class="notification-bottom"></div></div>';
        this.templateWrap = '<div id="notification-notice-wrapper"></div>';

        this.options = _.merge({
            position: '',
            className: '', /** could be set to 'notification-light' to use white notifications **/
            fadeInSpeed: 'medium', /** how fast notifications fade in **/
            fadeOutSpeed: 1000, /** how fast the notices fade out **/
            time: 6000 /** hang on the screen for... **/
        }, options);
    }

    /**
     * Add a notification to the screen
     * @param {Object} params The object that contains all the options for drawing the notification
     * @return {Number} The specific numeric id to that notification
     */
    add(params: any){
        /**
         * Handle straight text
         */
        if(typeof(params) == 'string'){
            params = {text: params};
        }

        /**
         * We might have some issues if we don't have a title or text!
         */
        if(params.text === null){
            throw 'You must supply "text" parameter.';
        }

        /**
         * Check the options and set them once
         */
        if(!this.isSetup){
            this.runSetup();
        }

        /**
         * Basics
         */
        let title = params.title,
            text = params.text,
            image = params.image || '',
            sticky = params.sticky || false,
            itemClass = params.className || this.options.className,
            position = this.options.position,
            timeAlive = params.time || '',
            self = this;

        this.verifyWrapper();

        this.itemCount++;
        let number = this.itemCount,
            tmp = this.templateItem;

        /**
         * Assign callbacks
         */
        $(['before_open', 'after_open', 'before_close', 'after_close']).each(function(i, val){
            self['_' + val + '_' + number] = ($.isFunction(params[val])) ? params[val] : function(){}
        });

        /**
         * Reset
         * @type {number}
         * @private
         */
        this.customTimer = 0;

        /**
         * A custom fade time set
         */
        if(timeAlive){
            this.customTimer = timeAlive;
        }

        let imageStr = (image != '') ? '<img src="' + image + '" class="notification-image" />' : '',
            className = (image != '') ? 'notification-with-image' : 'notification-without-image';

        /**
         * String replacements on the template
         */
        if(title) {
            title = self.replace('[[title]]', title, self.templateTitle);
        } else {
            title = '';
        }

        tmp = self.replace(
            ['[[title]]', '[[text]]', '[[close]]', '[[image]]', '[[number]]', '[[class_name]]', '[[item_class]]'],
            [title, text, self.templateClose, imageStr, self.itemCount, className, itemClass], tmp
        );

        /**
         * If it's false, don't show another gritter message
         */
        if(this['_before_open_' + number]() === false){
            return false;
        }

        $('#notification-notice-wrapper').addClass(position).append(tmp);

        let item = $('#notification-item-' + self.itemCount);

        item.fadeIn(self.fadeInSpeed, function(){
            self['_after_open_' + number]($(this));
        });

        if(!sticky){
            self.setFadeTimer(item, number);
        }

        /**
         * Bind the hover/unhover states
         */
        $(item).bind('mouseenter mouseleave', function(event){
            if(event.type == 'mouseenter'){
                if(!sticky){
                    self.restoreItemIfFading($(this), number);
                }
            }
            else {
                if(!sticky){
                    self.setFadeTimer($(this), number);
                }
            }
            self.hoverState($(this), event.type);
        });

        /**
         * Clicking (X) makes the perdy thing close
         */
        $(item).find('.notification-close').click(function(){
            self.removeSpecific(number, {}, null, true);
            return false;
        });

        return number;
    }

    /**
     * If we don't have any more notifications, get rid of the wrapper using this check
     * @private
     * @param {Number} uniqueId The ID of the element that was just deleted, use it for a callback
     * @param {Object} e The jQuery element that we're going to perform the remove() action on
     * @param {Boolean} manualClose Did we close the Notification dialog with the (X) button
     */
    countRemoveWrapper(uniqueId, e, manualClose){

        /**
         * Remove it then run the callback function
         */
        e.remove();
        this['_after_close_' + uniqueId](e, manualClose);

        /**
         * Check if the wrapper is empty, if it is.. remove the wrapper
         */
        if($('.notification-item-wrapper').length == 0){
            $('#notification-notice-wrapper').remove();
        }
    }

    /**
     * Fade out an element after it's been on the screen for x amount of time
     * @private
     * @param {Object} e The jQuery element to get rid of
     * @param {Number} uniqueId The id of the element to remove
     * @param {Object} params An optional list of params to set fade speeds etc.
     * @param {Boolean} unbindEvents Unbind the mouseenter/mouseleave events if they click (X)
     */
    fade(e, uniqueId, params, unbindEvents){
        let params = params || {},
            fade = (typeof(params.fade) != 'undefined') ? params.fade : true,
            fadeOutSpeed = params.speed || this.fadeOutSpeed,
            manualClose = unbindEvents,
            self = this;

        self['_before_close_' + uniqueId](e, manualClose);

        /**
         * If this is true, then we are coming from clicking the (X)
         */
        if(unbindEvents){
            e.unbind('mouseenter mouseleave');
        }

        /**
         * Fade it out or remove it
         */
        if(fade){
            e.animate({
                opacity: 0
            }, fadeOutSpeed, function(){
                e.animate({ height: 0 }, 300, function(){
                    self.countRemoveWrapper(uniqueId, e, manualClose);
                })
            })
        }
        else {
            self.countRemoveWrapper(uniqueId, e);
        }
    }

    /**
     * Perform actions based on the type of bind (mouseenter, mouseleave)
     * @private
     * @param {Object} e The jQuery element
     * @param {String} type The type of action we're performing: mouseenter or mouseleave
     */
    hoverState(e, type){

        /**
         * Change the border styles and add the (X) close button when you hover
         */
        if(type == 'mouseenter'){
            e.addClass('hover');
            /**
             * Show close button
             */
            e.find('.notification-close').show();

        }
        /**
         * Remove the border styles and hide (X) close button when you mouse out
         */
        else {
            e.removeClass('hover');
            /**
             * Hide close button
             */
            e.find('.notification-close').hide();

        }

    }

    /**
     * Remove a specific notification based on an ID
     * @param {Number} uniqueId The ID used to delete a specific notification
     * @param {Object} params A set of options passed in to determine how to get rid of it
     * @param {Object} e The jQuery element that we're "fading" then removing
     * @param {Boolean} unbindEvents If we clicked on the (X) we set this to true to unbind mouseenter/mouseleave
     */
    removeSpecific(uniqueId, params, e, unbindEvents){

        if(!e){
            let e = $('#notification-item-' + uniqueId);
        }

        /**
         * We set the fourth param to let the fade function know to
         * unbind the "mouseleave" event.  Once you click (X) there's no going back!
         */
        this.fade(e, uniqueId, params || {}, unbindEvents);

    }

    /**
     * Set the notification to fade out after a certain amount of time
     * @private
     * @param {Object} item The HTML element we're dealing with
     * @param {Integer} uniqueId The ID of the element
     */
    setFadeTimer(e, uniqueId){
        let self = this,
            timerStr = (self.customTimer) ? self.customTimer : self.time;
        self['_int_id_' + uniqueId] = setTimeout(function(){
            self.fade(e, uniqueId);
        }, timerStr);

    }

    /**
     * If the item is fading out and we hover over it, restore it!
     * @private
     * @param {Object} e The HTML element to remove
     * @param {Number} uniqueId The ID of the element
     */
    restoreItemIfFading(e, uniqueId){
        clearTimeout(this['_int_id_' + uniqueId]);
        e.stop().css({ opacity: '', height: '' });
    }

    /**
     * Bring everything to a halt
     * @param {Object} params A list of callback functions to pass when all notifications are removed
     */
    stop(params){
        /**
         * callbacks (if passed)
         * @type {Function}
         */
        let beforeClose = ($.isFunction(params.beforeClose)) ? params.beforeClose : function(){},
            afterClose = ($.isFunction(params.afterClose)) ? params.afterClose : function(){},
            wrap = $('#notification-notice-wrapper');

        beforeClose(wrap);
        wrap.fadeOut(function(){
            $(this).remove();
            afterClose();
        });
    }

    /**
     * An extremely handy PHP function ported to JS, works well for templating
     * @private
     * @param {String/Array} search A list of things to search for
     * @param {String/Array} replace A list of things to replace the searches with
     * @param {String} subject
     * @param {Number} count
     * @return {String} sa The output
     */
    replace(search, replace, subject, count){
        let i = 0, j = 0, temp = '', repl = '', sl = 0, fl = 0,
            f = [].concat(search),
            r = [].concat(replace),
            s = subject,
            ra = r instanceof Array, sa = s instanceof Array;

        s = [].concat(s);

        if(count) { this.window[count] = 0; }

        for(i = 0, sl = s.length; i < sl; i++){
            if(s[i] === '') { continue; }

            for (j = 0, fl = f.length; j < fl; j++){
                temp = s[i] + '';
                repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
                s[i] = (temp).split(f[j]).join(repl);

                if(count && s[i] !== temp){
                    this.window[count] += (temp.length-s[i].length) / f[j].length;
                }
            }
        }
        return sa ? s : s[0];

    }

    /**
     * Setup the global options - only once
     * @private
     */
    runSetup(){
        let opt;
        for(opt in this.options){
            this[opt] = this.options[opt];
        }
        this.isSetup = 1;
    }
    /**
     * A check to make sure we have something to wrap our notices with
     * @private
     */
    verifyWrapper(){
        if($('#notification-notice-wrapper').length == 0){
            $('body').append(this.templateWrap);
        }
    }
}

/**
 * Set it up as an object under the jQuery namespace
 */
export default {
    options: {},
    notification: new  Notification(this.options),
    /**
     * Add a notification to the screen
     * @see Notification#add();
     */
    add: function (params) {
        try {
            return this.notification.add(params || {});
        } catch(e) {

            let err = 'Notification Error: ' + e;
            (typeof(console) != 'undefined' && console.error) ?
                console.error(err, params) :
                alert(err);
        }
    },

    /**
     * Remove a gritter notification from the screen
     * @see Notification#removeSpecific();
     */
    remove: function(id, params){
        this.notification.removeSpecific(id, params || {});
    },

    /**
     * Remove all notifications
     * @see Notification#stop();
     */
    removeAll: function(params){
        this.notification.stop(params || {});
    }
}