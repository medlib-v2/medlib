/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap')

import Vue from 'vue'
import VueResource from 'vue-resource'
Vue.use(VueResource)
import {ls, user, friends, conversations} from './services'
import {$, trans, Setting, me} from './utils'

Vue.config.debug = process.env.NODE_ENV !== 'production'
Vue.config.silent = process.env.NODE_ENV === 'production'
Vue.config.devtools = process.env.NODE_ENV !== 'production'

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */
Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Setting.csrfToken)
    if (ls.get('jwt-token')) {
        Vue.http.headers.common['Authorization'] = `Bearer ${ls.get('jwt-token')}`
    }
    next((response) => {
        /**
         * …get the token from the header or response data if exists, and save it.
         */
        if (Setting.jwt && !ls.get('jwt-token')) {
            ls.set('jwt-token', Setting.jwt)
        }

        if (response.status === 400 || response.status === 401) {
            if (!(response.method === 'post' && /\/me\/?$/.test(response.url))) {
                /**
                 * the token must have expired. Log out.
                 */
                user.logout().then((response) => {
                  window.location.pathname = '/login'
                })
            }
        }
    })
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import BoxPreview from './components/BoxPreview.vue'
import FormInput from './components/FormInput.vue'
import Feed from './components/Feed.vue'
import FriendsList from './components/FriendsList.vue'
import Conversations from './components/Conversations.vue'
import Chatbox from './components/Chatbox.vue'
import Notifications from './components/Notifications.vue'
import EmojiIcon from './components/EmojiIcon.vue'
import ElSearch from './components/ElSearch.vue'
import NotificationsDemo from './components/NotificationsDemo.vue'

//npm install at.js
import './directives/DirectivePreview'
import './directives/DirectiveEmojiIcon'
import './directives/DirectiveAutoScroll'
import './filters/FiltersTimeago'
import './filters/FiltersEmojiIcon'
import store from './stores'
import {mapActions, mapGetters} from 'vuex'
import VueSocketio from './socket.io'

if (window.location.href.match(/login|password/) == null && me !== '') {
    Vue.use(VueSocketio, Setting.socket_url, {query: 'jwt=' + Setting.jwt})
}

/* eslint-disable-line no-new */
new Vue({
    name: 'app',
    el: '#app',
    store,
    data () {
        return {
            value: '',
            suggestionAttribute: 'original_title',
            suggestions: [],
            selectedEvent: "",
            allConversations: [],
            conversations: [],
            activeConversation: {},
            showConversations: true,
            showChatbox: false,
            connectionError: false
        }
    },
    sockets: {
        connect () {
            global.socket = this.$socket;
            this.$nextTick(() => {
                /** this.$socket.emit('register', {'user_id': this.user.id}) **/
                window.console.log('socket connected $nextTick', this.user.id)
            });
        },
        customEmit (val) {
            window.console.log('this method fired by socket server. eg: io.emit("customEmit", data)')
        }
    },
    components: {
        BoxPreview,
        FormInput,
        Feed,
        FriendsList,
        Conversations,
        Chatbox,
        Notifications,
        EmojiIcon,
        ElSearch,
        NotificationsDemo
    },
    events: {
        messageSent (response) {
            if (response.message) {
                window.console.log('message received', response.message)
                response.conversation.active = true
                response.conversation.newMessage = true
                response.conversation.lastMessage = this.lastMessage(response.conversation)
                console.log('response ...', response.conversation.lastMessage)
                this.activeConversation = response.conversation
                /** this.activeConversation.messages.push(response.message) **/
                /** scroll message into view **/
                setTimeout(function () {
                    document.querySelector('.chatbox-content').scrollTop = 10000000
                }, 50)
            }
        },
        newConversation (conversation) {
            if (conversation) {
                window.console.log(conversation)
                this.conversations.push(conversation)
            }
        },
        activateConversation (conversation) {
            if (conversation) {
                this.activateConversation(conversation)
            }
        }
    },
    methods: {
        listenSocket () {
            this.$socket.on('connect_error', (error) => {

                if (!this.connectionError) {
                    $('#socket_offline').addClass('alert alert-danger').html(() => {
                        return '<h4><i class="icon fa fa-eye-slash"></i>' + trans('app.socket_error') + '</h4><p>' +
                            trans('app.socket_error_info') + '</p>'
                    }).fadeIn(300)
                }
                this.connectionError = true
            })
            this.$socket.on('connect', function () {
                $('#socket_offline').fadeOut(300)
                this.connectionError = false
            })
            this.$socket.on('reconnect', function () {
                $('#socket_offline').fadeOut(300)
                this.connectionError = false
            })
        },
        lastMessage (conversation) {
            /** return the last message and the name of the sender or You said... **/
            let lastMessageSent = conversation.messages[conversation.messages.length - 1]
            /** if we don't have a message, just return **/
            if (lastMessageSent === undefined) return ''

            /** otherwise see if it's from the current user or not **/
            return lastMessageSent.user.id === this.user.id
                ? 'You said ' + lastMessageSent.body.substr(0, 25) + '...'
                : lastMessageSent.user.name + ' said ' + lastMessageSent.body.substr(0, 25) + '...'
        },
        activateConversation (conversation) {
            /** reload the conversation and it's messages **/
            this.$http.get('/conversations/' + conversation.id, {
                api_token: this.apiToken
            }).then(function (response) {
                conversation = response.data
                /** deactivate all conversations **/
                this.deactivateAllConversations()
                conversation.active = true
                this.activeConversation = conversation
                this.showChatbox = true
                /** get the conversations existing index in the collection **/
                const conversation_index = this.conversations.map(function (obj, index) {
                    if (obj.id === conversation.id) {
                        return index
                    }
                }).filter(isFinite)
                /** remove from the conversations and re-add **/
                this.conversations = this.conversations.filter(function (convo) {
                    return convo.id !== conversation.id
                })
                this.conversations.splice(conversation_index, 0, conversation)

                /** maximize chatbox **/
                document.querySelector('.chatbox').classList.add('maximize')
                document.querySelector('.chatbox').classList.remove('minimize')

                /** show the chatbox-content and chatbox-input **/
                document.querySelector('.chatbox-content').setAttribute('style', 'display:block')
                document.querySelector('.chatbox-input').setAttribute('style', 'display:block')

                /** scroll message into view **/
                setTimeout(function () {
                    document.querySelector('.chatbox-content').scrollTop = 10000000
                }, 50)
            }, function (response) {
                /** error callback **/
                console.log('Failed to reload conversation', conversation)
            })
        },
        deactivateAllConversations () {
            this.conversations.forEach(function (conversation) {
                conversation.active = false
            })
        },
        startConversation (sid, rid) {
            /** create a new conversation **/
            this.$http.post('/conversations', {
                api_token: this.apiToken, sender_id: sid, recipient_id: rid
            }).then(function (response) {
                /** log the conversation id **/
                console.log('conversation: ', response.data.conversation)
                /** broadcast new conversation - causes a duplication bug...not needed in parent? **/
                /** this.$dispatch('newConversation', response.data.conversation) **/
                /** create a new chat window **/
                this.activeConversation = response.data.conversation
                this.activateConversation(this.activeConversation)
            }, function (response) {
                /** error callback **/
                console.log(response)
            })
        },
        loadConversations () {
            conversations.fetch().then((conversations) => {
                /**
                 * add the conversations
                 */
                this.conversations = conversations
                this.allConversations = conversations
                /**
                 * set the active conversation
                 * @type {*}
                 */
                this.activeConversation = this.conversations[0]

            }).catch((response) => {
                /** error callback **/
                console.log(response)
            })
        },
        toggleConversations () {
            this.showConversations = !this.showConversations
        },
        clickInput() {
            this.selectedEvent = 'click input'
        },
        clickButton() {
            this.selectedEvent = 'click button'
        },
        selected() {
            this.selectedEvent = 'selection changed'
        },
        enter() {
            this.selectedEvent = 'enter'
        },
        keyUp() {
            this.selectedEvent = 'keyup pressed'
        },
        keyDown() {
            this.selectedEvent = 'keyDown pressed'
        },
        keyRight() {
            this.selectedEvent = 'keyRight pressed'
        },
        clear() {
            this.selectedEvent = 'clear input'
        },
        escape() {
            this.selectedEvent = 'escape'
        },
        changed() {
            let that = this
            this.suggestions = []
            this.$http.get('https://api.themoviedb.org/3/search/movie?api_key=342d3061b70d2747a1e159ae9a7e9a36&query=' + this.value)
                .then((response) => {
                    response.data.results.forEach(function(a) {
                        that.suggestions.push(a)
                    })
                }).catch((error) => {
                    window.console.log(error)
                })
        },
        ...mapActions({
            userAction: 'user',
            setUsers: 'setUsers',
            setLocale: 'setLocale'
        })
    },
    created () {
        window.console.log('created vm')
    },
    mounted () {
        if (window.location.href.match(/login|password/) == null && me !== '') {
            user.me(me).then((response) => {
                this.userAction(response)
                this.$socket.emit('register', {'user_id': this.user.id})
            })

            /**
             * Set the locale language for moment
             */
            this.setLocale(Setting.language)
            this.$socket.on('chat.message', (message) => {
                /**
                 * add the message if it matches the any of the users conversations
                 */
                this.conversations.forEach(function (conversation) {
                    if (conversation.id === message.conversation_id) {
                        /**
                         * play notification audio fx
                         * @type {Element}
                         */
                        let audio = document.createElement('audio')
                        audio.setAttribute('src', '/audio/sms.mp3')
                        audio.play()
                        audio = null
                        conversation.messages.push(message)
                        /** scroll message into view **/
                        setTimeout(function () {
                            document.querySelector('.chatbox-content').scrollTop = 10000000
                        }, 50)
                    }
                })
            })
            this.listenSocket()

            friends.fetch(me).then((friends) => {
                /**
                 * set the user in users array
                 */
                friends.forEach((friend) => {
                    this.setUsers(friend)
                })
                /**
                 * load the users conversations
                 */
                this.loadConversations()
            }).catch((response) => {
                window.console.log(response)
            })
        }
    },
    computed: {
        ...mapGetters(['user', 'users', 'locale'])
    }
})
