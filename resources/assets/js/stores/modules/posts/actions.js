import { SET_FEEDS, SET_POST } from './types'

/**
 *
 * @param commit
 * @param feeds
 */
export const setFeeds = ({commit}, feeds) => {
    commit(SET_FEEDS, feeds)
};

/**
 *
 * @param commit
 * @param post
 */
export const setPost = ({commit}, post) => {
    commit(SET_POST, post)
};