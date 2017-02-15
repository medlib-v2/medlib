import * as types from '../mutation-types'

/**
 * initial stat
 * @type {{notification: Array}}
 */
const state = {
  notifications: [],
}

/**
 * getters
 * @type {{countNotifications: ((p1:*)=>Number)}}
 */
const getters = {
  countNotifications: state => state.notifications.length,
  notifications: state => state.notifications,
}

/**
 * actions
 * @type {{notificationUnread: (({ commit }:{commit: *}, notification?))}}
 */
const actions = {
  notificationUnread ({ commit }, notification) {
    commit(types.SET_NOTIFICATION, notification)
  }
}

/**
 * mutations
 * @type {{[[types.SET_NOTIFICATION]]: ((state, notification?))}}
 */
const mutations = {
  [types.SET_NOTIFICATION] (state, notification) {
    state.notifications.push(notification)
  }
}

export default {
  state,
  getters,
  actions,
  mutations
}
