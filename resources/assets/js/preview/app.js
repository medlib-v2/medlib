import Vue from 'vue';
import BoxPreview from './BoxPreview.vue';

Vue.config.devtools = false;

// eslint-disable-line no-new
new Vue({
    name: 'MainPreview',
    el: '#book-preview',
    components: { BoxPreview }
});
