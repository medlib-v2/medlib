import Store from '@/stores';
import { jwtToken } from '@/utils';

const authInterceptor = (router) => {
    router.beforeEach((to, from, next) => {

        if(to.meta.requiresAuth) {
            if(Store.state.authenticated || jwtToken.hasToken())
                return next();
            else
                return next({
                    name: 'login',
                    query: { redirect: to.fullPath }
                });
        }
        if(to.meta.requiresGuest) {
            if(Store.state.authenticated || jwtToken.hasToken())
                return next({name: 'home'});
            else
                return next();
        }
        next();
    });
};

export default authInterceptor