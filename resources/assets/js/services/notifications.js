import { http } from './';
import Promise from 'promise';

export const notifications = {
    /**
     * Get the cuurent auth user
     */
    unread () {
        return new Promise((resolve, reject) => {
            http.get('/notifications/unread', {}, ({ data }) => {
                /**
                 * Brian May enters the stage.
                 */
                resolve(data);
            }, error => reject(error));
        })
    }
};