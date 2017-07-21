import Email  from '../components/Email.vue';

export default {
    path: '/setting/email',
    name: 'email',
    meta: {
        requiresAuth: true,
        showProgressBar: true
    },
    component: Email
}
