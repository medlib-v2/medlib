import * as actions from './actions'
import * as getters from './getters'
import mutations from './mutations'

/**
 * Initial state
 * @type {{feeds: {}, posts: Array}}
 */
const state = {
    feeds: {},
    posts: []
};

export default {
    state,
    getters,
    actions,
    mutations
}