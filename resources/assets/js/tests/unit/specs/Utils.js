import Vue from 'vue'

export function vueTest (Component) {
    const Class = Vue.extend(Component)

    Class.prototype.$ = (selector) => {
        return this.$el.querySelector(selector)
    };

    Class.prototype.nextTick = () => {
        return new Promise((resolve) => {
            this.$nextTick(resolve)
        })
    };

    const vm = new Class();
    vm.$mount()
}

export function nextTick (vm) {
    return new Promise((resolve) => {
        if (!vm) Vue.nextTick(resolve);
        else vm.$nextTick(resolve)
    })
}

export function delay (timeout) {
    return new Promise((resolve) => {
        setTimeout(resolve, timeout)
    })
}

