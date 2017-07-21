import Admin  from '../components/Admin.vue';

export default {
    path: '/setting/admin',
    name: 'admin',
    meta: {
        requiresAuth: true,
        showProgressBar: true
    },
    component: Admin
}
