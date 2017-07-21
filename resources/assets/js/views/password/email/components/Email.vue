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
                                <p>{{ trans('passwords.reset_password_subtitle') }}</p>
                                <div class="form-group xs-pt-20" :class="{ 'has-error': form.errors.has('email') }">
                                    <div class="col-md-12">
                                        <input v-model="form.email"
                                               tabindex="1"
                                               type="text"
                                               id="email"
                                               required
                                               class="form-control no-border"
                                               autocomplete="off"
                                               :placeholder="trans('auth.txt.email')">

                                        <has-error :form="form" field="email"></has-error>

                                    </div>
                                </div>

                                <p class="xs-pt-5 xs-pb-20">{{ trans('auth.txt.forgot_email') }}
                                    <router-link :to="{ name: 'contact', exact: true }" rel="nofollow">{{ trans('auth.txt.forgot_email_end') }}</router-link>
                                </p>

                                <div class="form-group xs-pt-5">
                                    <button type="submit" class="btn btn-block btn-primary btn-block btn-xl">
                                        {{ trans('passwords.send_reset_password') }}
                                    </button>
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
    import {Form} from '@/components/Form'
    import Lang from '@/mixins/lang'

    export default {
        name: 'email-rest',
        mixins: [Lang],
        components: {},
        data() {
            return {
                form: new Form({
                    email: '',
                })
            }
        },
        head: {
            title: {
                inner: 'Password forgot'
            },
            meta: [
                // ...
            ]
        },
        methods: {
            submit () {
                this.form.clear();
                this.form.post('/api/password/email').then(({data}) => {
                    console.log(data)
                })
            }
        }
    };
</script>
