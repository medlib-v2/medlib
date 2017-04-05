import { SET_AUTH_USER, SET_AUTH_USER_ONLINE, SET_AUTH_USER_LOGOUT } from './types'

/**
 * mutations
 * @type {{[SET_AUTH_USER]: ((state, user)), [SET_AUTH_USER_LOGOUT]: ((state, logout)), [SET_AUTH_USER_ONLINE]: ((state, user))}}
 */
const mutations = {
    /**
     *
     * @param state
     * @param user
     */
    [SET_AUTH_USER] (state, user) {
        state.auth_user = user;
        state.authenticated = true
    },
    /**
     *
     * @param state
     * @param logout
     */
    [SET_AUTH_USER_LOGOUT] (state, logout) {
        state.auth_user = logout;
        state.onlineStatus = false;
        state.authenticated = false
    },
    /**
     *
     * @param state
     * @param user
     */
    [SET_AUTH_USER_ONLINE] (state, user) {
        state.onlineStatus = user.onlinestatus
    }
};

export default mutations