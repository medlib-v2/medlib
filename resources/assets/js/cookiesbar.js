import Vue from 'vue'
import CookiesBar from './CookiesBar.vue'

// eslint-disable-line no-new
const cookiesBar = new Vue({
  el: '#cookiebar',
    render: (h) => h(CookiesBar)
});
