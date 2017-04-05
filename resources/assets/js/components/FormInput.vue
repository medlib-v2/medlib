<template lang="html">
  <div class="center-form">
        <form role="form" :method="method" :action="action" accept-charset="UTF-8" enctype="multipart/form-data" class="mt" @submit.prevent="submit">
            <div class="form-group mb-0">
                <textarea rows="3" :placeholder="placeholder" v-model="content" cols="50" class="form-control"></textarea>
            </div>
            <div class="share">
                <div class="image" :class="image_hide">
                    <upload-image info="Minimum width 700px, will be cropped to 16:9" @on-change="onChange"></upload-image>
                </div>
                <div class="video" :class="video_hide">
                    <input type="text" class="form-control" placeholder="Youtube or Vimeo video URL" id="videoUrl" name="videoUrl">
                </div>
                <div class="place" :class="place_hide">
                    <google-autocomplete type="input" placeholder="type your address"></google-autocomplete>
                    <span class="help is-danger" v-if="isNotValid()">Select a valid address!</span>
                </div>
            </div>
            <div class="btn-toolbar share-components">
                <div class="clearfix">
                    <div class="btn-group pull-left">
                        <a href="#" class="btn btn-sm btn-gray" @click.prevent="status"><i class="fa fa-file fa-lg"></i></a>
                        <a href="#" class="btn btn-sm btn-gray" @click.prevent="photos"><i class="fa fa-camera fa-lg"></i></a>
                        <a href="#" class="btn btn-sm btn-gray" @click.prevent="video"><i class="fa fa-film fa-lg"></i></a>
                        <a href="#" class="btn btn-sm btn-gray" @click.prevent="place"><i class="fa fa-map-marker fa-lg"></i></a>
                    </div>
                    <div class="btn-group pull-right">
                        <button type="submit" class="btn btn-success pull-right" :disabled="not_working">Publier</button>
                    </div>
                </div>
            </div>
        </form>

      <form :action="action" :method="method" class="create-post-form">
  
          <div class="panel panel-default panel-create"> <!-- panel-create -->
              <div class="panel-heading">
                  <div class="heading-text">{{ feed_title }}</div>
              </div>
              <div class="panel-body">
                  <textarea v-model="content"
                        class="form-control createpost-form comment"
                        cols="30"
                        rows="3"
                        id="createPost"
                        :placeholder="placeholder"></textarea>

                  <div class="user-tags-added" style="display:none">
                      &nbsp; -- {{ with_user }}
                      <div class="user-tag-names"></div>
                  </div>
                  <div class="user-tags-addon post-addon" style="display: none">
                      <span class="post-addon-icon"><i class="fa fa-user-plus"></i></span>
                      <div class="form-group">
                          <input type="text"
                          id="userTags"
                          class="form-control user-tags youtube-text"
                          :placeholder="who_are_you_with"
                          autocomplete="off" value="">
                          <div class="clearfix"></div>
                      </div>
                  </div>
                  <div class="users-results-wrapper"></div>
                  <div class="youtube-iframe"></div>

                  <div class="video-addon post-addon" style="display: none">
                      <span class="post-addon-icon"><i class="fa fa-film"></i></span>
                      <div class="form-group">
                          <input type="text"
                          name="youtubeText"
                          id="youtubeText"
                          class="form-control youtube-text"
                          :placeholder="what_are_you_watching"  value="">
                          <div class="clearfix"></div>
                      </div>
                  </div>
                  <div class="music-addon post-addon" style="display: none">
                      <span class="post-addon-icon"><i class="fa fa-music" aria-hidden="true"></i></span>
                      <div class="form-group">
                          <input type="text"
                          name="soundCloudText"
                          autocomplete="off"
                          id ="soundCloudText"
                          class="form-control youtube-text"
                          :placeholder="what_are_you_listening_to"  value="" >
                          <div class="clearfix"></div>
                      </div>
                  </div>
                  <div class="soundcloud-results-wrapper">

                  </div>
                  <div class="location-addon post-addon" style="display: none">
                      <span class="post-addon-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                      <div class="form-group">
                          <input type="text" name="location" id="pac-input" class="form-control" :placeholder="where_are_you"  autocomplete="off" value="" onKeyPress="return initMap(event)"><div class="clearfix"></div>
                      </div>
                  </div>
                  <div class="emoticons-wrapper  post-addon" style="display:none">

                  </div>
                  <div class="images-selected post-images-selected" style="display:none">
                      <span>3</span> {{ photo_s_selected }}
                  </div>

                  <!-- Hidden elements  -->
                  <input type="hidden" name="timeline_id" :value="timeline">
                  <input type="hidden" name="youtube_title" value="">
                  <input type="hidden" name="youtube_video_id" value="">
                  <input type="hidden" name="locatio" value="">
                  <input type="hidden" name="soundcloud_id" value="">
                  <input type="hidden" name="user_tags" value="">
                  <input type="hidden" name="soundcloud_title" value="">
                  <input type="file" class="post-images-upload hidden" multiple="multiple"  accept="image/jpeg,image/png,image/gif" name="post_images_upload[]" >
                  <div id="post-image-holder"></div>
              </div><!-- panel-body -->

              <div class="panel-footer">
                  <ul class="list-inline left-list">
                      <li><a href="#" id="addUserTags"><i class="fa fa-user-plus"></i></a></li>
                      <li><a href="#" id="imageUpload"><i class="fa fa-camera-retro"></i></a></li>
                      <li><a href="#" id="musicUpload"><i class="fa fa-music"></i></a></li>
                      <li><a href="#" id="videoUpload"><i class="fa fa-film"></i></a></li>
                      <li><a href="#" id="locationUpload"><i class="fa fa-map-marker"></i></a></li>
                      <li><a href="#" id="emoticons"><i class="fa fa-smile-o"></i></a></li>
                  </ul>
                  <ul class="list-inline right-list">
                      <li><button type="submit" class="btn btn-submit btn-success" :disabled="not_working">{{ feed_btn }}</button></li>
                  </ul>

                  <div class="clearfix"></div>
              </div>
          </div>
      </form>
    </div>
</template>

<script type="text/babel">
    import GoogleAutocomplete from './GoogleAutocomplete.vue'
    import UploadImage from './UploadImage.vue'
    import {mapGetters} from 'vuex'
    import each from 'lodash/each'
    import Lang from '@/mixins/lang'

    export default {
        name: 'form-input',

        components: {
            GoogleAutocomplete,
            UploadImage
        },

        mixins: [Lang],

        props: {
            method: {
                type: String,
                default: 'POST'
            },
            action: {
                type: String,
                required: true
            },
            placeholder: {
                type: String,
                required: true,
                default: ''
            },
            timeline: {
                type: [String, Number],
                required: true,
            }
        },

        data() {
            return {
                feed_title: trans('messages.whats-going-on'),
                with_user: trans('common.with'),
                where_are_you: trans('messages.where_are_you'),
                who_are_you_with: trans('messages.who_are_you_with'),
                what_are_you_watching: trans('messages.what_are_you_watching'),
                what_are_you_listening_to: trans('messages.what_are_you_listening_to'),
                photo_s_selected: trans('common.photo_s_selected'),
                feed_btn: trans('common.post'),
                content: '',
                address: {},
                image: {},
                files: [],
                not_working: true,
                image_class: true,
                video_class: true,
                place_class: true
            }
        },

        computed: {
            image_hide(){
                return {
                    'hide': this.image_class == true
                }
            },
            video_hide() {
                return {
                    'hide': this.video_class == true
                }
            },
            place_hide() {
                return {
                    'hide': this.place_class == true
                }
            },
            ...mapGetters([
                'shared_address',
                'shared_image'
            ])
        },

        methods: {
            status() {
                this.image_class = true;
                this.video_class = true;
                this.place_class = true;
            },
            photos() {
                this.image_class = false;
                this.video_class = true;
                this.place_class = true;
            },
            video() {
                this.image_class = true;
                this.video_class = false;
                this.place_class = true
            },
            place() {
                this.image_class = true;
                this.video_class = true;
                this.place_class = false;
            },
            submit() {
                let data = new FormData();
                data.append('body', this.content);

                if (this.image) {
                    let fileList = this.files;
                    each(fileList, (file, index) => {
                        data.append('image[' + index + ']', file)
                    })
                }

                if (this.address) {
                    data.append('location', JSON.stringify(this.address))
                }

                this.$http.post(this.action, data)
                        .then((response) => {
                            this.content = '';
                            this.address = {};
                            this.image = {};
                            this.image_class = true;
                            this.video_class = true;
                            this.place_class = true;
                            window.console.log(response, 'response::submit')
                        }).catch((error) => {
                    window.console.log(error, 'response::error');
                })
            },
            onChange (files) {
                this.files = files
            },
            onRemove(file) {
                let fileList = this.files;
                fileList.splice(fileList.indexOf(file), 1)
            },
            onError(error) {
                console.error(error, 'form-input');
            },
            isValid() {
                return Object.keys(this.address).length > 0
            },
            isNotValid() {
                return !this.isValid()
            }
        },

        watch: {
            content() {
                if (this.content.length > 0)
                    this.not_working = false;
                else
                    this.not_working = true
            },
            shared_address() {
                this.address = this.shared_address
            },
            shared_image() {
                this.image = this.shared_address
            }
        }
    }
</script>
