import { http } from './';
import Promise from 'promise';

export const favorite = {
    /**
     * Like a bunch of songs.
     *
     * @param {Array.<Object>}  songs
     */
    like (songs) {

        return new Promise((resolve, reject) => {
            http.post('interaction/batch/like', { songs: map(songs, 'id') }, ({ data }) => {
                //alerts.success(`Added ${pluralize(songs.length, 'song')} into Favorites.`)
                resolve(data);
            }, error => reject(error));
        })
    },

    /**
     * Unlike a bunch of songs.
     *
     * @param {Array.<Object>}  songs
     */
    unlike (songs) {
        return new Promise((resolve, reject) => {
            http.post('interaction/batch/unlike', { songs: map(songs, 'id') }, ({ data }) => {
                //alerts.success(`Removed ${pluralize(songs.length, 'song')} from Favorites.`)
                resolve(data);
            }, error => reject(error));
        })
    }
};