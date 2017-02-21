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
                    <unread-notifications :title="title_notification"></unread-notifications>
                    <div class="list">
                        <div class="be-scroller">
                            <div class="content">
                                <ul>
                                    <li class="notification" :class="classUnread(notification.read_at)" v-for="notification in notifications">
                                        <a class="notification-list" v-if="notification.data.type == 'accepted_friend_request'">
                                            <div class="image">
                                                <img class="img-circle" :src="notification.data.user_avatar" :alt="notification.data.full_name">
                                            </div>
                                            <div class="notification-info">
                                                <div class="text">
                                                    <span class="user-name">
                                                        <a :href="'/u/' + notification.data.username">{{ notification.data.full_name }}</a>
                                                    </span> {{ notification.data.message }}</div>
                                                <time class="date">{{ notification.created_at | timeago }}</time>
                                            </div>
                                        </a>

                                        <div class="notification-list" v-else-if="notification.data.type == 'send_friend_request'">
                                            <div class="image">
                                                <img class="img-circle" :src="notification.data.user_avatar" :alt="notification.data.full_name">
                                            </div>
                                            <div class="notification-info">
                                                <div class="text">
                                                    <span class="user-name">
                                                        <a :href="'/u/' + notification.data.username">{{ notification.data.full_name }}</a>
                                                    </span>
                                                    <p class="no-margin overflow-hidden">{{ notification.data.message }}&nbsp;&nbsp;
                                                        <button class="btn btn-xs btn-success" @click.stop="allowFriendRequest(notification.data.username, notification.id)">{{ accept_request }}</button>
                                                        <button class="btn btn-xs btn-danger" @click.stop="denyFriendRequest(notification.data.username, notification.id)">{{ cancel_request }}</button>
                                                    </p>
                                                </div>
                                                <time class="date">{{ notification.created_at | timeago }}</time>
                                            </div>
                                        </div>

                                        <div class="notification-list" v-else>
                                            <div class="image">
                                                <img class="img-circle" :src="notification.data.user_avatar" :alt="notification.data.full_name">
                                            </div>
                                            <div class="notification-info">
                                                <div class="text">
                                                    <span class="user-name">
                                                        <a :href="'/u/' + notification.data.username">{{ notification.data.full_name }}</a>
                                                    </span>
                                                    <p class="no-margin overflow-hidden">{{ notification.data.message }}&nbsp;&nbsp;</p>
                                                </div>
                                                <time class="date">{{ notification.created_at | timeago }}</time>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="footer"> <a :href="linkNotifications">{{ view_all_notifications }}</a></div>
                </li>
            </ul>
        </li>
    </ul>
</template>

<script type="text/babel">
import UnreadNotifications from './UnreadNotifications.vue'
import { mapActions, mapGetters } from 'vuex'
import { notifications } from '../services'

export default{
    name: 'notifications',
    props: {
        linkNotifications: {
            type: String,
            required: true
        },
        id: {
            type: [String, Number],
            required: true
        }
    },
    components: { UnreadNotifications },
    data() {
        return {
            countNotifications: null,
            title_notification: trans('app.notifications'),
            view_all_notifications: trans('notifications.view_all_notifications'),
            accept_request: trans('notifications.accept_request'),
            cancel_request: trans('notifications.cancel_request'),
        }
    },
    mounted() {
        notifications.fetch().then( ({total, notifications}) => {
            this.countNotifications = total
            /**
             this.notifications = notifications.map(({ id, data, created }) => {
                return {
                    id: id,
                    title: data.title,
                    body: data.body,
                    created: created,
                    action_url: data.action_url
                }
            })
            **/
            notifications.forEach( (notification) => {
                this.notificationUnread(notification)
            })
        })

        this.listen()
    },
    methods: {
        ...mapActions(['notificationUnread']),
        listen() {
            /**
            this.$socket.channel('requested-' + this.id).listen('FriendRequestWasSent', (notification) => {
                window.console.log(notification, 'notification')
                //document.getElementById("noty_audio").play()
            })
            this.$socket.channel('request-was-accepted-' + this.id).listen('FriendRequestWasAccepted', (notification) => {
                window.console.log(notification, 'notification')
                //document.getElementById("noty_audio").play()
            })
            **/
            window.console.log('notification', this.user.id)
            this.$socket.private(`Medlib.Models.User.${this.user.id}`)
            .notification(notification => {
              window.console.log(notification, 'notification');
              this.total++
              this.notifications.unshift(notification)
            })
            .listen('NotificationRead', ({ notificationId }) => {
              this.total--
              const index = this.notifications.findIndex(n => n.id === notificationId)
              if (index > -1) {
                this.notifications.splice(index, 1)
              }
            })
            .listen('NotificationReadAll', () => {
              this.total = 0
              this.notifications = []
            })
        },
        allowFriendRequest(username, id) {
            notifications.acceptRequest(username, id).then( (response) => {
                /**
                 * Set notification
                 */
                window.console.log('allowFriendRequest', response)
            })
        },
        denyFriendRequest(username, id) {
            notifications.cancelRequest(username, id).then( (response) => {
                /**
                 * Set notification
                 */
                window.console.log('denyFriendRequest', response)
            })
        },
        classUnread(status) {
            return {
                'notification-unread': status === null
            }
        }
    },
    computed: {
        classUnreadP(status) {
            return {
                'notification-unread': status === null
            }
        },
        ...mapGetters(['notifications', 'user'])
    }
}
</script>
