import * as types from './mutation-types'

export const user = ({ commit }, user) => {
  commit(types.SET_AUTH_USER, user)
}

export const feeds = ({ commit }, feeds) => {
  commit(types.SET_FEEDS, feeds)
}

export const post = ({ commit }, post) => {
  commit(types.SET_POST, post)
}
