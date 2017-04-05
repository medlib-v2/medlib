import { http } from './'

export const notifications = {
 /**
 * Get the cuurent auth user
 */
  unread () {
    return new Promise((resolve, reject) => {
      http.get('/api/notifications/unread').then(({body: { total, notifications }}) => {
        resolve({total, notifications})
      }).catch(error => reject(error))
    })
  },
  acceptRequest(username, id) {
    return new Promise((resolve, reject) => {
      http.post('/api/friends', { username: username, not_id: id }).then(({ body }) => {
        resolve(body)
      }).catch(error => reject(error))
    })
  },
  cancelRequest(username, id) {
    return new Promise((resolve, reject) => {
      http.delete('/api/friends/requests', { username: username, not_id: id }).then(({ body }) => {
        resolve(body)
      }).catch(error => reject(error))
    })
  },
  /**
  * Fetch notifications.
  * @param {Number} limit
  */
  fetch (limit = 5) {
    return new Promise((resolve, reject) => {
      http.get('/api/notifications/unread', { params: { limit } }).then(({ body: { total, notifications } }) => {
        resolve({total, notifications})
      }).catch(error => reject(error))
    })
  }
}
