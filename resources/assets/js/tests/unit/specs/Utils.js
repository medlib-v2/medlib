import Vue from 'vue'

let id = 0;

const createElm = () => {
    const elm = document.createElement('div');

    elm.id = 'app' + ++id;
    document.body.appendChild(elm);

    return elm;
};

/**
 * Destroy vm
 * @param  {Object} vm
 */
export const destroyVM = (vm) => {
    vm.$el &&
    vm.$el.parentNode &&
    vm.$el.parentNode.removeChild(vm.$el);
};

/**
 * Create an instance of Vue
 * @param  {Object|String} Compo   - component configuration, can be directly pass template
 * @param  {Boolean=false} mounted - Whether to add to the DOM
 * @return {Object} vm
 */
export const createVue = (Compo, mounted = false) => {
    if (Object.prototype.toString.call(Compo) === '[object String]') {
        Compo = { template: Compo };
    }
    return new Vue(Compo).$mount(mounted === false ? null : createElm());
};

/**
 * Create an instance of Vue
 * @param Compo
 * @return {Vue}
 */
export const mount = (Compo) => {
    const Ctor = Vue.extend(Compo);
    const propsData = Compo.$propsDataInjection;
    return new Ctor({ propsData }).$mount();
};

/**
 * To Make State Injections
 * @param Compo
 * @param injections
 * @return {*}
 */
export const injectState = (Compo, injections) => {
    const defaultValue = Compo.data ? Compo.data() : {};
    Compo.data = function () {
        return {
            ...defaultValue,
            ...injections
        }
    };
    return Compo
};

/**
 * To Make a Mock Injection for default Injections
 * @param injects
 * @return {*}
 */
export const defaultInjections = (injects) => {

    // If No Injections
    let injections = {
        'vuex': {
            mapStates: () => {},
            mapActions: () => {},
            mapGetters: () => {}
        },
        'vuex-saga': {
            mapSagas: () => {}
        }
    }

    if (!injects) return { injections, stateInjections: {}, propsData: {} };


    // If there's an injection
    // Destruct
    const internal = {};
    const others = {};
    const keys = Object.keys(injects);
    keys.forEach((key) => {
        if (
            key !== 'states'
            && key !== 'actions'
            && key !== 'getters'
            && key !== 'sagas'
            && key !== 'propsData'
        ) {
            others[key] = injects[key]
        } else {
            internal[key] = injects[key]
        }
    });

    // Vuex Injections
    if (internal['sagas']) injections['vuex-saga'].mapSagas = () => internal['sagas'];
    if (internal['actions']) injections['vuex'].mapActions = () => internal['actions'];

    // Others injections
    if(typeof others === 'object') injections = {...injections, ...others};

    // If There's some state Injections
    let stateInjections;
    if (internal['getters'] || internal['states']) {
        // Combine Getters and States Injections
        const states = {...internal['getters'], ...internal['states']};

        // Save the state injections
        stateInjections = states
    }

    return { injections, stateInjections, propsData: internal['propsData'] }

};

/**
 * Wrap it all to mock a component constructor
 * @param injector
 * @param injects
 * @return {*}
 */
export const mockComponent = (injector, injects) => {
    const { injections, stateInjections, propsData } = defaultInjections(injects);

    // Inject it!
    let Component = injector({
        ...injections
    });

    // Inject States From getters And states Argumen
    Component = injectState(Component, stateInjections);

    // Inject propsData
    Component.$propsDataInjection = propsData;

    return Component
};

/**
 * Create a test component instance
 * @link http://vuejs.org/guide/unit-testing.html#Writing-Testable-Components
 * @param  {Object}  Compo          - Component object
 * @param  {Object}  propsData      - props data
 * @param  {Boolean=false} mounted  - Whether to add to the DOM
 * @return {Object} vm
 */
export const createTest = (Compo, propsData = {}, mounted = false) => {
    if (propsData === true || propsData === false) {
        mounted = propsData;
        propsData = {};
    }
    const elm = createElm();
    const Ctor = Vue.extend(Compo);
    return new Ctor({ propsData }).$mount(mounted === false ? null : elm);
};

/**
 * Trigger an event
 * mouseenter, mouseleave, mouseover, keyup, change, click
 * @param  {Element} elm
 * @param  {String} name
 * @param  {*} opts
 */
export const triggerEvent = (elm, name, ...opts) => {
    let eventName;

    if (/^mouse|click/.test(name)) {
        eventName = 'MouseEvents';
    } else if (/^key/.test(name)) {
        eventName = 'KeyboardEvent';
    } else {
        eventName = 'HTMLEvents';
    }
    const evt = document.createEvent(eventName);

    evt.initEvent(name, ...opts);
    elm.dispatchEvent
        ? elm.dispatchEvent(evt)
        : elm.fireEvent('on' + name, evt);

    return elm;
};

/**
 * Triggers "mouseup" and "mousedown" events
 * @param {Element} elm
 * @param {*} opts
 */
export const triggerClick = (elm, ...opts) => {
    exports.triggerEvent(elm, 'mousedown', ...opts);
    exports.triggerEvent(elm, 'mouseup', ...opts);

    return elm;
};

/**
 * Create a test component instance
 * @param Component
 */
export const vueTest = (Component) => {
    const Class = Vue.extend(Component);

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
};

/**
 *
 * @param vm
 * @return {Promise}
 */
export const nextTick = (vm) => {
    return new Promise((resolve) => {
        if (!vm) Vue.nextTick(resolve);
        else vm.$nextTick(resolve)
    })
};

/**
 *
 * @param timeout
 * @return {Promise}
 */
export const delay = (timeout) => {
    return new Promise((resolve) => {
        setTimeout(resolve, timeout)
    })
};

export const Mock = (constr, name) => {
    let keys = [];
    for( let key in constr.prototype ) {
        keys.push( key );
    }
    let result = keys.length > 0 ? jasmine.createSpyObj( name || 'mock', keys ) : {};
    result.jasmineToString = () => { return 'mock' + ( name ? ' of ' + name : '' ); };
    return result;
};

export const JasmineHelpers = () => {

    let promise = {};

    promise.promise = new Promise((resolve, reject) => {
        promise.resolve = resolve;
        promise.reject = reject;
    });

    const deferredSuccess = (args) => {
        promise.resolve(args);
        return promise.promise;
    };

    const deferredFailure = (args) => {
        promise.reject(args);
        return promise.promise;
    };

    return {
        deferredSuccess: deferredSuccess,
        deferredFailure: deferredFailure
    };
};