<template lang="html">
    <div class="main-content">
        <main id="content" class="content" role="main">
            <section class="splash-container reset-password animated fadeInUp">
                <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading">
                        <header class="wrapper text-center">
                            <strong>{{ trans('passwords.reset_password') }}</strong>
                        </header>
                    </div>
                    <div class="panel-body">
                        <alert-errors :form="form"></alert-errors>

                        <section class="m-b-lg">
                            <form @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)"
                                  class="form-horizontal" accept-charset="UTF-8" role="form">
                                <input
                                        v-model="form.token"
                                        type="hidden"
                                        name="token"
                                        id="token"
                                >
                                <div class="form-group xs-pt-20" :class="{ 'has-error': form.errors.has('email') }">
                                    <label class="col-md-4 control-label">{{ trans('auth.txt.email') }}</label>
                                    <div class="col-md-8">
                                        <input v-model="form.email"
                                               tabindex="1"
                                               type="text"
                                               id="username"
                                               required
                                               class="form-control no-border"
                                               autocomplete="on"
                                               :placeholder="trans('auth.txt.email')">

                                        <has-error :form="form" field="email"></has-error>

                                    </div>
                                </div>

                                <div class="form-group xs-pt-20" :class="{ 'has-error': form.errors.has('password') }">
                                    <label class="col-md-4 control-label">{{ trans('passwords.password_text') }}</label>
                                    <div class="col-md-8">
                                        <input v-model="form.password"
                                               tabindex="2"
                                               type="password"
                                               id="password_register"
                                               required
                                               class="form-control"
                                               autocomplete="off"
                                               pattern=".{6,}"
                                               :placeholder="trans('passwords.password_text')">

                                        <span class="hideShowPassword-toggle"></span>
                                        <has-error :form="form" field="password"></has-error>
                                    </div>
                                </div>

                                <div class="form-group xs-pt-20"
                                     :class="{ 'has-error': form.errors.has('password_confirmation') }">
                                    <label class="col-md-4 control-label">{{ trans('passwords.password_confirm_text') }}</label>
                                    <div class="col-md-8">
                                        <input v-model="form.password_confirmation"
                                               tabindex="3"
                                               type="password"
                                               name="password_confirmation"
                                               id="password_confirmation"
                                               required
                                               class="form-control"
                                               autocomplete="off"
                                               pattern=".{6,}"
                                               :placeholder="trans('passwords.password_confirm_text')">

                                        <span class="hideShowPassword-toggle"></span>
                                        <has-error :form="form" field="password_confirmation"></has-error>
                                    </div>
                                </div>

                                <div class="form-group xs-pt-5">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <button
                                                type="submit"
                                                class="btn btn-block btn-primary btn-block btn-xl"
                                                :class="{ 'disabled': canSubmit ? false : true }"
                                                :disabled="canSubmit ? false : true">{{ trans('passwords.reset_password') }}</button>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>
<script type="text/babel">
    import { Form } from '@/components/Form'
    import Lang from '@/mixins/lang'

    export default {
        name: 'password-rest',
        mixins: [Lang],
        components: {},
        data() {
            return {
                form: new Form({
                    token: Object.keys(this.$route.query)[0],
                    email: '',
                    password: '',
                    password_confirmation: ''
                })
            }
        },
        head: {
            title: {
                inner: 'Reset Password'
            },
            meta: [
                // ...
            ]
        },
        watch: {
            '$route' (to, from) {
                console.log('route', to, from)
            }
        },
        computed: {
            canSubmit () {
                return this.form.password === this.form.password_confirmation
            }
        },
        methods: {
            submit () {
                this.form.post('/api/password/reset')
                    .then(({ data }) => { console.log(data) })
            }
        }
    };
</script>
