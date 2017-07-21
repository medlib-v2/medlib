// Copied from vue/src/core/util/debug.js
let installed = false;

const formatComponentName = vm => {
    if (vm.$root === vm) {
        return 'root instance'
    }
    const name = vm._isVue
        ? vm.$options.name || vm.$options._componentTag
        : vm.name;
    return name ? `component <${name}>` : `anonymous component`
};

const formatLocation = str => {
    if (str === 'anonymous component') {
        str += ` - use the "name" option for better debugging messages.`
    }
    return `(found in ${str})`
};

const warn = (msg, vm) => {
    if (process.env.NODE_ENV !== 'production') {
        const hasConsole = typeof console !== 'undefined';

        if (hasConsole) {
            console.error(`[Vue warn]: ${msg} ` + (
                    vm ? formatLocation(formatComponentName(vm)) : ''
                ))
        }
    }
};

export default (Vue, options) => {
    if (installed) return;
    installed = true;

    Vue.prototype.debug = warn;
}