<template lang="html">
    <div class="main">
        <div class="panel panel-default">
            <div class="list-group-item active"><span class="menu-heading">Votre profil</span></div>
            <div class="list-group-item">
                <div class="row">
                    <div class="boxed-group col-xs-12 col-sm-3 col-md-3">
                        <div class="form-group">
                            <div><label>Photo du profil</label></div>
                            <div class="be-upload clearfix">
                                <div class="img-responsive">
                                    <img alt="img_username_profile" class="img-thumbnail" :src="user.user_avatar"  width="200">
                                </div>
                                <div>
                                    <!-- avatar-upload -->
                                    <form @submit.prevent="runUploadFile" @keydown="form.errors.clear($event.target.name)" enctype="multipart/form-data">
                                        <div class="edit-pic">
                                            <b-button class="btn be-button-mdl" tabindex="4" v-modal.mdlUploadAvatar rel="facebox">
                                                <span class="be-button-icon"><i class="fa fa-camera-retro"></i> Changer de photo</span>
                                            </b-button>
                                        </div>

                                        <modal className="colored-header colored-header-primary"
                                               id="mdlUploadAvatar"
                                               @ok="runUploadFile"
                                               @shown="cancelUpload"
                                               closeTitle="Annuler"
                                               okTitle="Upload image"
                                               tabindex="-1"
                                               :showHeader="showHeader"
                                               title="Upload an Avatar"
                                               okVariant="primary">

                                            <label for="fileupload">Select an avatar image from your hard-disk (will be scaled to 180x180 px, only .jpg currently):</label>
                                            <UploadImage
                                                    id="fileupload" :show-icon="showIcon"
                                                    info="Minimum width 700px, will be cropped to 16:9"
                                                    v-model="form.avatar_file"
                                                    accept="image/jpg,image/JPG,image/JPEG,image/jpeg"
                                            />
                                            <!-- max size 5 MB (as many people directly upload high res pictures from their digital cameras) -->
                                            <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                                            <has-error :form="form" field="avatar_file"></has-error>
                                            <p>Vous pouvez également faire glisser une image à partir de votre ordinateur.</p>
                                        </modal>

                                    </form>
                                    <!-- and avatar-upload -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="boxed-group col-xs-12 col-sm-7 col-md-9">
                        <div class="group-form">
                            <form @submit.prevent="upDateProfile" @keydown="form.errors.clear($event.target.name)" accept-charset="UTF-8">
                                <div class="input-group col-md-12 col-sm-12 col-xs-12"
                                     :class="{ 'has-error': form1.errors.has('first_name') }"> <!-- Prenom -->
                                    <div><label for="first_name">Prénom</label></div>
                                    <input class="form-control"
                                           id="first_name"
                                           name="first_name"
                                           size="30"
                                           :value="user.first_name"
                                           type="text"
                                           readonly>
                                    <!-- v-model="form1.first_name" -->
                                    <has-error :form="form1" field="first_name"></has-error>
                                </div>
                                <div class="input-group col-md-12 col-sm-12 col-xs-12"
                                     :class="{ 'has-error': form1.errors.has('last_name') }"> <!-- Nom -->
                                    <p></p>
                                    <div><label for="last_name">Nom</label></div>
                                    <input class="form-control"
                                           id="last_name"
                                           name="last_name"
                                           size="30"
                                           :value="user.last_name"
                                           type="text"
                                           readonly>
                                    <!-- v-model="form1.last_name" -->
                                </div>
                                <div class="input-group col-md-12 col-sm-12 col-xs-12"
                                     :class="{ 'has-error': form1.errors.has('email') }"> <!--- Public email -->
                                    <p></p>
                                    <div><label for="email">Public email</label></div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-5">
                                            <select2 v-model="form1.email"
                                                     id="email"
                                                     name="email"
                                                     :options="options"
                                                     :data-placeholder="user.email"
                                                     class="form-control select2-offscreen"
                                                     required>
                                                <option :value="user.email" selected="selected">{{ user.email }}</option>
                                            </select2>
                                        </div>
                                        <div class="col-sm-12 col-md-7">
                                            <p class="">Vous pouvez modifier votre adress email dans vos <router-link :to="{ name: 'email', exact: true }">paramètres d'email personnel</router-link>.</p>
                                        </div>
                                    </div>
                                    <p></p>
                                    <button type="submit" class="btn btn-primary">Mise à jour du profil</button>
                                    <p></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="list-group-item active"><span class="menu-heading">Mon profil</span></div>
            <div class="list-group-item">
                <div class="row">
                    <div class="boxed-group col-xs-12 col-sm-12 col-md-12">
                        <div class="group-form">
                            <form accept-charset="UTF-8" action="#" method="post">
                                <div class="input-group col-md-12 col-sm-12 col-xs-12"> <!-- About me -->
                                    <div><label for="first_name">A propos de moi</label></div>
                                    <textarea class="form-control" id="about"  name="about" cols="30" rows="10" :value="user.profile.about" required readonly>{{ user.profile.about }}</textarea>
                                </div>
                                <div class="input-group col-md-12 col-sm-12 col-xs-12"> <!-- Location -->
                                    <p></p>
                                    <div><label for="last_name">Location</label></div>

                                    <input class="form-control" id="location" name="location" size="30" :value="user.profile.location" type="text" readonly>
                                </div>
                                <div class="input-group col-md-12 col-sm-12 col-xs-12"> <!--- Save your information -->
                                    <p></p>
                                    <button type="submit" class="btn btn-primary">Enregistrez vos informations</button>
                                    <p></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script type="text/babel">
    import Lang from '@/mixins/lang';
    import { mapGetters } from 'vuex';
    import { Form } from '@/components/Form';
    import UploadImage from '@/components/UploadImage.vue';
    import  Select2 from '@/components/Select2.vue';

    export default {
        name: 'Admin',
        components: {
            UploadImage,
            Select2
        },

        mixins: [Lang],

        data () {
            return {
                showIcon: true,
                showHeader: true,
                form: new Form({
                    avatar_file: '',
                    MAX_FILE_SIZE: 5000000,
                }),
                form1: new Form({
                    email: '',
                    first_name: '',
                    last_name: ''
                })
            }
        },

        head: {
            title: {
                inner: 'Admin'
            },
            meta: [
                // ...
            ]
        },

        computed: {
            ...mapGetters({
                user: 'getUserAuth'
            }),
            options() {
                return {
                    email: this.user.email
                }
            },
        },


        methods: {
            runUploadFile () {
                this.form.clear();
                if (this.form.avatar_file !== '') {
                    this.form.put(`/api/setting/${this.user.username}/delete`).then(({data}) => {
                        console.log(data);
                        //this.$root.$emit('hide::modal', 'mdlUploadAvatar');
                    }).catch((error) => {
                        console.log(error);
                        this.$root.$emit('shown::modal', 'mdlUploadAvatar');
                    });
                }
            },

            cancelUpload () {
                this.form.avatar_file = null
            },

            upDateProfile () {

            }
        }
    };
</script>
