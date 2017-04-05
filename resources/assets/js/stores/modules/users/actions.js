import { SET_USER } from './types'

/**
 *
 * @param commit
 * @param user
 */
export const setUsers = ({ commit }, user) => {
    commit(SET_USER, user)
};