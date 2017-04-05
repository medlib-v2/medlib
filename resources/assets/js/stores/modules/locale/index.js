import * as actions from './actions'
import * as getters from './getters'
import mutations from './mutations'

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
};


export default {
    state,
    getters,
    actions,
    mutations
}