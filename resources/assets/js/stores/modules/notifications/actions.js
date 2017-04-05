import { SET_NOTIFICATION } from './types'

/**
 * actions
 * @param commit
 * @param notification
 */
export const setNotificationUnread = ({commit}, notification) => {
    commit(SET_NOTIFICATION, notification)
};
