import { SET_RESULTS, SET_FILTERS } from './types'

/**
 * mutations
 * @type {{[SET_RESULTS]: ((state, results?)), [SET_FILTERS]: ((state, filters?))}}
 */
const mutations = {
    [SET_RESULTS] (state, results) {
        state.results = results
    },

    [SET_FILTERS] (state, filters) {
        state.filters = Object.assign(filters)
    }
};
export default mutations