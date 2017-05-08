<template lang="html">
    <div id="navbar" class="be-right-navbar collapse navbar-collapse bg-white-only">
        <!-- nabar user no login right -->
        <ul  class="nav navbar-nav navbar-right be-user-nav">
            <!-- login user -->
            <li class="dropdown" role="presentation">
                <a href="#" class="be-user-login-dropdown" id="user-login-dropdown" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="thumb-sm avatar"><img class="img-circle" src="/images/user-avatar.png" alt="..."/></span>
                    <span class="user-name">ESPACE PERSONNEL</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu animated fadeInUp login-dropdown-menu" id="login-dropdown-menu">
                    <li class="login-form-dropdown">
                            <div class="row no-margin">
                                <div class="col-md-7 col-sm-7">
                                    <div class="form-group"><h4 class="login-title">{{ trans('auth.btn.login') }}</h4></div>
                                    <form @submit.prevent="login" @keydown="form.errors.clear($event.target.name)" class="form-login" role="login"  accept-charset="UTF-8">
                                        <be-input-container :theme-class="['field', { 'has-error': form.errors.has('email') }]">
                                            <label class="label-control" for="email"><span class="label-text">{{ trans('auth.txt.email') }}</span></label>
                                            <be-input v-model="form.email" type="email" id="email" name="email" value="" required />
                                        </be-input-container>
                                        
                                        <be-input-container be-has-password :theme-class="['field', { 'has-error': form.errors.has('password') }]">
                                            <label class="label-control" for="password"><span class="label-text">{{ trans('auth.txt.password') }}</span></label>
                                            <be-input v-model="form.password" type="password" id="password" name="password" required />
                                        </be-input-container>

                                        <div class="checkbox checkbox-success">
                                            <label for="remember_me" class="be-checks">
                                                <input v-model="form.remember_me" type="checkbox" name="remember_me" class="checkbox-circle" id="remember_me" />
                                                <i class="remember"></i>{{ trans('auth.txt.remember_me') }}</label>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">{{ trans('auth.btn.login') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-1 col-sm-1">
                                    <div class="or-spacer"><span><i>{{ trans('auth.txt.spacer_or') }}</i></span></div>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <ul class="login-via">
                                        <li class="info"><span>{{ trans('auth.account_dont_have') }}</span></li>
                                        <li class="btn-register">
                                            <router-link class="btn btn-primary" type="button" :to="{ name: 'register' }" rel="nofollow" id="sign-in">{{ trans('auth.txt.sing_up') }}</router-link>
                                        </li>
                                        <li class="divider"></li>
                                        <li class="social-buttons">
                                            <a href="/api/auth/facebook" class="btn btn-block btn-social btn-facebook" type="button" id="sign-in-facebook"><span class="fa fa-facebook"></span>Login via Facebook</a>
                                            <a href="/api/auth/twitter" class="btn btn-block btn-social btn-twitter" type="button" id="sign-in-twitter"><span class="fa fa-twitter"></span>Login via Twitter</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="panel-footer text-sm">
                            <span class="fs-login">
                                {{ trans('auth.login.can_not_login') }}
                                <router-link 
                                    type="button" 
                                    :to="{ name: 'password-reset', exact: true }"
                                    >{{ trans('auth.txt.forgot_password') }}</router-link> 
                            </span>
                        </li>
                    </ul>
                </li>
                <!--/ login user -->
            </ul>
            <!-- / nabar user no login right -->

        </div>
</template>

<script type="text/babel">
    import Lang from '@/mixins/lang'
    import Login from '@/mixins/login'
    import { Form } from './Form'

    export default {
        name: 'navbar-user-guest',
        mixins: [Lang, Login],
        data() {
            return {
                type: 'password',
                /**
                 * Create the form instance
                 */
                form: new Form({
                    email: '',
                    password: '',
                    remember_me: false
                })
            }
        },
        methods: {
            /**
            * Toggle the visibilty of the password.
            */
            togglePassword() {
                this.type = this.type === 'password' ? 'text' : 'password';
                this.$refs.input.setAttribute('type', this.type)
            }
        },
        computed: {
            disableToggle() {
                return false
            }
        }
    }
</script>
