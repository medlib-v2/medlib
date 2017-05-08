import Profile  from '../components/Profile.vue';

export default {
    path: '/setting/profile',
    name: 'profile',
    meta: {
        requiresAuth: true,
        showProgressBar: true
    },
    component: Profile
}
