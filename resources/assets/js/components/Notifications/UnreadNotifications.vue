<template lang="html">
      <div class="title">Notifications<span class="badge">{{ countNotifications }}</span></div>
</template>

<script type="text/babel">
import { mapActions, mapGetters } from 'vuex'

export default {
    name: 'unread-notifications',
    computed: {
        ...mapGetters({
              countNotifications: 'getCountNotifications'
        })
    }
}
</script>