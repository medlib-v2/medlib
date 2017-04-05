<template lang="html">
    <nav-bar  id="header" class="navbar navbar-default navbar-fixed-top be-top-header box-shadow" role="navigation">
        <nav class="container-fluid">
            <!-- navbar header -->
            <div class="navbar-header aside-md bg-dark">
                <!-- brand logo -->
                <div class="navbar-brand text-lt">
                    <router-link :to="{ name: 'home', exact: true }" rel="nofollow"><img class="be-logo" alt="Medlib"/></router-link>
                </div>
                <!-- / brand logo -->
            </div>
            <!-- / navbar header -->

            <!-- navbar collapse -->
            <navbar-user-guest v-if="!authenticated"/>
            <navbar-user-auth v-else/>
            <!-- / navbar collapse -->
        </nav>
    </nav-bar>
</template>

<script type="text/babel">
    import NavBar from './Navbar.vue'
    import NavbarUserGuest from './NavbarUserGuest.vue'
    import NavbarUserAuth from './NavbarUserAuth.vue'
    import { mapGetters } from 'vuex'

    export default {
        name: 'site-header',
        components: {
            NavBar,
            NavbarUserGuest,
            NavbarUserAuth
        },

        computed: {
            ...mapGetters(['authenticated'])
        }
    };
</script>
