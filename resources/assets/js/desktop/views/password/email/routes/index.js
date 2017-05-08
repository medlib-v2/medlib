import Email  from '../components/Email.vue';

export default {
    path: '/password/reset',
    name: 'password-reset',
    meta: {
        requiresGuest: true,
        showProgressBar: true
    },
    component: Email
}
