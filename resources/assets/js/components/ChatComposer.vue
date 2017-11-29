<template lang="html">
    <div :class="errorClassObject('message')" class="chat-composer">
        <textarea v-bind:rows="rows" placeholder="コメントを書く" v-model="messageText" v-on:keydown="handleCmdEnter($event)"></textarea>
        <button type="submit" class="btn btn-primary" @click="sendMessage" :disabled="isValid == false"><i class="glyphicon glyphicon-arrow-up"></i> 送信<br>({{maxLength - messageText.length}}/{{maxLength}})</button>
    </div>
</template>

<script>
// 現在時刻を取得するため
import moment from 'moment'

export default {
    data() {
        return {
            messageText: '',
            maxLength: 50,
        }
    },
    computed: {
        rows:function(){
            var num = this.messageText.split("\n").length;
            return (num > 1) ? num : 1;
        },
        validation() {
            return {
                message: (!!this.messageText && this.messageText.length <= this.maxLength),
            }
        },
        isValid() {
            const validation = this.validation
            return Object
            .keys(validation)
            .every(function (key) {
                return validation[key]
            })
        }
    },
    methods: {
        handleCmdEnter: function (e) {
            if ((e.metaKey || e.ctrlKey) && e.keyCode == 13) {
                if (this.validation.message == false) {
                    // error
                }else{
                    this.sendMessage();
                }

            }
        },
        errorClassObject(key) {
          return {
            'has-error': (this.validation[key] == false)
          }
        },
        sendMessage() {
            axios.get('/user').then(response => {
                this.$emit('messagesent', {
                    comment: this.messageText,
                    user: response.data,
                    created_at: moment().format('YYYY/MM/DD HH:mm:ss'),
                });
                this.messageText = '';
            });
        }
    }
}
</script>

<style lang="css">
.chat-composer {
    display: flex;
}

.chat-composer textarea {
    flex: 1 auto;
    padding: .5rem 1rem;
}

.chat-composer button {
    border-radius: 0;
}
</style>
