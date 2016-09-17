
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.config.debug = true;

// Vue.component('example', require('./components/Example.vue'));
Vue.component('chat-room', require('./components/ChatRoom.vue'));

const app = new Vue({
    created: function(){
        Echo.channel('message.*')
            .listen('.App.Events.MessageSent', (message) => {
                console.log('MessageSent: ' , message);
            });
    },
    data: function (){
        return {
            title: 'Some App Title',
            chatMessages: []
        };
    },
    methods: {
        chatWith : function (contact) {
            this.$http.get('/api/chat/'+ contact.id+'/messages')
                .then(function(data){
                    console.log(data.body);
                    this.chatMessages = data.body;
                });
        }
    }
}).$mount('#app');

// console.log('Will listen for events in message channels')

// Echo.channel('message.*')
//     .listen('.App.Events.MessageSent', (message) => {
//     console.log('MessageSent: ' + message.content);
// });


// Echo.channel('message.1')
//     .listen('MessageSent', (message) => {
//     console.log('MessageSent: ' + message.content);
// });
//
//
// Echo.channel('tv-shows')
//     .listen('TvShowAdded', (message) => {
//     console.log('TVShow: ' + message.title);
// });