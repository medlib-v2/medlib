<template lang="html">
    <div class="be-wrapper be-float-sidebar be-header-fixed" id="app">
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
    import SiteHeader from './components/SiteHeader.vue'
    import SiteFooter from './components/SiteFooter.vue'
    import { mapActions } from 'vuex'
    import { jwtToken } from './utils'

    export default {
        components: {
            SiteHeader,
            SiteFooter
        },
        created () {
            if (jwtToken.hasToken()) {
                let user = jwtToken.getUserData();
                this.setUserAuth(user);
            }
        },

        mounted () {
            //
        },

        methods: {
            ...mapActions({
                setUserAuth: 'user'
            })
        }
    }
</script>