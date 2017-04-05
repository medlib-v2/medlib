import { SET_LOCALE } from './types'

/**
 * actions
 * @param commit
 * @param locale
 */
export const setLocale = ({commit}, locale) => {
    commit(SET_LOCALE, locale)
};