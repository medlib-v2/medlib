<template lang="html">
    <form accept-charset="UTF-8" method="post" @submit.prevent="changePassword" @keydown="form.errors.clear($event.target.name)">
        <input type="hidden" name="username" :value="user.username" />
        <dl class="form password-confirmation-form">
            <dt><label for="password_old">Ancien mot de passe</label></dt>
            <dd class="input-group" :class="{ 'has-error': form.errors.has('password_current') }">
                <span class="input-group-addon"><icon name="lock" /></span>
                <input id="password_old" class="form-control" v-model="form.password_current" required="required" type="password" autocomplete="off">
            </dd>
        </dl>
        <dl class="form password-confirmation-form">
            <dt><label for="password_new">Nouveau mot de passe</label></dt>
            <dd class="input-group" :class="{ 'has-error': form.errors.has('password_new') }">
                <span class="input-group-addon"><icon name="lock" /></span>
                <input  id="password_new" class="form-control" v-model="form.password_new" required="required" type="password" autocomplete="off">
            </dd>
        </dl>
        <dl class="form password-confirmation-form">
            <dt><label for="password_confirm">Confirmer le nouveau mot de passe</label></dt>
            <dd class="input-group" :class="{ 'has-error': form.errors.has('password_confirm') }">
                <span class="input-group-addon"><icon name="lock"/></span>
                <input id="password_confirm" class="form-control" v-model="form.password_confirm" required="required" type="password" autocomplete="off">
            </dd>
        </dl>
        <p>
            <button class="btn" tabindex="2">Mettre à jour</button>
        </p>
    </form>
</template>

<script type="text/babel">
    import {Form} from '@/components/Form';
    import Lang from '@/mixins/lang';

    export default {
        name: 'ChangePassword',

        mixins: [Lang],

        props: {
            user: {
                type: Object,
                required: true
            }
        },

        data () {
            return {
                form: new Form({
                    username: this.user.username,
                    password_current: '',
                    password_new: '',
                })
            }
        },

        methods: {
            changePassword () {
                this.form.clear();
                this.form.post('/api/password/email').then(({data}) => {
                    console.log(data)
                })
            }
        }
    }
</script>
