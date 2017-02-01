import Vue from 'vue'
import Hello from '../../components/Hello.vue'

describe('Hello.vue', () => {
    it('should render correct contents', () => {
        const vm = new Vue({
            template: '<div><hello></hello></div>',
            components: { Hello }
        }).$mount()
        expect(vm.$el.querySelector('h1').textContent).to.contain('Welcome to Your Vue.js App')
    })
})