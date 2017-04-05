import { http } from './'

export const conversations = {
    /**
     * Fetch all conversions.
     * @param {Number} limit
     */
    fetch (limit = 5) {
        return new Promise((resolve, reject) => {
            http.get('/api/conversations', { params: { limit } })
                .then(({ body }) => resolve(body))
                .catch(error => reject(error))
        })
    },

    /**
     * Unlike a bunch of feeds.
     * @param username
     * @param id
     */
    unlike (username, id) {
        return new Promise((resolve, reject) => {
            http.post(`/api/u/${username}/feeds/${id}/unlike`)
                .then(({ body }) => resolve(body))
                .catch(error => reject(error))
        })
    }
}
