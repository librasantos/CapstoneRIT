<template>
    <div >
        <a href="#" v-for="contact in list"
           class="list-group-item"
           v-bind.class="{'active': (selectedContact && selectedContact.id === contact.id)}"
           @click="selectContact(contact)" >
            {{ contact.name }}
            <span v-if="contact.messagesCount" class="badge">{{ contact.messagesCount }}</span>
        </a>
    </div>

</template>

<script>
    import { chatService } from './ChatService';

    export default{
        props: [
            'list',
        ],
        created () {

        },

        data(){
            return{
                selectedContact: null,
        }
        },
        methods : {
            selectContact(contact) {
                contact.messagesCount = 0;
                this.selectedContact = contact;
                this.$emit('selection', contact);
            }
        },
        components: {},

    }
</script>
