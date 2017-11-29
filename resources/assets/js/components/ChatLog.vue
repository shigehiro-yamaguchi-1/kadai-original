<template lang="html">
  <div class="chat-log">
      <chat-message v-for="message in messages" :message="message" :authuser="authuser" :key="message.id"></chat-message>
      <div class="empty" v-show="messages.length === 0">
          コメントはありません
      </div>
  </div>
</template>

<script>
export default {
    props: ['messages', 'authuser']
}
</script>

<style lang="css">

.empty {
    padding: 1rem;
    text-align: center;
}

</style>
