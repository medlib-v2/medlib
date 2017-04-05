import SearchSimple  from '../components/Simple.vue';

const guardRoute = (to, from, next) => {
    next()
};

export default {
    path: '/search/simple',
    name: 'search.simple',
    meta: {
        showProgressBar: true
    },
    beforeEnter: guardRoute,
    component: SearchSimple
}
