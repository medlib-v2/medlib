<template lang="html">
    <ul class="nav navbar-nav navbar-right be-icons-nav">
        <li class="dropdown">
            <a href="#" role="button" aria-expanded="false" class="be-toggle-right-sidebar">
                <span class="icon fa fa-cog" aria-hidden="true"></span>
            </a>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                <span class="icon fa fa-bell" aria-hidden="true"></span><span v-if="countNotifications > 0" class="indicator badge"></span>
            </a>
            <ul class="dropdown-menu be-notifications animated fadeInUp">
                <li>
                    <unread-notifications title="Notifications"></unread-notifications>
                    <div class="list">
                        <div class="be-scroller">
                            <div class="content">
                                <ul>
                                    <li class="notification notification-unread" v-for="notification in notifications">
                                        <a href="#">
                                            <div class="image"><img :src="notification.data.user_avatar" :alt="notification.data.name"></div>
                                            <div class="notification-info">
                                                <div class="text"><span class="user-name">{{ notification.data.name }}</span> {{ notification.data.message }}</div><time class="date">{{ notification.data.created_at | timeago }}</time>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="notification notification-unread">
                                        <a href="#">
                                            <div class="image"><img src="/avatars/a2.jpg" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <div class="text"><span class="user-name">Jessica Caruso</span> accepted your invitation to join the team.</div><time class="date">2 min ago</time>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification">
                                        <div class="notification-list">
                                            <div class="image"><a href="#"><img src="/avatars/a3.jpg" alt="Avatar"></a></div>
                                            <div class="notification-info">
                                                <div class="text"><span class="user-name"><a href="#">Joel King</a></span> is now following you</div><time class="date">2 days ago</time>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="notification">
                                        <div class="notification-list">
                                            <div class="image">
                                                <img class="img-circle" src="/avatars/a5.jpg" alt="Avatar">
                                            </div>
                                            <div class="notification-info">
                                                <div class="text">
                                                    <span class="user-name"><a href="#">Jeff Doe</a></span>
                                                    <p class="no-margin overflow-hidden">Sent you a friend request.&nbsp;&nbsp;
                                                        <button class="btn btn-xs btn-success" @click.stop>Allow</button>
                                                        <button class="btn btn-xs btn-danger" @click.stop>Deny</button>
                                                    </p>
                                                </div>
                                                <time class="date">12:18 AM</time>
                                            </div>
                                        </div>
                                    </li>


                                    <li class="notification">
                                        <a href="#">
                                            <div class="image"><img src="/avatars/a4.jpg" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <div class="text"><span class="user-name">John Doe</span> is watching your main repository</div><time class="date">2 days ago</time>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification">
                                        <a href="#">
                                            <div class="image"><img src="/avatars/a5.jpg" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <span class="text"><span class="user-name">Emily Carter</span> is now following you</span><time class="date">5 days ago</time>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="footer"> <a :href="linkNotifications">View all notifications</a></div>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script type="text/babel">
import UnreadNotifications from './UnreadNotifications.vue';
import { mapActions, mapGetters } from 'vuex';
import { notifications } from '../services';

/**
let socket = io(Setting.socket_url, {
    query: 'jwt=' + Setting.jwt
});
**/

export default{
    name: 'notifications',
    props: ['linkNotifications', 'id'],
    components: { UnreadNotifications },
    mounted() {
        notifications.unread().then( (response) => {
            response.forEach( (notification) => {
                this.notificationUnread(notification);
            })
        });

        this.listen()
    },
    methods: {
        ...mapActions(['notificationUnread']),
        listen() {
            this.$socket.on('requested-.' + this.id + ':Medlib\\Events\\FriendRequestWasSent', (notification) => {
                console.log(notification);
                //document.getElementById("noty_audio").play()
            })
        }
    },
    computed: {
        ...mapGetters(['countNotifications', 'notifications'])
    }
}
</script>