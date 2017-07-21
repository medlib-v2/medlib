<template lang="html">
    <div class="list-group">
        <div class="list-group-item active">
            <span class="menu-heading" style="color: #fff;">Paramètres personnels</span>
        </div>
        <div class="list-group-item">
            <!-- SIDEBAR MENU -->
            <div class="profile-usermenu">
                <ul class="nav">
                    <li>
                        <router-link :to="{ name: 'admin', exact: true }"><icon name="cog" />&nbsp;Profil</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'setting', exact: true }"><icon name="user" />&nbsp;Paramètres du compte</router-link>
                    </li>
                    <li>
                        <router-link :to="{ name: 'email', exact: true }"><icon name="envelope" />&nbsp;E-mails</router-link>
                    </li>
                </ul>
                <!-- END MENU -->
            </div><!--list-group-item-->
        </div> <!-- List-group-->
    </div><!-- col-md-3 -->
</template>
<script type="text/babel">
    import Lang from '@/mixins/lang'

    export default {
        name: 'MenuSetting',

        mixins: [Lang]
    }
</script>
