import * as actions from './actions'
import * as getters from './getters'
import mutations from './mutations'

/**
 * Initial stat
 * @type {{user: {}}}
 */
const state = {
    users: [],
};

export default {
    state,
    getters,
    actions,
    mutations
}