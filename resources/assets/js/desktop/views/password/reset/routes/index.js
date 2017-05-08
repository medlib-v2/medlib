import Password  from '../components/Password.vue';

export default {
    path: '/password/reset/:token?',
    name: 'password-verify',
    meta: {
        requiresGuest: true,
        showProgressBar: true
    },
    component: Password
}
