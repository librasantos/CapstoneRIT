


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

import { chatService } from './components/ChatService';

Vue.component('chat-room', require('./components/ChatRoom.vue'));
Vue.component('contact-list', require('./components/ContactList.vue'));

const app = new Vue({
    created: function(){

        chatService.getContacts().then( function(resp) {

            this.contactList = resp.data;

            for(var i in this.contactList) {
                this.contactList[i].messageCount = this.contactList[i].messagesCount ? this.contactList[i].messagesCount : 0;
            }
            Echo.channel('message.' + window.UserId)
                .listen('.App.Events.MessageSent', function(data){
                    this.newMessage(data.message);
                }.bind(this));

        }.bind(this));

    },
    data: function (){
        return {
            title: 'Some App Title',
            chatMessages: [],
            contactList: [],
            selectedContact: null,
        };
    },
    methods: {
        chatWith : function (contact) {
            chatService.getMessages(contact.id)
                .then(function(resp){

                    this.chatMessages = resp.body;

                }.bind(this));
            this.selectedContact = contact;
        },
        newMessage: function(message) {
            var contact = this.getContactFromList(message.sender_id);
            if(this.selectedContact && this.selectedContact.id === message.sender_id) {
                //Add the message to the last in the chat room
                this.chatMessages.push(message);
            } else {
                // Increase the badge counter in the contactList
                contact.messagesCount++;
                // console.log('Now: ' , contact.messagesCount);
            }
            // console.log('I am '+ contact.id +'; MessageSent: ' , message);

            this.scroll();
        },

        scroll: function(){
            var el = document.querySelector('#app .panel-body')[0];
            el.scrollTop(el.scrollHeight);
        },
        getContactFromList: function(id){
            for(var i in this.contactList){
                if (this.contactList[i].id == id){
                    return this.contactList[i];
                }
            }
        },
        ready: function() {
            console.log('Readyy.')
        }

    }
}).$mount('#app');

