/**
 * getters
 * GET_FEEDS (state) { return state.feeds },
 * GET_COUNT_FEEDS (state) { return state.feeds.length },
 * GET_POSTS (state) { return state.posts },
 */
export const getFeeds = state => state.feeds;
export const getCountFeed = state => state.posts.length;
export const getPosts = state => state.posts;

