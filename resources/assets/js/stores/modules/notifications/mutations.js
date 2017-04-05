import { SET_NOTIFICATION } from './types'

/**
 * mutations
 * @type {{[[SET_NOTIFICATION]]: ((state, notification?))}}
 */
const mutations = {
    [SET_NOTIFICATION] (state, notification) {
        state.notifications.push(notification)
    }
};

export default mutations