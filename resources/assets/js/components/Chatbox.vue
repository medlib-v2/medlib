<template>
    <div class="chatbox effect8" transition="chatbox" v-show="show">
        <header>
            <div class="title">
                <i class="fa fa-circle"></i>
                <span>{{ title }}</span>
            </div>
            <nav>
                <ul>
                    <li><a @click="minimize"><i class="fa fa-minus">&nbsp;</i></a></li>
                    <!-- <li>
                        <a @click="maximize"><i class="fa fa-square-o">&nbsp;</i></a>
                    </li> -->
                    <li><a @click="close"><i class="fa fa-close">&nbsp;</i></a></li>
                </ul>
            </nav>
        </header>
        <div class="chatbox-content">
            <li v-for="message in conversation.messages" track-by="$index" :class="message.user.id === user.id ? 'self' : 'other'">
                <div class="avatar">
                    <img :src="message.user.avatar">
                </div>
                <div class="chatbox-message-content">
                    <p>{{ message.body }}</p>
                    <time :datetime="message.created_at" :title="message.created_at">
                        {{ message.user.name }} • {{ message.created_at | timeago }}
                    </time>
                </div>

            </li>
        </div>
        <div class="chatbox-input">
            <textarea v-model="message" @keyup.enter="send" placeholder="Enter a message..." autofocus="true" autocomplete="off"></textarea>
        </div>
    </div>
</template>

<script type="text/babel">

let socket = io(Setting.socket_url, {
    query: 'jwt=' + Setting.jwt
})

export default {
    props: {
        conversation: {
            required: true,
            twoWay: true
        },
        show: {
            type: Boolean,
            required: true,
            twoWay: true,
            default: true
        },
        user: {
            require: true,
            twoWay: true
        }
    },
    data() {
        return {
            message: '',
            apiToken: Setting.csrfToken,
        };
    },
    computed: {
        title() {
            if (this.conversation.sender !== undefined && this.conversation.recipient !== undefined) {
                if (this.conversation.sender_id === this.user.id) {
                    return this.conversation.recipient.name;
                } else {
                    return this.conversation.sender.name;
                }
            }
            return '';
        }
    },
    methods: {
        send(e) {
            console.log('send event', e);
            if (this.message.trim().length > 0 && !e.shiftKey) {
                // replace newline in message with <br>
                this.message = this.message.replace(/[\r\n]/g, "\n");
                this.$http.post('/api/v1/messages', {
                    api_token: this.apiToken,
                    user_id: this.user.id,
                    conversation_id: this.conversation.id,
                    body: this.message
                }).then(function(response) {
                    // push the message to the parent
                    this.$dispatch('messageSent', {message: response.data.message, conversation: this.conversation});
                    // emit the message to the chatserver
                    socket.emit('chat.message', response.data.message);
                    // clear the message input
                    this.message = '';
                    // scroll message into view
                    setTimeout(function() {
                        document.querySelector('.chatbox-content').scrollTop = 10000000;
                    }, 50);
                },function(response) {
                    // error callback
                    console.log('Failed to send message', response);
                }.bind(this));
            }
        },
        maximize() {
            // maximize chatbox
            document.querySelector('.chatbox').classList.add('maximize');
            document.querySelector('.chatbox').classList.remove('minimize');
            // show the chatbox-content and chatbox-input
            document.querySelector('.chatbox-content').setAttribute('style', 'display:block');
            document.querySelector('.chatbox-input').setAttribute('style', 'display:block');
        },
        minimize() {
            // toggle the minimize and maximize classes
            if (document.querySelector('.chatbox').classList.contains('minimize')) {
                // maximize chatbox
                document.querySelector('.chatbox').classList.add('maximize');
                document.querySelector('.chatbox').classList.remove('minimize');
                // show the chatbox-content and chatbox-input
                document.querySelector('.chatbox-content').setAttribute('style', 'display:block');
                document.querySelector('.chatbox-input').setAttribute('style', 'display:block');
            } else {
                // minimize chatbox
                document.querySelector('.chatbox').classList.remove('maximize');
                document.querySelector('.chatbox').classList.add('minimize');
                // hide the chatbox__content and chatbox__input
                setTimeout(function() {
                    document.querySelector('.chatbox-content').setAttribute('style', 'visibility:hidden');
                    document.querySelector('.chatbox-input').setAttribute('style', 'visibility:hidden');
                }, 800);
            }
        },
        close() {
            // if chatbox is in mimimized state
            if (document.querySelector('.chatbox').classList.contains('minimize')) {
                // remove any classes and close the chatbox
                document.querySelector('.chatbox').classList.remove('maximize');
                document.querySelector('.chatbox').classList.remove('minimize');
                document.querySelector('.chatbox').setAttribute('style', 'display:none');
            } else if (document.querySelector('.chatbox').classList.contains('maximize')) {
                document.querySelector('.chatbox').classList.remove('maximize');
            }
            // hide the chatbox
            this.show = false;
        }
    }
}
</script>