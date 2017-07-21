import Register  from '../components/Register.vue';

export default {
    path: '/register',
    name: 'register',
    meta: {
        requiresGuest: true,
        showProgressBar: true
    },
    component: Register
}
