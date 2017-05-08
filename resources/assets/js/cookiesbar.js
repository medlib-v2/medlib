import Vue from 'vue'
import CookiesBar from './CookiesBar.vue'

/* eslint-disable no-new */
const app = new Vue({
  el: '#cookiebar',
  render: h => h(CookiesBar)
});

export default app
