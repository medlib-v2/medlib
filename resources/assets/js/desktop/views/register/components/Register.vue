<template lang="html">
    <div class="main-content container-fluid">
        <main id="content" class="content" role="main">
            <section class="splash-container sign-up animated fadeInUp">
                <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="row">
                        <div class="col-md-5 hidden-xs">
                            <div class="panel-heading">
                                <div id="main-title" class="text-center">
                                    <router-link :to="{ name: 'home', exact: true }" rel="nofollow"><h2>{{ trans('auth.medlib_title') }}</h2></router-link>
                                </div>
                            </div>
                            <div class="panel-body">
                                <img src="/images/carte_monde.png" class="img-responsive" alt="Logo Medlib">
                            </div>
                        </div>
                        <div class="col-md-1 hidden-xs"></div>
                        <div id="registration-form" class="col-md-6">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <alert-errors :form="form"></alert-errors>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <h2>Register</h2>
                                        <header>
                                            <br><div v-html="trans('auth.medlib_register_message')"></div><br>
                                        </header>
                                    </div>
                                    <!-- Register form -->
                                    <form @submit.prevent="submit"
                                          @keydown="form.errors.clear($event.target.name)"
                                          class="form-horizontal"
                                          accept-charset="UTF-8"
                                          enctype="multipart/form-data"
                                          role="form">

                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group" :class="{ 'has-error': form.errors.has('first_name') }">
                                            <label class="control-label sr-only" for="first_name">First Name</label>
                                            <input v-model="form.first_name"
                                                   tabindex="1"
                                                   type="text"
                                                   id="first_name"
                                                   required
                                                   pattern="[a-zA-Z\s]{3,64}"
                                                   class="form-control input-lg"
                                                   :placeholder="trans('auth.txt.first_name')">

                                            <has-error :form="form" field="first_name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group" :class="{ 'has-error': form.errors.has('last_name') }">
                                            <label class="control-label sr-only" for="last_name">Last Name</label>
                                            <input v-model="form.last_name"
                                                   tabindex="2"
                                                   type="text"
                                                   id="last_name"
                                                   required
                                                   :placeholder="trans('auth.txt.last_name')"
                                                   pattern="[a-zA-Z\s]{3,64}"
                                                   class="form-control input-lg">

                                            <has-error :form="form" field="last_name"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group" :class="{ 'has-error': form.errors.has('username') }">
                                            <input v-model="form.username"
                                                   tabindex="3"
                                                   type="text"
                                                   id="username"
                                                   required
                                                   :placeholder="trans('auth.txt.login')"
                                                   pattern="[a-zA-Z0-9]{2,64}"
                                                   class="form-control input-lg">

                                            <has-error :form="form" field="username"></has-error>
                                        </div>
                                        <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                                            <input v-model="form.email"
                                                   tabindex="4"
                                                   type="email"
                                                   id="email"
                                                   required
                                                   :placeholder="trans('auth.txt.email_placeholder')"
                                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                                   class="form-control input-lg">

                                            <has-error :form="form" field="email"></has-error>
                                        </div>
                                        <div class="form-group" :class="{ 'has-error': form.errors.has('email_confirm') }">
                                            <input v-model="form.email_confirm"
                                                   tabindex="5"
                                                   type="email"
                                                   id="email_confirm"
                                                   required
                                                   :placeholder="trans('auth.txt.email_confirm_placeholder')"
                                                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                                   class="form-control input-lg">

                                            <has-error :form="form" field="email_confirm"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                                            <input v-model="form.password"
                                                   tabindex="6"
                                                   type="password"
                                                   id="password"
                                                   required
                                                   autocomplete="off"
                                                   :placeholder="trans('auth.txt.password')"
                                                   pattern=".{6,}"
                                                   class="form-control input-lg">
                                            <span class="hideShowPassword-toggle"></span>
                                            <has-error :form="form" field="password"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group" :class="{ 'has-error': form.errors.has('password_confirm') }">
                                            <input v-model="form.password_confirm"
                                                   tabindex="7"
                                                   type="password"
                                                   id="password_confirm"
                                                   required
                                                   autocomplete="off"
                                                   :placeholder="trans('auth.txt.password_confirm')"
                                                   pattern=".{6,}"
                                                   class="form-control input-lg">
                                            <span class="hideShowPassword-toggle"></span>
                                            <has-error :form="form" field="password_confirm"></has-error>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class=""><p><strong>{{ trans('auth.txt.profession.title') }}</strong></p></div>

                                                <div class="form-group" :class="{ 'has-error': form.errors.has('profession') }">
                                                    <select
                                                            v-model="form.profession"
                                                            :placeholder="trans('auth.txt.profession.placeholder')"
                                                            class="form-control input-lg"
                                                            required
                                                            tabindex="8"
                                                            style="padding: 5px">
                                                        <option value disabled>Profession</option>
                                                        <option v-for="(option, idx) in options" :value="option.name">
                                                            {{ option.placeholder }}
                                                        </option>
                                                    </select>
                                                    <has-error :form="form" field="profession"></has-error>
                                                </div>
                                            </div>
                                            <!-- /Birthday -->
                                            <div class="col-md-7">
                                                <div class=""><p><strong>{{ trans('auth.txt.birthday.title') }}</strong></p></div>
                                                <div class="col-xs-4 col-md-4 col-sm-4 col-md-4">
                                                    <div class="form-group no-margin" :class="{ 'has-error': form.errors.has('day') }">
                                                        <select
                                                                v-model="form.day"
                                                                id="birthday_day"
                                                                :placeholder="trans('auth.txt.birthday.day')"
                                                                class="form-control input-lg"
                                                                required
                                                                tabindex="9"
                                                                :title="trans('auth.txt.birthday.day')"
                                                                style="padding: 5px">
                                                            <option value disabled>{{ trans('auth.txt.birthday.day') }}</option>
                                                            <option v-for="(day, idx) in days" :value="day">
                                                                {{ day }}
                                                            </option>
                                                        </select>
                                                        <has-error :form="form" field="day"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4 col-md-4 col-sm-4 col-md-4">
                                                    <div class="form-group no-margin" :class="{ 'has-error': form.errors.has('month') }">
                                                        <select
                                                                v-model="form.month"
                                                                id="birthday_month"
                                                                :placeholder="trans('auth.txt.birthday.month')"
                                                                class="form-control input-lg"
                                                                required
                                                                tabindex="10"
                                                                :title="trans('auth.txt.birthday.month')"
                                                                style="padding: 5px">
                                                            <option value disabled>{{ trans('auth.txt.birthday.month') }}</option>
                                                            <option v-for="(month, idx) in months" :value="month.value">
                                                                {{ month.month }}
                                                            </option>
                                                        </select>
                                                        <has-error :form="form" field="month"></has-error>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4 col-md-4 col-sm-4 col-md-4">
                                                    <div class="form-group no-margin" :class="{ 'has-error': form.errors.has('year') }">
                                                        <label for="year" class="sr-only">{{ trans('auth.txt.birthday.year') }}</label>
                                                        <input v-model.number="form.year"
                                                               class="form-control input-lg"
                                                               :placeholder="trans('auth.txt.birthday.year')"
                                                               pattern="[0-9]{4}"
                                                               name="year"
                                                               type="text"
                                                               id="birthday_year"
                                                               :title="trans('auth.txt.birthday.year')"
                                                               tabindex="11"
                                                               required>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a class="mlm" href="#auth.reg_birthday"
                                                       title="Cliquez ici pour plus d’informations"
                                                       rel="async" role="button">Pourquoi dois-je indiquer ma date de naissance ?</a>
                                                </div>
                                            </div>
                                            <!-- /Birthday -->
                                            <!-- Gender -->
                                            <div class="col-md-7">
                                                <div class="widget-body">
                                                    <div class="row">
                                                        <div class="col-xs-6 col-md-8 col-sm-6">
                                                            <div class="register-switch">
                                                                <input type="radio" v-model="form.gender" name="gender" value="male" id="sex-male" class="register-switch-input" checked>
                                                                <label for="sex-male" class="register-switch-label"><span class="register-switch-icon-male">&nbsp;</span>&nbsp;{{ trans('auth.txt.gender.male') }}</label>
                                                                <input type="radio" v-model="form.gender" name="gender" value="female" id="sex-female" class="register-switch-input">
                                                                <label for="sex-female" class="register-switch-label"><span class="register-switch-icon-female">&nbsp;</span>&nbsp;{{ trans('auth.txt.gender.female') }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Gender -->
                                        </div>
                                    </div>
                                    <!-- Image profile -->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group" :class="{ 'has-error': form.errors.has('profileimage') }">
                                            <label for="fileupload"><strong>{{ trans('auth.txt.profile_image') }}</strong></label>
                                            <upload-image id="fileupload" :show-icon="showIcon" info="Minimum width 700px, will be cropped to 16:9"  v-model="form.profileimage"></upload-image>
                                            <has-error :form="form" field="profileimage"></has-error>
                                        </div>
                                    </div>
                                    <!-- /Image profile -->
                                    <!-- ReCaptcha -->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <recaptcha ref="recaptcha"
                                                   :sitekey="siteKey"
                                                   @verify="onVerify"
                                                   @expired="onExpired" v-model="form.recaptcha_response"/>
                                    </div>
                                    <!--  /ReCaptcha -->
                                    <!-- Submit btn -->
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group xs-pt-10">
                                            <hr class="colorgraph" style="border-top:1px #ccc solid">
                                            <button type="submit" class="btn btn-block btn-success btn-lg">{{ trans('auth.txt.sing_up') }}</button>
                                        </div>
                                    </div>
                                    <!-- /Submit btn -->
                                    </form>
                                    <!-- /Register form -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <modal :id="modal" :showFooter="showFooter">
            <div class="text-center">
                <div class="text-success"><span class="modal-main-icon fa fa-check"></span></div>
                <h3>Awesome!</h3>
                <p>{{ msgInfo }}.<br>{{ msgSuccess }}.</p>
                <div class="xs-mt-50">
                    <b-button variant="success" class="btn-space" @click.prevent="close">OK</b-button>
                </div>
            </div>
        </modal>
    </div>
</template>

<script type="text/babel">
    import { Form } from '@/components/Form';
    import UploadImage from '@/components/UploadImage.vue';
    import Lang from '@/mixins/lang';
    import reCAPTCHA from '@/mixins/reCAPTCHA';
    import Recaptcha from '@/plugins/Recaptcha';

    export default {
        name: 'Register',

        components: {
            UploadImage,
            Recaptcha
        },

        mixins: [Lang, reCAPTCHA],

        data () {
            return {
                showIcon: true,
                showFooter: false,
                modal: 'modal1',
                msgInfo: '',
                msgSuccess: '',
                form: new Form({
                    first_name: '',
                    last_name: '',
                    username: '',
                    email: '',
                    email_confirm: '',
                    password: '',
                    password_confirm: '',
                    profession: '',
                    day: '',
                    month: '',
                    year: '',
                    gender: 'male',
                    profileimage: '',
                    recaptcha_response: ''
                })
            }
        },

        head: {
            title: {
                inner: 'Register'
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
            options () {
                return [
                    { name: 'student', placeholder: trans('auth.txt.profession.student')},
                    { name: 'teacher', placeholder: trans('auth.txt.profession.teacher')},
                    { name: 'researcher', placeholder: trans('auth.txt.profession.researcher')}
                ]
            },
            months () {
                return [
                    { value: 1, month: 'Janvier'},
                    { value: 2, month: 'Février'},
                    { value: 3, month: 'Mars'},
                    { value: 4, month: 'Avril'},
                    { value: 5, month: 'Mai'},
                    { value: 6, month: 'Juin'},
                    { value: 7, month: 'Juillet'},
                    { value: 8, month: 'Aout'},
                    { value: 9, month: 'Septembre'},
                    { value: 10, month: 'Octobre'},
                    { value: 11, month: 'Novembre'},
                    { value: 12, month: 'Décembre'}
                ]
            },
            days () {
                let days = [], start = 1, dayLength = 31, end = dayLength, cNum;
                cNum = end - start + 1;
                for( ; start <= end; start++){
                    days.push(start);
                }

                return days
            },
            siteKey() {
                return '6LdcfxEUAAAAAGlFMOPaWgqsBoWxM7nTbeyTsrvS'
            }
        },

        methods: {
            /**
             * Ensure modal closes
             **/
            close () {
                this.$root.$emit('hide::modal', this.modal);
                this.$router.push({ name: 'login' });
            },
            /**
             * Submit all information to server
             * and receive a response from this one
             **/
            submit () {
                this.form.clear();
                this.form.register().then(({ data }) => {
                    let { info, success } = data;
                    this.msgInfo = info;
                    this.msgSuccess = success;
                    this.$root.$emit('show::modal', this.modal);
                }).catch(error => console.log(error, 'error submit'))
            }
        }
    };
</script>
