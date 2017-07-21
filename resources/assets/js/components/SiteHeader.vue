<template lang="html">
    <Navbar  id="header" class="navbar navbar-default navbar-fixed-top be-top-header box-shadow" role="navigation">
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
            <NavbarUserGuest v-if="!authenticated"/>
            <NavbarUserAuth v-else/>
            <!-- / navbar collapse -->
        </nav>
    </Navbar>
</template>

<script type="text/babel">
    import NavbarUserGuest from './Navbar/NavbarUserGuest.vue';
    import NavbarUserAuth from './Navbar/NavbarUserAuth.vue';
    import {mapGetters} from 'vuex'

    export default {
        name: 'siteHeader',
        components: {
            NavbarUserGuest,
            NavbarUserAuth
        },

        computed: {
            ...mapGetters(['authenticated'])
        }
    };
</script>
