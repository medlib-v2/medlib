import Register  from '../components/Register.vue';

export default {
    path: '/register',
    name: 'register',
    meta: { requiresGuest: true },
    component: Register
}
