<template>
    <div class="panel panel-default">
        <div class="panel-heading">Friends List</div>
        <table class="table table-striped">
            <tbody>
            <transition name="user-row" enter-active-class="slideInUp" leave-active-class="slideOutDown">
                <tr v-for="friend in friends" class="animated">
                    <td><img class="user-avatar" :src="friend.user_avatar" :alt="friend.full_name"/></td>
                    <td>{{ friend.id }}</td>
                    <td>{{ friend.full_name }}</td>
                    <td>{{ friend.email }}</td>
                    <td>
                        <a @click.prevent="startConversation(user.id, friend.id)"  :data-sid="user.id" :data-rid="friend.id"
                           class="btn btn-success btn-xs">Start Conversation</a>
                    </td>
                </tr>
            </transition>
            </tbody>
        </table>
    </div>
</template>

<script type="text/babel">
export default {
    name: 'friends-list',
	props: {
        friends: {
			required: true,
			twoWay: true
		},
		user: {
			required: true,
			twoWay: true
		}
	},
	data() {
		return {
			apiToken: Setting.csrfToken,
		};
	},
	ready() {
	},
	methods: {
		startConversation(sid, rid) {
			// create a new conversation
			this.$http.post('/api/v1/conversations', {
				api_token: this.apiToken, sender_id: sid, recipient_id: rid
			}).then(function(response) {
				// log the conversation id
				console.log('conversation: ' , response.data.conversation);
				// broadcast new conversation
				this.$dispatch('newConversation', response.data.conversation);
				// create a new chat window
			}, function(response) {
				// error callback
				console.log(response);
			});
		}
	}
};
</script>