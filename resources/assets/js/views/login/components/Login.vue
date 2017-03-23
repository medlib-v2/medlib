<template lang="html">
    <main id="content" class="content" role="main">
        <section class="splash-container animated fadeInUp">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
                <div class="panel-heading">
                    <header class="wrapper text-center">
                        <strong>{{ trans('auth.user_title_login') }}</strong>
                    </header>
                    <span class="splash-description">{{ trans('auth.user_information_login') }}</span>
                </div>
                <div class="panel-body">
                    <login-form/>
                </div>
            </div>
            <div class="line line-dashed"></div>
            <div class="splash-footer">
                <span>{{ trans('auth.txt.dont_have_account') }}
                    <router-link :to="{ name: 'register', exact: true }">{{ trans('auth.txt.sing_up') }}</router-link>
                </span>
            </div>
        </section>
    </main>
</template>

<script type="text/babel">
    import LoginForm from './LoginForm.vue'
    import Lang from '../../../mixins/lang'

    export default {
        components: {
            LoginForm
        },
        mixins: [Lang]
    }
</script>
