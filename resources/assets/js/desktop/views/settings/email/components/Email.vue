<template lang="html">
    <div class="panel panel-default">
        <div class="list-group-item active"><span class="menu-heading"> E-mail</span></div>
        <div class="list-group-item">
            <div id="settings-emails" class="boxed-group-list standalone">
                <p class="clearfix settings-email primary ">
                    <strong>Actuel</strong>
                    <span class=""><strong>{{ user.email }}</strong></span>
                </p>
            </div>
            <form accept-charset="UTF-8" @submit.prevent="changeEmail" @keydown="form.errors.clear($event.target.name)" class="form-horizontal" role="form">
                <label for="email">Entrer un email</label>
                <div style="margin-bottom: 25px" class="input-group" :class="{ 'has-error': form.errors.has('email') }">
                    <span class="input-group-addon"><icon name="envelope" /></span>
                    <input class="form-control"
                           id="email"
                           v-model="form.email"
                           required
                           size="30"
                           type="email"
                           :placeholder="trans('auth.txt.email')" />
                    <has-error :form="form" field="email"></has-error>
                </div>
                <div style="margin-top:10px" class="btn-group">
                    <!-- Button -->
                    <div class="col-sm-12 controls" style="margin-bottom: 25px">
                        <button id="btn-login" type="submit" class="btn login-submit-button">
                            <icon name="user" />  Changer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script type="text/babel">
    import Lang from '@/mixins/lang'
    import { mapGetters } from 'vuex'
    import { Form } from '@/components/Form'

    export default {
        components: {},

        mixins: [Lang],

        data () {
            return {
                form: new Form({
                    email: ''
                })
            }
        },

        head: {
            title: {
                inner: 'Settings Email'
            },
            meta: [
                // ...
            ]
        },

        computed: {
            ...mapGetters({
                user: 'getUserAuth'
            })
        },

        methods: {
            changeEmail () {
                this.form.clear();
                if (this.form.email !== this.user.email) {
                    this.form.post('/api/settings/email').then(({data}) => {
                        console.log(data);
                        this.form.email = '';
                    });
                }
            }
        }
    };
</script>
