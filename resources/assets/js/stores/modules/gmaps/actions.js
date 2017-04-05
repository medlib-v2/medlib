import { SET_ADDRESS } from './types'

/**
 * actions
 * @param commit
 * @param address
 */
export const setAddress = ({commit}, address) => {
    commit(SET_ADDRESS, address)
};