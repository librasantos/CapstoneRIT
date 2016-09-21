<template>
    <section>
        <div class="panel panel-primary" v-if="contact">

            <section class="panel-heading">
                {{ contact.name }}
            </section>

            <section class="panel-body">
                <!-- if messages.length -->
                <div v-if="messages.length"
                     class="sent-message alert alert-info"
                     v-for="m in messages"
                     v-bind:class="{'sender-message' : m.sender_id == contact.id, 'receiver-message': m.receiver_id == contact.id }">
                    {{ m.message }}
                </div>
                <!-- else ! messages.length -->
                <div class="alert alert-info"
                     v-if="! messages.length" >
                    No messages sent between you two.
                </div>
            </section>

            <form class="form panel-footer" @submit.prevent="submit">
                <textarea
                   name="message" id="message" v-model="messageInput"
                   cols="30" rows="2"
                   class="form-control"
                   placeholder="Type your message and hit enter." >

                </textarea>
                <button class="btn btn-info col-md-1">Send</button>
            </form>

        </div>

        <div v-if="! contact" class="alert alert-default">
            No contact selected.
        </div>
    </section>

</template>

<script type="text/javascript">

    import { chatService } from './ChatService';

    export default {
        props: ['messages', 'contact'],
        created () {
          console.log(this.contact);
        },
        data () {

            return {
                messageInput: '',
            }
        },

        methods: {
            submit() {
                console.log('Will send this message: '+ this.messageInput);
                chatService.sendMessage(this.contact.id, this.messageInput)
                    .then((resp) => {
                        this.messages.push(resp.data)
                        this.messageInput = '';
                        console.log('Message sent.');
                    });

            }
        }


    }
</script>
