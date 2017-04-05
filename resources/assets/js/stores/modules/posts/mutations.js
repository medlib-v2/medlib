import { SET_FEEDS, SET_POST, SET_UPDATE_POST_LIKES, SET_UNLIKE_POST } from './types'

/**
 * mutations
 * @type {{[[SET_FEEDS]]: ((state, feeds)), [[SET_POST]]: ((state, post?)), [[SET_UPDATE_POST_LIKES]]: ((state, payload)), [[SET_UNLIKE_POST]]: ((state, payload))}}
 */
const mutations = {
    [SET_FEEDS] (state, feeds) {
        state.feeds = feeds
    },

    [SET_POST] (state, post) {
        state.posts.push(post)
    },

    [SET_UPDATE_POST_LIKES] (state, payload) {
        let post = state.posts.find((p) => {
            return p.id === payload.id
        });
        post.likes.push(payload.like)
    },

    [SET_UNLIKE_POST] (state, payload) {
        let post = state.posts.find((p) => {
            return p.id === payload.post_id
        });

        let like = post.likes.find((l) => {
            return l.id === payload.like_id
        });

        let index = post.likes.indexOf(like);
        post.likes.splice(index, 1)
    }
};

export default mutations