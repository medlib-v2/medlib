import { SET_USER } from './types'

/**
 * mutations
 * @type {{[[SET_USER]]: ((state, user))}}
 */
const mutations = {
    [SET_USER] (state, user) {
        state.users.push(user)
    }
};
export default mutations