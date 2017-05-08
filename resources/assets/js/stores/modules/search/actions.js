import { SET_RESULTS, SET_FILTERS } from './types'

/**
 * @param commit
 * @param results
 */
export const setResults = ({ commit }, results) => {
    commit(SET_RESULTS, results)
};

/**
 * @param commit
 * @param filters
 */
export const setFilters = ({ commit }, filters) => {
    commit(SET_FILTERS, filters)
};