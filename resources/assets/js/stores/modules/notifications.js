import { SET_NOTIFICATION } from '../types'

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
    notificationUnread ({commit}, notification) {
        commit(SET_NOTIFICATION, notification)
    }
}

/**
 * mutations
 * @type {{[[SET_NOTIFICATION]]: ((state, notification?))}}
 */
const mutations = {
    [SET_NOTIFICATION] (state, notification) {
        state.notifications.push(notification)
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
