import Vue from 'vue'
import CookiesBar from '../../../components/CookiesBar.vue'

describe('CookiesBar.vue', () => {
    it('should render correct contents', () => {
        const Constructor = Vue.extend(CookiesBar)
        const vm = new Constructor().$mount()
        expect(vm.$el.querySelector('p').textContent)
            .toBe('Ce site utilise des cookies pour améliorer l\'expérience de navigation et fournir des fonctionnalités supplémentaires.. En savoir plus')
    });
});