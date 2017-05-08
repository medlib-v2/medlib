import NotFound  from '../components/NotFound.vue';

export default {
    path: 'not*',
    name: 'not-found',
    meta: {
        showProgressBar: true
    },
    component: NotFound
}