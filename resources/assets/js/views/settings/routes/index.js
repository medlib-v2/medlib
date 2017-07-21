import Setting  from '../components/Setting.vue';
import profile from '../profile/routes/route'
import email from '../email/routes/route'
import admin from '../admin/routes/route'

export default {
    path: '/setting',
    name: 'setting',
    redirect: '/setting/profile',
    children: [ profile, admin, email ],
    meta: {
        requiresAuth: true,
        showProgressBar: true
    },
    component: Setting
}
