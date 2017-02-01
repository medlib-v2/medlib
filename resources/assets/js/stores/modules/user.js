import * as types from '../mutation-types'

/**
 * initial stat
 * @type {{user: {}, onlineStatus: null}}
 */
const state = {
    auth_user: {},
    onlineStatus: false
}

/**
 * getters
 * @type {{onlineStatus: ((p1:*)=>null), user: ((p1:*)=>(*))}}
 */
const getters = {
    onlineStatus: state => state.onlineStatus,
    user: state => state.auth_user
}

/**
 * actions
 * @type {{setUserAuth: (({ commit }:{commit: *}, auth_user?))}}
 */
const actions = {
    user ({ commit }, auth_user) { commit(types.SET_AUTH_USER, auth_user) }
}

/**
 * mutations
 * @type {{[[types.SET_AUTH_USER]]: ((state, user)), [[types.SET_AUTH_USER_ONLINE]]: ((state, user))}}
 */
const mutations = {
    [types.SET_AUTH_USER] (state, user) { state.auth_user = user },
    [types.SET_AUTH_USER_ONLINE] (state, user) { state.onlineStatus = user.onlinestatus }
}

export default {
    state,
    getters,
    actions,
    mutations
}