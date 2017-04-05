let HANDLER = '_vue_clickaway_handler'

function bind(el, binding) {
    unbind(el)

    let callback = binding.value
    if (typeof callback !== 'function') {
        if (process.env.NODE_ENV !== 'production') {
            Vue.util.warn(
                'v-' + binding.name + '="' +
                binding.expression + '" expects a function value, ' +
                'got ' + callback
            )
        }
        return
    }

    let initialMacrotaskEnded = false
    setTimeout(function() {
        initialMacrotaskEnded = true
    }, 0)

    el[HANDLER] = function(ev) {
        if (initialMacrotaskEnded && !el.contains(ev.target)) {
            return callback(ev)
        }
    }

    document.documentElement.addEventListener('click', el[HANDLER], false)
}

function unbind(el) {
    document.documentElement.removeEventListener('click', el[HANDLER], false)
    delete el[HANDLER]
}

export let directive = {
    bind: bind,
    update: function(el, binding) {
        if (binding.value === binding.oldValue) return
        bind(el, binding)
    },
    unbind: unbind,
}

export let mixin = {
    directives: { onClickaway: directive },
}