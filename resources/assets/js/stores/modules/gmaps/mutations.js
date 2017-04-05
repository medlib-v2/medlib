import { SET_ADDRESS } from './types'

/**
 * mutations
 * @type {{[[SET_ADDRESS]]: ((state, address))}}
 */
const mutations = {
    [SET_ADDRESS] (state, address) {
        state.shared_address = address
    }
};

export default mutations