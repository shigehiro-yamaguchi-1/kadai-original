<template lang="html">
    <div class="chat-message">
        <div class="right_balloon" v-if="authuser.id === message.user.id">
            <span style="white-space: pre-wrap;">{{ message.comment }}</span><br>
            <small><a v-bind:href="'/profile/' + message.user.id">{{ message.user.name }}</a> {{message.created_at}}</small>
        </div>
        <div class="left_balloon" v-else>
            <span style="white-space: pre-wrap;">{{ message.comment }}</span><br>
            <small><a v-bind:href="'/profile/' + message.user.id">{{ message.user.name }}</a> {{message.created_at}}</small>
        </div>
    </div>
</template>

<script>
export default {
    props: ['message', 'authuser']
}
</script>

<style lang="css">
/*
.chat-message {
    padding: 1rem;
}

.chat-message > p {
    margin-bottom: .5rem;
}
*/
</style>
