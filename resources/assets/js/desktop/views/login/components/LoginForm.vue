<template lang="html">
    <div>
        <form @submit.prevent="login" @keydown="form.errors.clear($event.target.name)">
            <alert-error :form="form"/>
            <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                <input v-model="form.email"
                       type="text"
                       name="email"
                       id="username"
                       tabindex="1"
                       required
                       autocomplete="off"
                       :placeholder="trans('auth.txt.email')"
                       class="form-control">
                <has-error :form="form" field="email"></has-error>
            </div>
            <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                <input type="password"
                       class="form-control"
                       id="password" v-model="form.password"
                       :placeholder="trans('auth.txt.password')"
                       autocomplete="off"
                       pattern=".{6,}"
                       required
                       tabindex="2">
                <span class="hideShowPassword-toggle"></span>
                <has-error :form="form" field="password"></has-error>
            </div>

            <div class="form-group row login-tools">
                <div class="col-xs-6 login-remember">
                    <div class="checkbox">
                        <label for="remember" class="be-checks">
                            <input v-model="form.remember_me" type="checkbox" name="remember_me" id="remember">
                            <i class="remember"></i>{{ trans('auth.txt.remember_me') }}</label>
                    </div>
                </div>
                <div class="col-xs-6 login-forgot-password">
                    <router-link :to="{ name: 'password-reset', exact: true }" class="btn btn-link">{{ trans('auth.btn.forgot_password') }}</router-link>
                </div>
            </div>
            <div class="form-group login-submit">
                <button id="submit" type="submit" class="btn btn-success btn-block btn-xl">{{ trans('auth.btn.login') }}</button>
            </div>
        </form>
    </div>
</template>

<script type="text/babel">
    import { Form } from '@/components/Form'
    import Lang from '@/mixins/lang'
    import Login from '@/mixins/login'

    export default {
        name: 'login-form',
        mixins: [Lang, Login],
        data(){
            return {
                form: new Form({
                    email: '',
                    password: '',
                    remember_me: false
                })
            }
        }
    }
</script>