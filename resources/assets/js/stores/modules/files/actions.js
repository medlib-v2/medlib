import { SET_IMAGE } from './types'

/**
 * actions
 * @param commit
 * @param image
 */
export const setImages = ({commit}, image) => {
    commit(SET_IMAGE, image)
};