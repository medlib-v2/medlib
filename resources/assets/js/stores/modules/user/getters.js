/**
 * getters
 * GET_ON_LINE_STATUS (state) { return state.onlineStatus },
 * GET_AUTHENTICATED (state) { return state.authenticated },
 * GET_USER_AUTH (state) { return state.auth_user },
 */
export const onlineStatus = state => state.onlineStatus;
export const authenticated =  state => state.authenticated;
export const getUserAuth = state => state.auth_user;

