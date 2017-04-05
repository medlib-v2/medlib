import * as actions from './actions'
import * as getters from './getters'
import mutations from './mutations'

/**
 * Initial state
 * @type {{shared_image: {}}}
 */
const state = {
    shared_image: {}
};

export default {
    state,
    getters,
    actions,
    mutations
}