import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from '../views';
import Middleware from './middlewares'

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'is-active',
    scrollBehavior: () => ({ y: 0 }),
    routes
});

Middleware(router);

export default router;