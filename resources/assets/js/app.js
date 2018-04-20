
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// import Vue from 'vue'
// import VueRouter from 'vue-router'

require('./bootstrap');

// Vue.use(VueRouter)

window.Vue = require('vue');
// window.axios = require('axios')

// Vue.prototype.$http = window.axios


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chat-message', require('./components/ChatMessage.vue'));
Vue.component('guest-chat-message', require('./components/GuestChatMessage.vue'));
Vue.component('chat-log', require('./components/ChatLog.vue'));
Vue.component('chat-composer', require('./components/ChatComposer.vue'));

if(document.getElementById("app")){
    
    // const router = new VueRouter ({
    //     mode: 'history',
    //     routes: [
    //         { path: '/detaill/:id', component: require('./components/Index.vue') },
    //     ]
    // });

    function getIDfromURL(){
    
         //Grab the path from your URL. In your case /writers/1/books/
        var path = window.location.pathname;
                
        //Break the path into segments
        var segments = path.split("/");
    
        //Return the segment that has the ID
        return segments[2];
    }
    
    // function getAuthUser(){
    //     axios.get('/user').then(response => {
    //         console.log('get auth user');
    //         return response.data;
    //     });
    // }

    var id = getIDfromURL();

    // var authUser = getAuthUser();

    // console.log('~~~~~~');
    // console.log(authUser);
    

    const app = new Vue({
        el: '#app',
        data: {
            messages: [],
            usersInRoom: [],
        },
        methods: {
            addMessage(message) {
                // Persist to the database etc
                axios.post('/messages/' + id, message).then(response => {
                    // Do whatever;
                    console.log(response.data['status']);
                    if(response.data.status === "OK"){
                        // Add to existing messages
                        this.messages.unshift(message);
                    }else if(response.data.status === "NG"){
                        alert('コメント送信に失敗しました。');
                    }
                })

            }
            // addMessage(message) {
            //     // Add to existing messages
            //     this.messages.push(message);
    
            //     // Persist to the database etc
            //     axios.post('/messages', message).then(response => {
            //         // Do whatever;
            //     })
            // }
        },
        created() {
            axios.get('/messages/' + id).then(response => {
                this.messages = response.data;
            });
            // axios.get('/messages').then(response => {
            //     this.messages = response.data;
            // });
            
            Echo.join('chatroom.' + id)
                .here((users) => {
                    this.usersInRoom = users;
                })
                .joining((user) => {
                    this.usersInRoom.push(user);
                })
                .leaving((user) => {
                    this.usersInRoom = this.usersInRoom.filter(u => u != user)
                })
                .listen('MessagePosted', (e) => {
                    this.messages.unshift({
                        comment: e.message.comment,
                        user: e.user,
                        created_at: e.message.created_at
                    });
                    console.log(e.message)
                });
        }
    });
    
}