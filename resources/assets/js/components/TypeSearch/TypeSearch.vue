<template lang="html">
    <ul class="icons">
        <li class="all active"
            title="Web Search"
            data-search-type="all"
            type="all"
            @click="updateValue($event.target.type)">{{ trans('search.icons.all') }}</li>

        <li class="images"
            title="Image Search"
            data-search-type="images"
            type="images"
            @click="updateValue($event.target.type)">{{ trans('search.icons.images') }}</li>

        <li class="books"
            title="Book Search"
            data-search-type="books"
            type="books"
            @click="updateValue($event.target.type)">{{ trans('search.icons.books') }}</li>

        <li class="videos"
            title="Video Search"
            data-search-type="videos"
            type="videos"
            @click="updateValue($event.target.type)">{{ trans('search.icons.videos') }}</li>
    </ul>
</template>

<script type="text/babel">
    import $ from 'jquery'
    import Lang from '@/mixins/lang'

    export default {
        name: 'typeSearch',

        components: {},

        mixins: [Lang],

        props: ['value'],

        mounted () {
            /**
             * The small arrow that marks the active search icon:
             * @type {*}
             */
            let arrow = $('<span>', {class:'arrow'}).appendTo('ul.icons');
            $('ul.icons li').click(function(){
                let el = $(this);
                /**
                 * The icon is already active, exit
                 */
                if(el.hasClass('active')) return false;

                el.siblings().removeClass('active');
                el.addClass('active');
                /**
                 * Move the arrow below this icon
                 */
                arrow.stop().animate({
                    left: el.position().left,
                    marginLeft: (el.width()/2)-4
                });
            });

            /**
             * Marking the web search icon as active:
             */
            $('ul.icons li.all').click();

            /**
             * Focusing the input text box:
             */
            //$('#s').focus();
        },

        methods: {
            updateValue (value) {
                this.$emit('input', value)
            }
        }
    };
</script>
