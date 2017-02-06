<template lang="html">
    <button @click="notify()">??</button>
</template>

<script type="text/babel">
export default {
  props: ['message', 'title'],
  methods: {
      notify () {
          if (Notification.permission !== "granted") {
              Notification.requestPermission();
          } else {
              new Notification(this.title, {
                  body: this.message,
              });
          }
      }
  }
};
</script>