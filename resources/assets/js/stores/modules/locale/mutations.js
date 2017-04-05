import { SET_LOCALE } from './types'
import moment from 'moment';

/**
 * mutations
 * @type {{[[SET_LOCALE]]: ((state, locale))}}
 */
const mutations = {
    [SET_LOCALE] (state, locale) {
        if (state.availableLocales.hasOwnProperty(locale)) {
            state.locale = locale;
            moment.locale(locale);
        }
    }
};

export default mutations