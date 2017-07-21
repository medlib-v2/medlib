<template lang="html">
    <div class="list-group-item">
        <div class="boxed-group-inner">
            <p>Changer le nom d'utilisateur</p>
            <p>
                <b-button class="btn" v-modal.mdlscale rel="facebox">Changer le nom d'utilisateur</b-button>
            </p>
            <modal className="colored-header colored-header-primary"
                   id="mdlscale"
                   @ok="changeUsername"
                   @shown="clearUsername"
                   closeTitle="Annuler"
                   okTitle="Changer"
                   :showHeader="showHeader"
                   title="Changer le nom d'utilisateur">
                <p>Entrer un nouveau nom d'utilisateur</p>
                <form accept-charset="UTF-8" @submit.prevent="changeUsername" @keydown="form.errors.clear($event.target.name)">
                    <div style="margin-bottom: 25px" class="input-group" :class="{ 'has-error': form.errors.has('username') }">
                        <span class="input-group-addon"><icon name="user"/></span>
                        <input v-model="form.username"
                               tabindex="1"
                               type="text"
                               pattern="[a-zA-Z\s]{3,64}"
                               id="username"
                               required
                               autofocus
                               class="form-control"
                               aria-label= "Entrez un nouveau nom d'utilisateur"
                               :placeholder="trans('auth.txt.login')">

                        <has-error :form="form" field="username"></has-error>
                    </div>
                </form>
            </modal>
        </div>
    </div>
</template>

<script type="text/babel">
    import {Form} from '@/components/Form';
    import Lang from '@/mixins/lang';

    export default {
        name: 'ChangeUsername',

        mixins: [Lang],

        props: {
            user: {
                type: Object,
                required: true
            }
        },

        data () {
            return {
                showHeader: true,
                form: new Form({
                    username: this.user.username,
                })
            }
        },

        methods: {
            clearUsername () {
                this.form.username = '';
            },

            changeUsername () {
                this.form.clear();
                if (this.form.username !== this.user.username) {
                    this.form.post('/api/settings/username').then(({data}) => {
                        console.log(data);
                    });
                }
            }
        }
    }
</script>
