import { SET_AUTH_USER, SET_AUTH_USER_ONLINE, SET_AUTH_USER_LOGOUT } from '../types'

/**
 * initial stat
 * @type {{auth_user: {}, onlineStatus: boolean, authenticated: boolean}}
 */
const state = {
    auth_user: {},
    onlineStatus: false,
    authenticated: false
};

/**
 * getters
 * @type {{onlineStatus: ((p1:*)=>boolean), authenticated: ((p1:*)=>boolean), user: ((p1:*)=>{})}}
 */
const getters = {
    onlineStatus: state => state.onlineStatus,
    authenticated: state => state.authenticated,
    user: state => state.auth_user
};

/**
 * actions
 * @type {{user: (({commit}:{commit: *}, auth_user?)), logout: (({commit}:{commit: *}, logout?))}}
 */
const actions = {
    user ({commit}, auth_user) {
        commit(SET_AUTH_USER, auth_user)
    },
    logout ({commit}, logout = {}) {
        commit(SET_AUTH_USER_LOGOUT, logout)
    }
};

/**
 * mutations
 * @type {{[SET_AUTH_USER]: ((state, user)), [SET_AUTH_USER_LOGOUT]: ((state, logout)), [SET_AUTH_USER_ONLINE]: ((state, user))}}
 */
const mutations = {
    [SET_AUTH_USER] (state, user) {
        state.auth_user = user
        state.authenticated = true
    },
    [SET_AUTH_USER_LOGOUT] (state, logout) {
        state.auth_user = logout
        state.onlineStatus = false
        state.authenticated = false
    },
    [SET_AUTH_USER_ONLINE] (state, user) {
        state.onlineStatus = user.onlinestatus
    }
};

export default {
    state,
    getters,
    actions,
    mutations
}
