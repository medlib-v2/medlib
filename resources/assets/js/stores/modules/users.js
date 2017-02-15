import * as types from '../mutation-types'

/**
 * initial stat
 * @type {{user: {}, onlineStatus: null}}
 */
const state = {
  users: [],
}

/**
 * getters
 * @type {{users: ((p1:*)=>(*))}}
 */
const getters = {
  users: state => state.users
}

/**
 * actions
 * @type {{setUsers: (({ commit }:{commit: *}, user?))}}
 */
const actions = {
  setUsers ({ commit }, user) {
    commit(types.SET_USER, user)
  }
}

/**
 * mutations
 * @type {{[[types.SET_USER]]: ((state, user))}}
 */
const mutations = {
  [types.SET_USER] (state, user) {
    state.users.push(user)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
