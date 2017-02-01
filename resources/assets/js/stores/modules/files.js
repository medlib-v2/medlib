import * as types from '../mutation-types'

/**
 * initial state
 * @type {{shared_address: {}}}
 */
const state = {
    shared_image: {}
}

/**
 * getters
 * @type {{shared_image: ((p1:*)=>{})}}
 * GET_IMAGE (state){ return state.shared_image }
 */
const getters = { image: state => state.shared_image }

/**
 * actions
 * @type {{images: (({ commit }:{commit: *}, image?))}}
 */
const actions = {
    images ({ commit }, image) { commit(types.SET_IMAGE, image ) },
}

/**
 * mutations
 * @type {{[[types.SET_IMAGE]]: ((state, image))}}
 */
const mutations = {
    [types.SET_IMAGE] (state, image) { state.shared_image = image; }
}

export default { state, getters, actions, mutations }