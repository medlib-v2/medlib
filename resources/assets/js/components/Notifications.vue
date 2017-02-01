<template>
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
                                    <li class="notification notification-unread">
                                        <a href="#">
                                            <div class="image"><img src="/avatars/a2.jpg" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <div class="text"><span class="user-name">Jessica Caruso</span> accepted your invitation to join the team.</div><span class="date">2 min ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification">
                                        <a href="#">
                                            <div class="image"><img src="/avatars/a3.jpg" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <div class="text"><span class="user-name">Joel King</span> is now following you</div><span class="date">2 days ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification">
                                        <a href="#">
                                            <div class="image"><img src="/avatars/a4.jpg" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <div class="text"><span class="user-name">John Doe</span> is watching your main repository</div><span class="date">2 days ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="notification">
                                        <a href="#">
                                            <div class="image"><img src="/avatars/a5.jpg" alt="Avatar"></div>
                                            <div class="notification-info">
                                                <span class="text"><span class="user-name">Emily Carter</span> is now following you</span><span class="date">5 days ago</span>
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
import UnreadNotifications from './UnreadNotifications.vue'
import { mapActions, mapGetters } from 'vuex'
let socket = io(Setting.socket_url, {
    query: 'jwt=' + Setting.jwt
});

export default{
    name: 'notifications',
    props: ['linkNotifications', 'id'],
    components: { UnreadNotifications },
    mounted() {
        this.$http.get('/notifications/unread').then( (response) => {
            response.body.forEach( (notification) => {
                this.notificationUnread(notification)
            })
        })

        this.listen()
    },
    methods: {
        ...mapActions(['notificationUnread']),
        listen() {
            /**
            socket.on('App.User.' + this.id).notification( (notification) => {
                console.log(notification)
                //document.getElementById("noty_audio").play()
            })
            **/
        }
    },
    computed: {
        ...mapGetters(['countNotifications'])
    }
}
</script>