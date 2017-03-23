import SearchSimple  from '../components/Simple.vue';

const guardRoute = (to, from, next) => {
    next()
};

export default {
    path: '/search/simple',
    name: 'search.simple',
    meta: {},
    beforeEnter: guardRoute,
    component: SearchSimple
}
