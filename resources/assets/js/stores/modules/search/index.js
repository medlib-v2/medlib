import * as actions from './actions'
import * as getters from './getters'
import mutations from './mutations'

/**
 * Initial stat
 * @type {{search: {}}}
 */
const state = {
    loading: true,
    filters: {},
    results: []
};

export default {
    state,
    getters,
    actions,
    mutations
}