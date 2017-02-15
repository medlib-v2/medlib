import Vue from 'vue'
import Vuex from 'vuex'

import user from './modules/user'
import users from './modules/users'
import posts from './modules/posts'
import gmaps from './modules/gmaps'
import files from './modules/files'
import notifications from './modules/notifications'
import locale from './modules/locale'

Vue.use(Vuex)

/**
 * actions, getters,
 */
export default new Vuex.Store({
    modules: { locale, user, users, posts,  gmaps, files, notifications }
})
