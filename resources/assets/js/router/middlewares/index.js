import authInterceptor from './beforeEach/authInterceptor'

export default (router) => {
    router.beforeEach(authInterceptor(router));
    //router.afterEach()
}