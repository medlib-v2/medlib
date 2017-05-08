<template lang="html">
    <div class="be-wrapper be-float-sidebar be-header-fixed" id="app">
        <nprogress-container></nprogress-container>
        <site-header/>
        <!-- main content -->
        <main class="be-content">
            <div class="main-content content-search">
                <router-view></router-view>
            </div>
        </main>
        <br>
        <!-- <site-footer/> -->
        <!-- / end main content -->
    </div>
</template>

<script type="text/babel">
    import NprogressContainer from '@/components/Nprogress/Nprogress.vue'
    import SiteHeader from '@/components/SiteHeader.vue'
    import SiteFooter from '@/components/SiteFooter.vue'
    import { mapActions } from 'vuex'
    import { jwtToken } from '@/utils'
    import { user as http } from '@/services';

    export default {
        components: {
            NprogressContainer,
            SiteHeader,
            SiteFooter
        },
        created () {
            if (jwtToken.hasToken() && jwtToken.isAuthenticated()) {
                let user = jwtToken.getUserData();
                this.setUserAuth(user);
            } else if (jwtToken.hasToken()) {
                http.logout().then((response) => {
                    jwtToken.removeToken();
                    jwtToken.removeUserData();
                    this.$store.dispatch('SET_AUTH_USER_LOGOUT', {});
                    this.$router.replace({
                        name: 'login'
                    })
                })
            }
        },

        mounted () {
            //
        },

        methods: {
            ...mapActions(['setUserAuth'])
        }
    }
</script>