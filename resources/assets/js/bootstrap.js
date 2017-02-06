/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */
window.Vue = require('vue');
require('vue-resource');

Vue.config.debug = true;
Vue.config.silent = false;
Vue.config.devtools = true;

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */
import { ls, user } from './services'

Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Setting.csrfToken);
    if (ls.get('jwt-token')) {
        Vue.http.headers.common['Authorization'] = `Bearer ${ls.get('jwt-token')}`;
    }
    next((response) => {
        /**
         * …get the token from the header or response data if exists, and save it.
         */
        const token = null;
        console.log(response.headers, 'response');
        //const token = response.headers.common['Authorization'] || response.body['token'];
        if (token) {
            ls.set('jwt-token', token);
        }

       if (response.status === 400 || response.status === 401) {
           if (!(response.method  === 'post' && /\/me\/?$/.test(response.url))) {
               /**
                * the token must have expired. Log out.
                */
               user.logout();
               window.location.pathname = '/login';
           }
       }
    });
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });

window.GOOGLE_AUTOCOMPLETE_KEY = "AIzaSyASWIWXTQSF8spzI3X3Esk4pnoq-gPoLHQ";
