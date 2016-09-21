require('../bootstrap');

class ChatService {

    constructor(){
        this._messageResource = Vue.resource('/api/chat/{id}/messages');
        this._contactResource = Vue.resource('/api/chat/contacts');
    }

    getMessages(userId) {
        return this._messageResource.get({id: userId});
    }

    sendMessage(toContactId, messageBody) {
        return this._messageResource.save({id: toContactId}, { message: { content : messageBody }});
    }

    getContacts() {
        return this._contactResource.get();
    }

}

export let chatService = new ChatService();