/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */
import Vue from 'vue';
import VueResource from 'vue-resource';
import NProgress from './components/Nprogress';
import MetaHead from './plugins/MetaHead'

Vue.use(VueResource);
Vue.use(NProgress);
Vue.use(MetaHead);

Vue.config.debug = process.env.NODE_ENV !== 'production';
Vue.config.silent = process.env.NODE_ENV === 'production';
Vue.config.devtools = process.env.NODE_ENV !== 'production';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import App from './App.vue';
import store from './stores';
import router from './router';
import { jwtToken } from './utils';
import { user } from './services';
import './directives/DirectivePreview';
import './directives/DirectiveEmojiIcon';
import './directives/DirectiveAutoScroll';
import './directives/DirectiveModal'
import './filters/FiltersTimeago';
import './filters/FiltersEmojiIcon';
import './directives/DirectiveSelect2';
import FastClick from 'fastclick'

/**
 * Register the global components
 */
import {
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from './components/Form';
import './components/InputContainer'
import './components/Button'
import './components/Modal'
//import './components/UploadImage'
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertErrors.name, AlertErrors);
Vue.component(AlertSuccess.name, AlertSuccess);
/**
 * // Register components
 * import * as components from './components';
 for (var component in components) {
            Vue.component(component, components[component]);
        }
 */

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */
Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Setting.csrfToken);
    if (jwtToken.hasToken()) {
        /**
         * Vue.http.headers.common['Authorization'] = `Bearer ${jwtToken.getToken()}`
         */

        let token = jwtToken.getToken();

        if (token && jwtToken.isExpired(token)) {
            /**
             * The token must have expired. Logout.
             */
            user.logout().then((response) => {
                jwtToken.removeToken();
                jwtToken.removeUserData();
                store.dispatch('SET_AUTH_USER_LOGOUT', {});
                router.replace({
                    name: 'login'
                })
            })
        }

        request.headers.set('Authorization', `Bearer ${token}`);
    }
    next((response) => {

        if (Number(response.status) === 400 || Number(response.status) === 401) {
            /**
             * The token must have expired. Logout.
             */
            user.logout().then((response) => {
                jwtToken.removeToken();
                store.dispatch('SET_AUTH_USER_LOGOUT', {});
                router.push({name: 'login'})
            })
        }

        /**
         * @see https://laracasts.com/discuss/channels/vue/jwt-auth-with-vue-resource-interceptor?page=1
        if (response.headers('Authorization') && response.headers('Authorization').startsWith('Bearer ')) {
            let token = response.headers('Authorization').slice('Bearer '.length)
            console.log(token, 'response::token');
            //jwtToken.setToken(token)
        }
        **/
    })
});

const nprogress = new NProgress({ parent: '.nprogress-container' });

window.addEventListener('load', () => {
    FastClick.attach(document.body)
});

/**
 * @type {Vue}
 */
// eslint-disable-line no-new
const app = new Vue({
    name: 'Main',
    el: '#app',
    router,
    store,
    nprogress,
    template: '<App/>',
    render: h => h(App),
    watch: {
        "$route": 'checkAuth'
    },
    methods: {
        checkAuth () {
            if (!jwtToken.hasToken()) {
                //this.user.authenticated = false
                console.log('token d\'ont exist')
            }
            else {
                //this.user.authenticated = true
                console.log('token exist')
            }
        }
    }
});