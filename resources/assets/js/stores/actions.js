import { SET_AUTH_USER, SET_FEEDS, SET_POST } from './types'

export const user = ({commit}, user) => {
    commit(SET_AUTH_USER, user)
}

export const feeds = ({commit}, feeds) => {
    commit(SET_FEEDS, feeds)
}

export const post = ({commit}, post) => {
    commit(SET_POST, post)
}
