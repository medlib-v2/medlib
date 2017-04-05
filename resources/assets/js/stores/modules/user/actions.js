import { SET_AUTH_USER, SET_AUTH_USER_LOGOUT } from './types'

/**
 *
 * @param commit
 * @param auth_user
 */
export const setUserAuth = ({commit}, auth_user) => {
    commit(SET_AUTH_USER, auth_user)
};

/**
 *
 * @param commit
 * @param logout
 */
export const setLogout = ({commit}, logout = {}) => {
    commit(SET_AUTH_USER_LOGOUT, logout)
};