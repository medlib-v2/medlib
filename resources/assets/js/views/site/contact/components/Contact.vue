<template lang="html">
    <div class="main-content">
        <main id="content" class="content" role="main">
            <section class="splash-container reset-password animated fadeInUp">
                <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading">
                        <header class="wrapper text-center">
                            <h1>Nous contacter</h1>
                        </header>
                    </div>
                    <div class="panel-body">
                        <alert-errors :form="form"></alert-errors>

                        <alert-success :form="form" :message="message_success"></alert-success>

                        <section class="m-b-lg">
                            <form @submit.prevent="submit" @keydown="form.errors.clear($event.target.name)" class="form-horizontal" accept-charset="UTF-8" role="form">

                                <div class="form-group" :class="{ 'has-error': form.errors.has('name') }">
                                    <label for="name" class="label-control"><span class="label-text">Votre nom</span></label>
                                    <input v-model="form.name"
                                           type="text"
                                           name="username"
                                           id="name"
                                           required
                                           placeholder="Votre nom"
                                           class="form-control">
                                    <has-error :form="form" field="name"></has-error>
                                </div>

                                <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                                    <label for="email" class="label-control"><span class="label-text">Votre email</span></label>
                                    <input v-model="form.email"
                                           type="email"
                                           name="email"
                                           id="email"
                                           required
                                           placeholder="Votre email"
                                           class="form-control">
                                    <has-error :form="form" field="email"></has-error>
                                </div>

                                <div class="form-group" :class="{ 'has-error': form.errors.has('message') }">
                                    <label for="message" class="label-control"><span class="label-text">Votre message</span></label>
                                    <textarea v-model="form.message"
                                              type="email"
                                              name="email"
                                              id="message"
                                              required
                                              rows="5"
                                              placeholder="Votre message"
                                              class="form-control"></textarea>
                                    <has-error :form="form" field="message"></has-error>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-block btn-primary btn-block btn-xl">Contacter nous!</button>
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
        mixins: [Lang],

        data () {
            return {
                message_success: '',
                form: new Form({
                    name: '',
                    email: '',
                    message: ''

                })
            }
        },

        head: {
            title: {
                inner: 'Contact'
            },
            meta: [
                // ...
            ]
        },

        methods: {
            submit () {
                this.form.post('api/site/contact').then(({data}) => {
                    this.message_success = data.data.message
                })
            }
        }
    };
</script>
