import CookiesBar from '../../../components/CookiesBar.vue'
import { createVue, destroyVM } from './Utils'

describe('CookiesBar.vue', () => {
    let vm;
    afterEach(() => {
        destroyVM(vm);
    });

    it('should render correct contents', () => {
        vm = createVue(CookiesBar, true);

        expect(vm.$el.querySelector('p').textContent)
            .toBe('Ce site utilise des cookies pour améliorer l\'expérience de navigation et fournir des fonctionnalités supplémentaires.. En savoir plus')
    });
});