import * as types from '../mutation-types'

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
 * @type {{setFeeds: (({ commit }:{commit: *}, feeds?)), setPosts: (({ commit }:{commit: *}, posts?))}}
 */
const actions = {
  address ({ commit }, address) {
    commit(types.SET_ADDRESS, address )
  }
}

/**
 * mutations
 * @type {{[[types.SET_ADDRESS]]: ((state, address))}}
 */
const mutations = {
  [types.SET_ADDRESS] (state, address) { state.shared_address = address }
}

export default {
  state,
  getters,
  actions,
  mutations
}
