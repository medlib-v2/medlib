import { http } from './'

export const notifications = {
 /**
 * Get the cuurent auth user
 */
  unread () {
    return new Promise((resolve, reject) => {
      http.get('/notifications/unread').then(({body: { total, notifications }}) => {
        resolve(total, notifications)
      }).catch(error => reject(error))
    })
  },
  accept_request(username, id) {
    return new Promise((resolve, reject) => {
      http.post('/friends', { username: username, not_id: id }).then(({ body }) => {
        resolve(body)
      }).catch(error => reject(error))
    })
  },
  cancel_request(username, id) {
    return new Promise((resolve, reject) => {
      http.delete('/friends/requests', { username: username, not_id: id }).then(({ body }) => {
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
      http.get('/notifications', { params: { limit } }).then(({ body: { total, notifications } }) => {
        resolve(total, notifications)
        this.total = total
        this.notifications = notifications.map(({ id, data, created }) => {
          return {
            id: id,
            title: data.title,
            body: data.body,
            created: created,
            action_url: data.action_url
          }
        })
      }).catch(error => reject(error))
    })
  }
}
