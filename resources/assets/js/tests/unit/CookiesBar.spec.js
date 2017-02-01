import Vue from 'vue'
import CookiesBar from '../../components/CookiesBar.vue'

describe('Hello.vue', () => {
    it('should render correct contents', () => {
        const vm = new Vue({
            el: document.createElement('div'),
            render: (h) => h(CookiesBar)
        })
        expect(vm.$el.querySelector('h1').textContent).toBe('Welcome to Your Vue.js App')
    })
})