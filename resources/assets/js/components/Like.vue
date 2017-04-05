<template lang="html">
    <div>
        <ul class="post-links mt-sm pull-left">
            <li><a href="javascript:void(0);">1 hour</a></li>
            <li v-if="!auth_user_likes_post"><a href="javascript:void(0);" @click.prevent="like()"><span class="text-danger"><i class="fa fa-heart-o"></i> Like</span></a></li>
            <li v-else><a href="javascript:void(0);" @click.prevent="unlike()"><span class="text-danger"><i class="fa fa-heart"></i> Unlike</span></a></li>
        </ul>
        <span class="thumb thumb-sm pull-right"  v-for="like in post.likes">
            <a href="javascript:void(0);"><img class="img-circle" :src="like.user.user_avatar"></a>
        </span>
    </div>
</template>

<script type="text/babel">

import Store from '../stores'
import * as types from '../stores/mutation-types'
import { mapActions, mapGetters } from 'vuex'
import { favorite } from '../services'
export default {
    name: 'like',
    props: ['id', 'poster_name'],
    methods: {
        like() {
            favorite.like(this.poster_name, this.id).then( (response) => {
                Store.commit(types.SET_UPDATE_POST_LIKES, { id: this.id, like: response })
            })
        },
        unlike() {
            favorite.unlike(this.poster_name, this.id).then( (response) => {
                Store.commit(types.SET_UNLIKE_POST, { post_id: this.id, like_id: response })
            })
        }
    },
    computed: {
        ...mapGetters(['posts', 'user']),
        post() {
            return this.posts.find( (post) => {
                return post.id === this.id
            })
        },
        likers() {
            let likers = []
            this.post.likes.forEach( (like) => {
                likers.push(like.user.id)
            })
            return likers
        },
        auth_user_likes_post() {
            let check_index = this.likers.indexOf( this.user.id )
            if (check_index === -1)
                return false
            else
                return true
        }
    }
}
</script>
