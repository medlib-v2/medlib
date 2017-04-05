import { SET_IMAGE } from './types'

/**
 * mutations
 * @type {{[[SET_IMAGE]]: ((state, image))}}
 */
const mutations = {
    [SET_IMAGE] (state, image) {
        state.shared_image = image
    }
};

export default mutations