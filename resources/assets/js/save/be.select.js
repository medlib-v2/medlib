(function (factory) {
    if (typeof define === 'function' && define.amd) { // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') { // Node/CommonJS
        var jQuery = require('jquery');
        module.exports = factory(jQuery);
    } else { // Browser globals (zepto supported)
        factory(window.jQuery || window.Zepto || window.$); // Zepto supported on browsers as well
    }

}(function ($) {
    "use strict";
    $.fn.beSelect = function(method) {

        /**
         * Methods
         */
        if (typeof method == 'string') {
            if (method == 'update') {
                this.each(function() {
                    var $select = $(this);
                    var $dropdown = $(this).next('.be-select');
                    var open = $dropdown.hasClass('open');

                    if ($dropdown.length) {
                        $dropdown.remove();
                        create_be_select($select);

                        if (open) {
                            $select.next().trigger('click');
                        }
                    }
                });
            } else if (method == 'destroy') {
                this.each(function() {
                    var $select = $(this);
                    var $dropdown = $(this).next('.be-select');

                    if ($dropdown.length) {
                        $dropdown.remove();
                        $select.css('display', '');
                    }
                });
                if ($('.be-select').length == 0) {
                    $(document).off('.be_select');
                }
            } else {
                console.log('Method "' + method + '" does not exist.')
            }
            return this;
        }

        /**
         * Hide native select
         */
        this.hide();

        /**
         * Create custom markup
         */
        this.each(function() {
            var $select = $(this);

            if (!$select.next().hasClass('be-select')) {
                create_be_select($select);
            }
        });

        function create_be_select($select) {
            $select.after($('<div></div>')
                .addClass('be-select')
                .addClass($select.attr('class') || '')
                .addClass($select.attr('disabled') ? 'disabled' : '')
                .attr('tabindex', $select.attr('disabled') ? null : '0')
                .html('<div class="be-current"><span class="current"></span></div><div class="be-scroller"><ul class="list"></ul></div>')
            );

            var $dropdown = $select.next();
            var $options = $select.find('option');
            var $selected = $select.find('option:selected');

            $dropdown.find('.current').html($selected.data('display') || $selected.text());

            $options.each(function(i) {
                var $option = $(this);
                var display = $option.data('display');

                $dropdown.find('ul').append($('<li></li>')
                    .attr('data-value', $option.val())
                    .attr('data-display', (display || null))
                    .addClass('option' +
                        ($option.is(':selected') ? ' selected' : '') +
                        ($option.is(':disabled') ? ' disabled' : ''))
                    .html($option.text())
                );
            });
        }

        /* Event listeners */

        /**
         * Unbind existing events in case that the plugin has been initialized before
         */
        $(document).off('.be_select');

        /**
         * Open/close
         */
        $(document).on('click.be_select', '.be-select', function(event) {
            var $dropdown = $(this);

            $('.be-select').not($dropdown).removeClass('open');
            $dropdown.toggleClass('open');

            if ($dropdown.hasClass('open')) {
                $dropdown.find('.option');
                $dropdown.find('.focus').removeClass('focus');
                $dropdown.find('.selected').addClass('focus');
            } else {
                $dropdown.focus();
            }
        });

        /**
         * Close when clicking outside
         */
        $(document).on('click.be_select', function(event) {
            if ($(event.target).closest('.be-select').length === 0) {
                $('.be-select').removeClass('open').find('.option');
            }
        });

        /**
         * Option click
         */
        $(document).on('click.be_select', '.be-select .option:not(.disabled)', function(event) {
            var $option = $(this);
            var $dropdown = $option.closest('.be-select');

            $dropdown.find('.selected').removeClass('selected');
            $option.addClass('selected');

            var text = $option.data('display') || $option.text();
            $dropdown.find('.current').text(text);

            $dropdown.prev('select').val($option.data('value')).trigger('change');
        });

        /**
         * Keyboard events
         */
        $(document).on('keydown.be_select', '.be-select', function(event) {
            var $dropdown = $(this);
            var $focused_option = $($dropdown.find('.focus') || $dropdown.find('.list .option.selected'));

            /**
             * Space or Enter
             */
            if (event.keyCode == 32 || event.keyCode == 13) {
                if ($dropdown.hasClass('open')) {
                    $focused_option.trigger('click');
                } else {
                    $dropdown.trigger('click');
                }
                return false;
                /**
                 * Down
                 */
            } else if (event.keyCode == 40) {
                if (!$dropdown.hasClass('open')) {
                    $dropdown.trigger('click');
                } else {
                    var $next = $focused_option.nextAll('.option:not(.disabled)').first();
                    if ($next.length > 0) {
                        $dropdown.find('.focus').removeClass('focus');
                        $next.addClass('focus');
                    }
                }
                return false;
                /**
                 * Up
                 */
            } else if (event.keyCode == 38) {
                if (!$dropdown.hasClass('open')) {
                    $dropdown.trigger('click');
                } else {
                    var $prev = $focused_option.prevAll('.option:not(.disabled)').first();
                    if ($prev.length > 0) {
                        $dropdown.find('.focus').removeClass('focus');
                        $prev.addClass('focus');
                    }
                }
                return false;
                /**
                 * Esc
                 */
            } else if (event.keyCode == 27) {
                if ($dropdown.hasClass('open')) {
                    $dropdown.trigger('click');
                }
                /**
                 * Tab
                 */
            } else if (event.keyCode == 9) {
                if ($dropdown.hasClass('open')) {
                    return false;
                }
            }
        });

        /**
         * Detect CSS pointer-events support, for IE <= 10. From Modernizr.
         * @type {CSSStyleDeclaration}
         */
        var style = document.createElement('a').style;
        style.cssText = 'pointer-events:auto';
        if (style.pointerEvents !== 'auto') {
            $('html').addClass('no-csspointerevents');
        }
        return this;
    };
}));

/**
 *
 * @type type Medlib.BeSelect
 */
var Medlib = (function () {
    'use strict';
    Medlib.BeSelect = function(options){
        $('select').beSelect(options);
    };
    return Medlib;
})(Medlib || {});