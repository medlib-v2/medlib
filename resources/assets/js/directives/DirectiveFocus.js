import Vue from 'vue'

/**
 * A simple directive to set focus into an input field when it's shown.
 */
Vue.directive('focus', {
    inserted (el) {
        el.focus()
    }
})