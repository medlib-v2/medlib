import Login  from '../components/Login.vue';

export default {
    path: '/login',
    name: 'login',
    meta: { requiresGuest: true },
    component: Login
}
