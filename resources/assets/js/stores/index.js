import Vue from 'vue'
import Vuex from 'vuex'
import modules from './modules'
//import middlewares from './middlewares'

Vue.use(Vuex);
const debug = process.env.NODE_ENV !== 'production';
Vue.config.debug = debug
/**
 * actions, getters,
 */
export default new Vuex.Store({ 
    modules,
    strict: debug
})
