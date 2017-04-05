<template lang="html">
    <ul class="post-comments mt-sm">
        <li>
            <span class="thumb-xs avatar pull-left mr-sm"><img class="img-circle" :src="user.user_avatar"
                                                               :alt="user.full_name"></span>
            <div class="comment-body">
                <form @submit.prevent="submit">
                    <div class="form-group" :class="hasError">
                        <input class="form-control input-sm" name="comment" type="text"
                               placeholder="Write your comment..." autocomplete="off">
                        <span class="help-block" v-if="error">{{ error.message }}</span>
                    </div>
                </form>
            </div>
        </li>
    </ul>
</template>

<script type="text/babel">
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'comments',
        props: ['id', 'poster_name'],
        data () {
            return {
                comment: '',
                error: null
            }
        },
        computed: {
            ...mapGetters(['user']),
            hasError() {
                return {'has-error': this.error && this.error.type === 'fatal'}
            }
        },
        methods: {
            submit () {
                let data = new FormData()
                data.append('comment', this.comment)

                this.$http.post('/u/' + this.poster_name + '/feeds/' + this.id + '/comment', data).catch((response) => {
                    /** this.error = null **/
                    console.log(response, 'Medlib %o', Medlib)
                }).then((response) => {
                    this.comment = ''
                    this.error = null
                    console.log(response, 'Medlib %o', Medlib)
                })
            }
        }
    }
</script>
