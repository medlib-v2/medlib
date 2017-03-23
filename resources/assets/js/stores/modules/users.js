import { SET_USER } from '../types'

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
    commit(SET_USER, user)
  }
}

/**
 * mutations
 * @type {{[[SET_USER]]: ((state, user))}}
 */
const mutations = {
  [SET_USER] (state, user) {
    state.users.push(user)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
