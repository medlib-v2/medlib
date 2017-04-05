import {http} from './'

export const user = {
    /**
     * Get the cuurent auth user
     *
     * @param user
     */
    me (user) {
        return new Promise((resolve, reject) => {
            http.get(`/api/u/${user}/me`).then(({body}) => {
                resolve(body)
            }).catch(error => reject(error))
        })
    },
    /**
     * Log a user in.
     *
     * @param  {Object}   data
     */
    login (data) {
        return new Promise((resolve, reject) => {
            http.post('/api/login', data).then(({body}) => {
                resolve(body)
            }).catch(error => reject(error))
        })
    },
    /**
     * Log the current user out.
     */
    logout () {
        return new Promise((resolve, reject) => {
            http.delete('/api/logout').then(({body}) => {
                resolve(body)
            }).catch(error => reject(error))
        })
    },

    /**
     * Log a user in.
     *
     * @param  {Object}   data
     */
    register (data) {
        return new Promise((resolve, reject) => {
            http.post('/api/register', data).then(({body}) => {
                resolve(body)
            }).catch(error => reject(error))
        })
    },

    /**
     * Update the current user's profile.
     *
     * @param {Object} user
     * @param {string} password Can be an empty string if the user is not changing his password.
     */
    updateProfile (user, password) {
        return new Promise((resolve, reject) => {
            http.put('/api/me', {
                password,
                username: user.username,
                email: user.email
            }).then(({body}) => {
                resolve(body)
            }).catch(error => reject(error))
        })
    },
    /**
     * Stores a new user into the database.
     *
     * @param  {string}   username
     * @param  {string}   email
     * @param  {string}   password
     */
    store (username, email, password) {
        return new Promise((resolve, reject) => {
            http.post('/api/user', {username, email, password}).then(({body: user}) => {
                resolve(user)
            }).catch(error => reject(error))
        })
    },

    /**
     * Update a user's profile.
     *
     * @param  {Object}   user
     * @param  {String}   name
     * @param  {String}   email
     * @param  {String}   password
     */
    update (user, name, email, password) {
        return new Promise((resolve, reject) => {
            http.put(`/api/user/${user.id}`, {name, email, password}).then(({body: user}) => {
                resolve(user)
            }).catch(error => reject(error))
        })
    },
    /**
     * Delete a user.
     *
     * @param  {Object}   user
     */
    destroy (user) {
        return new Promise((resolve, reject) => {
            http.delete(`/api/user/${user.username}`).then(({body}) => {
                resolve(body)
            }).catch(error => reject(error))
        })
    }
}
