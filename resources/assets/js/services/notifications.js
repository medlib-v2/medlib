import { http } from './';

export const notifications = {
    /**
     * Get the cuurent auth user
     */
    unread () {
        return new Promise((resolve, reject) => {
            http.get('/notifications/unread').then(({ body }) => {
                resolve(body);
            }).catch(error => reject(error));
        })
    }
};