import { http } from './'

export const friends = {
  /**
   * Get all friends this current user.
   *
   * @param  {string}   username
   */
  fetch (username) {
    return new Promise((resolve, reject) => {
      http.get(`/api/u/${username}/friends/all`).then(({ body }) => {
        resolve(body)
      }).catch(error => reject(error))
    })
  }
}
