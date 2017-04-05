import * as actions from './actions'
import * as getters from './getters'
import mutations from './mutations'

/**
 * Initial stat
 * @type {{auth_user: {}, onlineStatus: boolean, authenticated: boolean}}
 */
const state = {
    auth_user: {},
    onlineStatus: false,
    authenticated: false
};

export default {
    state,
    getters,
    actions,
    mutations
}