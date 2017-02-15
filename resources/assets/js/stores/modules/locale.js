import * as types from '../mutation-types'
import moment from 'moment';

/**
 * Initial state
 * @type {{availableLocales: {en: string, fr: string}, locale: string}}
 */
const state = {
  availableLocales: {
    'en': 'English',
    'fr': 'Francais'
  },
  locale: 'fr'
}

/**
 * getters
 * @type {{locale: ((p1:*)=>{})}}
 * GET_LOCALE (state){ return state.locale }
 */
const getters = {
  locale: state => state.locale
}

/**
 * actions
 * @type {{setLocale: (({ commit }:{commit: *}, locale?))}}
 */
const actions = {
  setLocale ({ commit }, locale) { commit(types.SET_LOCALE, locale ) },
}

/**
 * mutations
 * @type {{[[types.SET_LOCALE]]: ((state, locale))}}
 */
const mutations = {
  [types.SET_LOCALE] (state, locale) {
    if (state.availableLocales.hasOwnProperty(locale)) {
      state.locale = locale;
      moment.locale(locale);
    }
  }
}

export default { state, getters, actions, mutations }
