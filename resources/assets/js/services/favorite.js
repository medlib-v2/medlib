import { http } from './'

export const favorite = {
  /**
  * Like a bunch of feeds.
  * @param username
  * @param id
  */
  like (username, id) {
    return new Promise((resolve, reject) => {
      http.post(`/u/${username}/feeds/${id}/like`).then(({ body }) => {
        resolve(body)
      }).catch(error => reject(error))
    })
  },

  /**
   * Unlike a bunch of feeds.
   * @param username
   * @param id
   */
  unlike (username, id) {
    return new Promise((resolve, reject) => {
      http.post(`/u/${username}/feeds/${id}/unlike`).then(({ body }) => {
        resolve(body)
      }).catch(error => reject(error))
    })
  }
}
