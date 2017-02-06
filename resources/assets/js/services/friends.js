import { http } from './';
import Promise from 'promise';

export const friends = {
    /**
     * Get all friends this current user.
     *
     * @param  {string}   username
     */
    fetch (username) {
        console.log(username);
        return new Promise((resolve, reject) => {
            http.get(`/u/${username}/friends/all`, ({ data }) => {
                console.log('fetch:all', data);
                resolve(data)
            }, error => reject(error))
        })
    }
};