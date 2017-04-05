import * as actions from './actions'
import * as getters from './getters'
import mutations from './mutations'

/**
 * Initial state
 * @type {{shared_address: {}}}
 */
const state = {
    shared_address: {}
};

export default {
    state,
    getters,
    actions,
    mutations
}