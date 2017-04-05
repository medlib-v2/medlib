import * as actions from './actions'
import * as getters from './getters'
import mutations from './mutations'

/**
 * Initial stat
 * @type {{notification: Array}}
 */
const state = {
    notifications: [],
};

export default {
    state,
    getters,
    actions,
    mutations
}