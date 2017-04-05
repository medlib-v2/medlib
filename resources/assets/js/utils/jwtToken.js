import { ls } from '../services'
import decode from 'jsonwebtoken/decode';

export const jwtToken =  {
    /**
     * Get the decoded payload ignoring signature, no secretOrPrivateKey needed
     * @set decode(token)
     * Get the decoded payload and header
     * @options options: json: Boolean, complete: Boolean
     * @set decode(token, {complete: true})
     *
     * @param string token
     * @param Object options
     * @returns {*}
     */
    decode: decode,

    /**
     *
     * @param token
     * @returns {*}
     */
    getDeadline(token) {

        const decoded = this.decode(token);
        if (typeof decoded.exp === 'undefined') return null;
        let deadline = new Date(0);
        deadline.setUTCSeconds(decoded.exp);

        return deadline;
    },

    /**
     *
     * @param token
     * @returns {boolean}
     */
    isExpired(token) {

        const deadline = this.getDeadline(token);
        if (deadline === null) return false;
        const now = new Date();
        return deadline.valueOf() <= now.valueOf();

    },

    /**
     *
     * @param token
     */
    setToken(token) {
        ls.set('jwt-token', token)
    },

    /**
     *
     * @returns {*}
     */
    getToken() {
        return ls.get('jwt-token');
    },

    /**
     *
     */
    removeToken() {
        ls.remove('jwt-token');
    },

    /**
     *
     * @returns {boolean}
     */
    hasToken() {
        return this.getToken() !== null
    },

    /**
     *
     * @returns {boolean}
     */
    isAuthenticated() {
        return ! this.isExpired(this.getToken());
    },

    /**
     *
     * @param data
     * @returns {*}
     */
    setUserData(data) {

        ls.userData = data;

        return ls.set(
            ls.getStorageKey('user'),
            JSON.stringify(data)
        );

    },

    /**
     *
     * @returns {*}
     */
    getUserData() {
        return JSON.parse(ls.get(ls.getStorageKey('user')))
    },

    /**
     *
     */
    removeUserData() {
        ls.remove(ls.getStorageKey('user'));
    },
};