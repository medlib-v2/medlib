<template lang="html">
    <!-- navbar collapse -->
    <div id="navbar" class="be-right-navbar collapse navbar-collapse bg-white-only">
        <!-- buttons -->
        <ul class="nav navbar-nav be-navbar-toggle hidden-xs">
            <li><a class="be-toggle-left-sidebar" href="#"
                   data-sn-action="toggle-navigation-state"
                   title="" data-placement="bottom"
                   data-tooltip=""
                   data-original-title="Turn on/off sidebar collapsing"><i class="fa fa-bars fa-lg"></i></a></li>
        </ul>
        <el-search
                :suggestion-attribute="suggestionAttribute"
                v-model="form.search"
                :disabled="false"
                @input="changed"
                @click-input="clickInput"
                @click-button="clickButton"
                @selected="selected"
                @enter="enter"
                @key-up="keyUp"
                @key-down="keyDown"
                @key-right="keyRight"
                @clear="clear"
                @escape="escape"
                :show-autocomplete="true"
                :autofocus="false"
                :suggestions="suggestions"
                name="customName"
                placeholder="custom placeholder"
                type="facebook"></el-search>
        <!-- / buttons -->
        <ul class="nav navbar-nav navbar-right be-user-nav">
            <!-- user profile -->
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
                    <img class="img-circle" data-src="js/holder.js/32%x32%" :src="user.user_avatar" :alt="user.full_name">
                    <span class="user-name">{{ user.first_name }} <strong>{{ user.last_name }}</strong></span>
                </a>
                <ul role="menu" class="dropdown-menu animated fadeInUp" id="notifications-dropdown-menu">
                    <li>
                        <div class="user-info">
                            <div class="user-name">{{ user.first_name }} <strong>{{ user.last_name }}</strong></div>
                            <div v-if="user.onlinestatus" class="user-position online">{{ trans('auth.available') }}</div>
                            <div v-else class="user-position offline">{{ trans('auth.unavailable') }}</div>

                        </div>
                    </li>
                    <li><a href="#profile.user.show/getUsername" class="text-small"><span class="glyphicon glyphicon-user"></span>&nbsp;Afficher mon profil</a></li>
                    <li><a href="#dashboard.home" class="text-small"><span class="glyphicon glyphicon-dashboard"></span>&nbsp;Dashbord</a></li>
                    <li><a href="#profile.show.settings"><span class="glyphicon glyphicon-lock"></span>&nbsp;Paramètres</a></li>
                    <li><a href="javascript:void(0)" @click.prevent="logout"><i class="glyphicon glyphicon-off"></i>&nbsp;Se déconnecter</a></li>
                </ul>
            </li>
            <!-- / user profile -->
        </ul>
        <notifications link-notifications="#notifications.show" :id="user.id"></notifications>
    </div>
    <!-- / navbar collapse -->
</template>

<script type="text/babel">
    import lang from '@/mixins/lang'
    import { Form } from './Form'
    import { mapActions, mapGetters } from 'vuex'
    import { user as http } from '@/services';
    import ElSearch from './ElSearch.vue'
    import { Notifications } from './Notifications'
    import { jwtToken } from '@/utils'
    import router from '@/router'

    export default {
        mixins: [lang],
        name: 'navbar-user-auth',
        data(){
            return {
                suggestionAttribute: 'original_title',
                suggestions: [],
                selectedEvent: '',
                form: new Form({
                    search: ''
                })
            }
        },
        components: {
            ElSearch,
            Notifications
        },
        methods: {
            logout() {
                http.logout().then((response) => {
                    jwtToken.removeToken();
                    jwtToken.removeUserData();
                    this.setLogout();
                    console.log('user::logout', response);
                    router.push({name: 'home'})
                })
            },
            clickInput() {
                this.selectedEvent = 'click input'
            },
            clickButton() {
                this.selectedEvent = 'click button'
            },
            selected() {
                this.selectedEvent = 'selection changed'
            },
            enter() {
                this.selectedEvent = 'enter'
            },
            keyUp() {
                this.selectedEvent = 'keyup pressed'
            },
            keyDown() {
                this.selectedEvent = 'keyDown pressed'
            },
            keyRight() {
                this.selectedEvent = 'keyRight pressed'
            },
            clear() {
                this.selectedEvent = 'clear input'
            },
            escape() {
                this.selectedEvent = 'escape'
            },
            changed() {
                let that = this;
                this.suggestions = [];
                this.$http.get('https://api.themoviedb.org/3/search/movie?api_key=342d3061b70d2747a1e159ae9a7e9a36&query=' + this.value)
                        .then((response) => {
                            response.data.results.forEach(function (a) {
                                that.suggestions.push(a)
                            })
                        }).catch((error) => {
                    window.console.log(error)
                })
            },
            ...mapActions(['setLogout'])
        },
        computed: {
            ...mapGetters({
                user: 'getUserAuth'
            })
        }
    }
</script>
