/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import Vue from 'vue';
import VueResource from 'vue-resource';
Vue.use(VueResource);
import { ls, user, friends } from './services';
import { event } from './utils/Supports';

Vue.config.debug = true;
Vue.config.silent = false;
Vue.config.devtools = true;

/**
 * We'll register a HTTP interceptor to attach the "CSRF" header to each of
 * the outgoing requests issued by this application. The CSRF middleware
 * included with Laravel will automatically verify the header's value.
 */
Vue.http.interceptors.push((request, next) => {
    request.headers.set('X-CSRF-TOKEN', Setting.csrfToken);
    if (ls.get('jwt-token')) {
        Vue.http.headers.common['Authorization'] = `Bearer ${ls.get('jwt-token')}`;
    }
    next((response) => {
        /**
         * …get the token from the header or response data if exists, and save it.
         */
        const token = null;
        window.console.log(response, 'response');
        //const token = response.headers.common['Authorization'] || response.body['token'];
        if (token) {
            ls.set('jwt-token', token);
        }

        if (response.status === 400 || response.status === 401) {
            if (!(response.method  === 'post' && /\/me\/?$/.test(response.url))) {
                /**
                 * the token must have expired. Log out.
                 */
                user.logout();
                window.location.pathname = '/login';
            }
        }
    });
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import BoxPreview from './components/BoxPreview.vue';
import FormInput from './components/FormInput.vue';
import Feed from './components/Feed.vue';
import FriendsList from './components/FriendsList.vue';
import Conversations from './components/Conversations.vue';
import Chatbox from './components/Chatbox.vue';
import Notifications from './components/Notifications.vue';

import './directives/DirectivePreview';
import './filters/FiltersTimeago';
import store from './stores';
import { mapActions, mapGetters } from 'vuex';
import { $, trans } from './utils';
import io from 'socket.io-client';
import VueSocketio from './socket.io';

if (window.location.href.match(/login|password/) == null && me != "") {
    Vue.use(VueSocketio, io(Setting.socket_url, { query: 'jwt=' + Setting.jwt}));
}

// eslint-disable-line no-new
window.app = new Vue({
    name: 'app',
    el: '#app',
    store,
    sockets:{
        connect(){
            this.$socket.emit('register', {'user_id': this.user.id});
            window.console.log('socket connected');
        },
        customEmit(val){
            window.console.log('this method fired by socket server. eg: io.emit("customEmit", data)')
        }
    },
    components: { BoxPreview, FormInput, Feed, FriendsList, Conversations, Chatbox, Notifications },
    events: {
        messageSent(response) {
            if (response.message) {
                console.log('message received', response.message);
                response.conversation.active = true;
                response.conversation.newMessage = true;
                response.conversation.lastMessage = this.lastMessage(response.conversation);
                console.log('response ...', response.conversation.lastMessage);
                this.activeConversation = response.conversation;

                // this.activeConversation.messages.push(response.message);
                // scroll message into view
                setTimeout(function() {
                    document.querySelector('.chatbox-content').scrollTop = 10000000;
                }, 50);
            }
        },
        newConversation(conversation) {
            if (conversation) {
                console.log(conversation);
                this.conversations.push(conversation);
            }
        },
        activateConversation(conversation) {
            if (conversation) {
                this.activateConversation(conversation);
            }
        }
    },
    methods: {
        lastMessage(conversation) {
            // return the last message and the name of the sender or You said...
            let lastMessageSent = conversation.messages[conversation.messages.length -1];

            // if we don't have a message, just return
            if (lastMessageSent === undefined) return '';

            // otherwise see if it's from the current user or not
            return lastMessageSent.user.id === this.user.id ?
                'You said ' + lastMessageSent.body.substr(0, 25) + '...' :
                lastMessageSent.user.name + ' said ' + lastMessageSent.body.substr(0, 25) + '...';
        },
        activateConversation(conversation) {
            // reload the conversation and it's messages
            this.$http.get('/api/v1/conversations/' + conversation.id, {
                api_token: this.apiToken
            }).then(function(response) {
                conversation = response.data;
                // deactivate all conversations
                this.deactivateAllConversations();

                conversation.active = true;
                this.activeConversation = conversation;
                this.showChatbox = true;

                // get the conversations existing index in the collection
                const conversation_index = this.conversations.map(function(obj, index) {
                    if (obj.id === conversation.id) {
                        return index;
                    }
                }).filter(isFinite);

                // remove from the conversations and re-add
                this.conversations = this.conversations.filter(function(convo) {
                    return convo.id !== conversation.id;
                });
                this.conversations.splice(conversation_index, 0, conversation);

                // maximize chatbox
                document.querySelector('.chatbox').classList.add('maximize');
                document.querySelector('.chatbox').classList.remove('minimize');

                // show the chatbox-content and chatbox-input
                document.querySelector('.chatbox-content').setAttribute('style', 'display:block');
                document.querySelector('.chatbox-input').setAttribute('style', 'display:block');

                // scroll message into view
                setTimeout(function() {
                    document.querySelector('.chatbox-content').scrollTop = 10000000;
                }, 50);
            }, function(response){
                // error callback
                console.log('Failed to reload conversation', conversation);
            });
        },
        deactivateAllConversations() {
            this.conversations.forEach(function(conversation) {
                conversation.active = false;
            });
        },
        startConversation(sid, rid) {
            // create a new conversation
            this.$http.post('/api/v1/conversations', {
                api_token: this.apiToken, sender_id: sid, recipient_id: rid
            }).then(function(response) {
                // log the conversation id
                console.log('conversation: ' , response.data.conversation);

                // broadcast new conversation - causes a duplication bug...not needed in parent?
                // this.$dispatch('newConversation', response.data.conversation);

                // create a new chat window
                this.activeConversation = response.data.conversation;
                this.activateConversation(this.activeConversation);

            }, function(response) {
                // error callback
                console.log(response);
            });
        },
        loadConversations() {
            this.$http.get('/api/v1/conversations', {api_token: this.apiToken}).then(function(response) {
                // add the conversations
                this.conversations = response.data;
                this.allConversations = response.data;

                // set the active conversation
                this.activeConversation = this.conversations[0];

            }, function(response) {
                // error callback
                console.log(response);
            }.bind(this));
        },
        toggleConversations() {
            this.showConversations = !this.showConversations;
        },
        ...mapActions({
            userAction: 'user',
            setUsers: 'setUsers',
            setLocale: 'setLocale'
        })
    },
    data(){
        return {
            allConversations: [],
            conversations: [],
            activeConversation: {},
            showConversations: true,
            showChatbox: false,
            connectionError: false
        }
    },
    created(){
        event.init();
        window.console.log("created vm");
    },
    mounted() {
        if (window.location.href.match(/login|password/) == null && me != "") {
            user.me(me).then((response) => {
                this.userAction(response)
            });

            /**
             * Set the locale language for moment
             */
            this.setLocale(Setting.language);

            this.$socket.on('chat.message', function(message) {
                /**
                 * add the message if it matches the any of the users conversations
                 */
                this.conversations.forEach(function(conversation) {
                    if (conversation.id === message.conversation_id) {
                        /**
                         * play notification audio fx
                         * @type {Element}
                         */
                        let audio = document.createElement('audio');
                        audio.setAttribute('src', '/audio/sms.mp3');
                        audio.play();
                        audio = null;

                        conversation.messages.push(message);
                        // scroll message into view
                        setTimeout(function() {
                            document.querySelector('.chatbox-content').scrollTop = 10000000;
                        }, 50);
                    }
                })
            }.bind(this));
            /**
             this.$socket.on('test-channel:App\\Events\\UserRegistered', function(data) {
                _this.users.unshift(data.user);
                _this.totalRegisters++;
                _this.searchUsers();
            }.bind(this));
             **/
            this.$socket.on('connect_error', function(error) {
                window.console.error(error);
                if (!this.connectionError) {
                    $('#socket_offline').addClass('alert alert-danger').html(() => {
                        return '<h4><i class="icon fa fa-eye-slash"></i>' + trans('app.socket_error') + '</h4><p>'
                            + trans('app.socket_error_info') + '</p>';
                    }).fadeIn(300);
                }
                this.connectionError = true;
            });

            this.$socket.on('connect', function() {
                $('#socket_offline').fadeOut(300);
                this.connectionError = false;
            });

            this.$socket.on('reconnect', function() {
                $('#socket_offline').fadeOut(300);
                this.connectionError = false;
            });

            friends.fetch(me).then((response) => {
                window.console.log('friends', response);
                /**
                 * set the user in users array
                 */
                response.forEach((post) => {
                    this.setUsers(post)
                });

                /**
                 * load the users conversations
                 */
                this.loadConversations();

            }).catch((response) => { window.console.log(response) })
        }
    },
    computed: {
        ...mapGetters(['user', 'users', 'locale'])
    }
});