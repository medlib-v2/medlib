import { SET_FEEDS, SET_POST, SET_UPDATE_POST_LIKES, SET_UNLIKE_POST } from '../types'

/**
 * initial state
 * @type {{feeds: {}, posts: Array}}
 */
const state = {
    feeds: {},
    posts: []
}

/**
 * getters
 * @type {{feeds: ((p1:*)=>(*)), countFeed: ((p1:*)=>Number), posts: ((p1:*)=>Array)}}
 * GET_FEEDS (state) { return state.feeds },
 * GET_COUNT_FEEDS (state) { return state.feeds.length },
 * GET_POSTS (state) { return state.posts },
 */
const getters = {
    feeds: state => state.feeds,
    countFeed: state => state.posts.length,
    posts: state => state.posts
}

/**
 * actions
 * @type {{setFeeds: (({ commit }:{commit: *}, feeds?)), setPosts: (({ commit }:{commit: *}, posts?)), like: (({ commit }:{commit: *}, poster_name, id?)), unlike: (({ commit }:{commit: *}, poster_name, id?))}}
 */
const actions = {
    feeds ({commit}, feeds) {
        commit(SET_FEEDS, feeds)
    },
    post ({commit}, post) {
        commit(SET_POST, post)
    }
}

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
        })
        post.likes.push(payload.like)
    },

    [SET_UNLIKE_POST] (state, payload) {
        let post = state.posts.find((p) => {
            return p.id === payload.post_id
        })

        let like = post.likes.find((l) => {
            return l.id === payload.like_id
        })

        let index = post.likes.indexOf(like)
        post.likes.splice(index, 1)
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
