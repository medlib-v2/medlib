<template lang="html">
    <div class="feed-list">
        <div id="loader"></div>
        <div class="row">
            <div class="col-md-3 col-sm-2 hidden-xs no-padding"></div>
            <div class="col-md-6 col-sm-8">
                <section class="activities">
                    <section class="event" :data-feed-id="post.id" v-for="post in posts">
                        <span class="thumb-sm avatar pull-left mr-sm">
                            <a href="#" class="pull-left"><img :src="post.user.user_avatar" class="img-circle"></a>
                        </span>
                        <h4 class="event-heading"><a href="#">{{ post.user.full_name }}</a></h4>
                        <p class="fs-sm text-muted">{{ post.created_at | timeago }}</p>
                        <p class="fs-mini content">{{ post.body }}</p>
                        <p class="event-image" v-if="post.image_url">
                            <img :src="post.image_url" alt="">
                        </p>
                        <footer>
                            <div class="clearfix">
                                <like :id="post.id" :poster_name="post.user.username"></like>
                                <ul class="post-links mt-sm pull-left">
                                    <li><i class=""/></li>
                                    <li><a href="javascript:void(0);">Comment</a></li>
                                </ul>
                            </div>
                            <comments :id="post.id" :poster_name="post.user.username"></comments>
                        </footer>
                    </section>
                    <beat-loader :loading="posts.length == 0"></beat-loader>
                </section>
            </div>
            <div class="col-md-3 col-sm-2 hidden-xs no-padding"></div>
        </div>
    </div>
</template>

<script type="text/babel">

import Like from './Like.vue'
import BeatLoader from './BeatLoader.vue'
import Comments from './Comments.vue'

import { mapActions, mapGetters } from 'vuex'

export default {
    name: 'feed',
    mounted() {
        this.$http.get(this.action).then( (response) => {
            this.feedsAction(response.body.feeds)

            response.body.feeds.data.forEach( (post) => {
                this.postAction(post)
            })
        })
    },
    components: { Like, BeatLoader, Comments },
    props: {
        action: {
            type: String,
            required: true
        }
    },
    methods: {
        ...mapActions({
            postAction: 'post',
            feedsAction: 'feeds',
        })
    },
    computed: {
        ...mapGetters(['posts'])
    }
}
</script>