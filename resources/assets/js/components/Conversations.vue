<template lang="html">
    <transition name="conversations">
    <div class="conversations" v-show="show">
        <header>
            <div>
                <i class="messages-icon"></i>
                <span class="conversations-title">Messages</span>
                <nav>
                    <ul><li><i @click.prevent="show = false" class="fa fa-close">&nbsp;</i></li></ul>
                </nav>
            </div>
        </header>
        <div class="conversations-filters">
            <nav>
                <ul>
                    <li class="active filter-recent"><a @click.prevent="filterRecent"><i class="fa fa-history"></i> Recent</a></li>
                    <li class="filter-favorites"><a @click.prevent="filterFavorites"><i class="fa fa-star"></i> Favorites</a></li>
                    <li class="filter-archived"><a @click.prevent="filterArchived"><i class="fa fa-archive"></i> Archived</a></li>
                    <li class="filter-blocked"><a @click.prevent="filterBlocked"><i class="fa fa-ban"></i> Blocked</a></li>
                </ul>
            </nav>
        </div>
        <div class="conversations-search">
            <input v-model="searchText" @keyup="search"  placeholder="Search conversations">
        </div>
        <ul class="list">
            <li v-for="conversation in conversations" @click.prevent="toggleActive(conversation)" :class="isActive(conversation) ? 'active' : ''">
                <div v-if="conversation.sender_id === user.id">
                    <img :src="conversation.recipient.avatar" :alt="conversation.recipient.name"/>
                    <span class="conversation-content">
							<span class="conversation-name">{{ conversation.recipient.name }}</span><br>
							<span class="conversation-last-message">{{ lastMessage(conversation) }}</span>
						</span>
                    <span v-if="conversation.messages.length > 0" class="last-message-timestamp">
						{{ conversation.messages[conversation.messages.length -1].created_at | timeago }}
						</span>
                    <span v-else><br></span>
                </div>
                <div v-else>
                    <img :src="conversation.sender.avatar" :alt="conversation.sender.name"/>
                    <span class="conversation-content">
							<span class="conversation-name">{{ conversation.sender.name }}</span><br>
							<span class="conversation-last-message">{{ lastMessage(conversation) }}</span>
						</span>
                    <span v-if="conversation.messages.length > 0" class="last-message-timestamp">
						{{ conversation.messages[conversation.messages.length -1].created_at | timeago }}
						</span>
                    <span v-else><br></span>
                </div>
            </li>
        </ul>
    </div>
    </transition>
</template>

<script type="text/babel">
export default {
	props: {
		allConversations: {
			require: true,
			twoWay: true
		},
		conversations: {
			require: true,
			twoWay: true
		},
		show: {
			 type: Boolean,
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
			searchText: '',
			currentFilter: 'recent'
		}
	},
	ready() {
	},
	computed: {
		isSelected() {
			return this.active
		},
	},
	methods: {
		isActive(conversation) {
			return conversation.active
		},
		toggleActive(conversation) {
			conversation.active = ! conversation.active
			console.log(conversation.active)
			this.$dispatch('activateConversation', conversation)
			// scroll message into view
			setTimeout(function() {
				document.querySelector('.chatbox-content').scrollTop = 10000000
			}, 50)
		},
		lastMessage(conversation) {
			// return the last message and the name of the sender or You said...
			let lastMessageSent = conversation.messages[conversation.messages.length -1]
			// if we don't have a message, just return
			if (lastMessageSent === undefined) return ''
			// otherwise see if it's from the current user or not
			return lastMessageSent.user.id === this.user.id ?
				'You said ' + lastMessageSent.body.substr(0, 15) + '...' :
				lastMessageSent.user.name + ' said ' + lastMessageSent.body.substr(0, 15) + '...'
		},
		search() {
			// filter conversations by username
			this.conversations = this.conversations.filter(function(conversation) {
				console.log(conversation.sender.name)
				console.log(conversation.recipient.name)
				return conversation.sender.name.indexOf(this.searchText)  > -1 ||
					   conversation.recipient.name.indexOf(this.searchText) > -1
			}.bind(this))
			if (this.searchText.length === 0) {
				this.filter()
			}
		},
		clearSearch() {
			this.searchText = ''
			this.conversations = this.allConversations
		},
		filter() {
			switch(this.currentFilter) {
				case 'recent':
					this.filterRecent()
					break
				case 'favorites':
					this.filterFavorites()
					break
				case 'archived':
					this.filterArchived()
					break
				case 'blocked':
					this.filterBlocked()
					break
			}
		},
		filterRecent() {
			this.conversations = this.allConversations
			this.currentFilter = 'recent'
			console.log(this.allConversations)
			this.conversations = this.conversations.filter(function(conversation) {
				return !conversation.favorite && !conversation.blocked && !conversation.archived
			})
			// toggle .active css class
			// remove
			document.querySelector('.filter-favorites').classList.remove('active')
			document.querySelector('.filter-archived').classList.remove('active')
			document.querySelector('.filter-blocked').classList.remove('active')
			// add
			document.querySelector('.filter-recent').classList.add('active')
		},
		filterFavorites() {
			this.conversations = this.allConversations
			this.currentFilter = 'favorites'
			this.conversations = this.conversations.filter(function(conversation) {
				return conversation.favorite && !conversation.blocked && !conversation.archived
			})
			// toggle .active css class
			// remove
			document.querySelector('.filter-recent').classList.remove('active')
			document.querySelector('.filter-archived').classList.remove('active')
			document.querySelector('.filter-blocked').classList.remove('active')
			// add
			document.querySelector('.filter-favorites').classList.add('active')
		},
		filterArchived() {
			this.conversations = this.allConversations
			this.currentFilter = 'archived'
			this.conversations = this.conversations.filter(function(conversation) {
				return !conversation.blocked && conversation.archived
			})
			// toggle .active css class
			// remove
			document.querySelector('.filter-favorites').classList.remove('active')
			document.querySelector('.filter-recent').classList.remove('active')
			document.querySelector('.filter-blocked').classList.remove('active')
			// add
			document.querySelector('.filter-archived').classList.add('active')
		},
		filterBlocked() {
			this.conversations = this.allConversations
			this.currentFilter = 'blocked'
			this.conversations = this.conversations.filter(function(conversation) {
				return conversation.blocked
			})
			// toggle .active css class
			// remove
			document.querySelector('.filter-favorites').classList.remove('active')
			document.querySelector('.filter-archived').classList.remove('active')
			document.querySelector('.filter-recent').classList.remove('active')
			// add
			document.querySelector('.filter-blocked').classList.add('active')
		}
	}
}
</script>