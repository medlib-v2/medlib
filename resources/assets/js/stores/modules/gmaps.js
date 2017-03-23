import { SET_ADDRESS } from '../types'

/**
 * initial state
 * @type {{shared_address: {}}}
 */
const state = {
    shared_address: {}
}

/**
 * getters
 * @type {{shared_address: ((p1:*)=>{})}}
 */
const getters = {
    shared_address: state => state.shared_address,
}

/**
 * actions
 * @type {{address: (({ commit }:{commit: *}, address?))}}
 */
const actions = {
    address ({commit}, address) {
        commit(SET_ADDRESS, address)
    }
}

/**
 * mutations
 * @type {{[[SET_ADDRESS]]: ((state, address))}}
 */
const mutations = {
    [SET_ADDRESS] (state, address) {
        state.shared_address = address
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
