<template lang="html">
    <div class="list-group-item">
        <div class="boxed-group-inner">
            <p>Une fois que votre compte supprimé, il n'y a pas de retour possible. Merci d'être certain de vouloir supprimer.</p>
            <p>
                <b-button class="btn btn-danger" tabindex="4" v-modal.mdldelete rel="facebox">Supprimer mon compte</b-button>
            </p>
            <modal className="colored-header colored-header-danger"
                   id="mdldelete"
                   @ok="deleteAccount"
                   @shown="clearDeleteAccount"
                   closeTitle="Annuler"
                   okTitle="Supprimer"
                   tabindex="-1"
                   :showHeader="showHeader"
                   title="Es-tu sûr de vouloir faire ça?"
                   okVariant="danger">
                <div class="text-center">
                    <br>
                    <span class="modal-main-icon fa fa-info-circle"></span>
                    <h4>C'est extrêmement important.</h4>
                </div>
                <form accept-charset="UTF-8" @submit.prevent="deleteAccount" @keydown="form.errors.clear($event.target.name)">
                    <div class="modal-body">
                        <p>Nous allons <strong>supprimer immédiatement votre compte</strong>, ainsi que toutes vos recherches, favories, sur Medlib.</p>
                        <p>Vous ne serez plus membre, et votre nom d'utilisateur sera disponible pour toute personne sur Medlib.</p>
                        <p>Pour plus d'aide, lisez notre article "<router-link :to="{ name: 'helpers.deleting.account', exact: true }">Suppression de votre compte d'utilisateur</router-link>".</p>
                        <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                            <label for="email" class="control-label">Entrez votre email :</label>
                            <input id="email"
                                   v-model="form.email"
                                   class="form-control"
                                   required
                                   type="email"
                                   autocomplete="off">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                            <label for="password" class="control-label">Confirmer votre mot de passe :</label>
                            <input class="form-control"
                                   id="password"
                                   v-model="form.password"
                                   type="password">
                            <has-error :form="form" field="password"></has-error>
                        </div>
                        <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                            <recaptcha ref="recaptcha"
                                       :sitekey="siteKey"
                                       @verify="onVerify"
                                       @expired="onExpired" v-model="form.recaptcha_response"/>
                        </div>
                    </div>
                </form>
            </modal>
        </div>
    </div>
</template>

<script type="text/babel">
    import { Form } from '@/components/Form';
    import Lang from '@/mixins/lang';
    import reCAPTCHA from '@/mixins/reCAPTCHA';
    import Recaptcha from '@/plugins/Recaptcha';

    export default {
        name: 'DeleteAccount',

        components: { Recaptcha },

        mixins: [Lang, reCAPTCHA],

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
                    email: '',
                    password: '',
                    recaptcha_response: ''
                })
            }
        },

        computed: {
            siteKey() {
                return '6LdcfxEUAAAAAGlFMOPaWgqsBoWxM7nTbeyTsrvS'
            }
        },

        methods: {
            clearDeleteAccount () {
                this.form.username = '';
                this.form.password = '';
            },

            deleteAccount () {
                this.form.clear();
                if (this.form.username !== '' && this.form.recaptcha_response !== '') {
                    this.form.delete(`/api/setting/${this.user.username}/delete`).then(({data}) => {
                        console.log(data);
                        this.$root.$emit('hide::modal', 'mdldelete');
                    }).catch((error) => {
                        console.log(error);
                        this.$root.$emit('shown::modal', 'mdldelete');
                    });
                }
            }
        }
    }
</script>
