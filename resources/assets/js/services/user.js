import { http } from './';
import Promise from 'promise';

export const user = {
    /**
     * Get the cuurent auth user
     *
     * @param user
     */
    me (user) {
        return new Promise((resolve, reject) => {
            http.get(`/u/${user}/me`, {}, ({ data }) => {
                /**
                 * Brian May enters the stage.
                 */
                resolve(data);
            }, error => reject(error));
        })
    },
    /**
     * Log a user in.
     *
     * @param  {String}   email
     * @param  {String}   password
     */
    login (email, password) {

        return new Promise((resolve, reject) => {
            http.post('me', { email, password }, ({ data }) => {
                resolve(data);
            }, error => reject(error));
        })
    },
    /**
     * Log the current user out.
     */
    logout () {
        return new Promise((resolve, reject) => {
            http.delete('me', {}, ({ data }) => {
                resolve(data);
            }, error => reject(error));
        })
    },

    /**
     * Update the current user's profile.
     *
     * @param  {string} password Can be an empty string if the user is not changing his password.
     */
    updateProfile (password) {

        return new Promise((resolve, reject) => {
            http.put('me', {
                    password,
                    name: this.current.name,
                    email: this.current.email
                }, () => {
                    //this.setAvatar()
                    //alerts.success('Profile updated.')
                    resolve(this.current)
                },
                error => reject(error))
        })
    },
    /**
     * Stores a new user into the database.
     *
     * @param  {string}   name
     * @param  {string}   email
     * @param  {string}   password
     */
    store (name, email, password) {

        return new Promise((resolve, reject) => {
            http.post('/user', { name, email, password }, ({ data: user }) => {
                resolve(user)
            }, error => reject(error))
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
            http.put(`/user/${user.id}`, { name, email, password }, () => {
                resolve(user)
            }, error => reject(error))
        })
    },
    /**
     * Delete a user.
     *
     * @param  {Object}   user
     */
    destroy (user) {
        return new Promise((resolve, reject) => {
            http.delete(`user/${user.username}`, {}, ({ data }) => {
                /**
                 * Brian May enters the stage.
                 */
                resolve(data);
            }, error => reject(error));
        })
    }
};