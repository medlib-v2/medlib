import Navbar from './Navbar.vue';
import NavbarUserAuth from './NavbarUserAuth.vue'
import NavbarUserGuest from './NavbarUserGuest.vue'

/* istanbul ignore next */
Navbar.install = (Vue) => {
    Vue.component(Navbar.name, Navbar);
    Vue.component(NavbarUserAuth.name, NavbarUserAuth);
    Vue.component(NavbarUserGuest.name, NavbarUserGuest);
};

export default Navbar;