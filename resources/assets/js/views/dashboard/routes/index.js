import Dashboard  from '../components/Dashboard.vue';

export default {
    path: '/dashboard',
    name: 'dashboard',
    meta: { requiresAuth: true },
    component: Dashboard
}
