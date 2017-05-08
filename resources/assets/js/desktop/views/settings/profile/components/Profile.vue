<template lang="html">
    <div class="content">
        <div class="panel panel-default">
            <div class="list-group-item active">Changer le mot de passe</div>
            <div class="list-group-item">
                <ChangePassword :user="user"/>
            </div>
        </div>

        <!-- Change username -->
        <div class="panel panel-default">
            <div class="list-group-item active"> Changer le nom d'utilisateu</div>
            <ChangeUsername :user="user"/>
        </div>

        <!-- Delete account -->
        <div class="panel panel-default">
            <div class="list-group-item active"> Supprimer mon compte</div>
            <DeleteAccount :user="user"/>
        </div>
    </div>
</template>

<script type="text/babel">
    import Lang from '@/mixins/lang';
    import { mapGetters } from 'vuex';
    import ChangePassword from './ChangePassword.vue';
    import ChangeUsername from './ChangeUsername.vue';
    import DeleteAccount from './DeleteAccount.vue';

    export default {
        name: 'Profile',
        mixins: [Lang],
        components: {
            ChangePassword,
            ChangeUsername,
            DeleteAccount
        },

        head: {
            title: {
                inner: 'Settings Profile'
            },
            script: [
                {
                    type: 'text/javascript',
                    src: 'https://www.google.com/recaptcha/api.js?onload=vueRecaptchaApiLoaded&render=explicit',
                    async: true,
                    body: true,
                    defer: true
                },
            ],
            meta: [
                // ...
            ]
        },

        computed: {
            ...mapGetters({
                user: 'getUserAuth'
            })
        }
    };
</script>
