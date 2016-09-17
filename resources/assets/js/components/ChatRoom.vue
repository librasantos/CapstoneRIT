<template>

    <div class="panel panel-primary">

        <section class="panel-heading">
            {{ user.name }}
        </section>

        <section class="panel-body">


            <div class="sent-message sender-message alert alert-info"
                 v-for="m in messages"
                 v-bind.class="{'sender-message' : m.id !== user.id, 'receiver-message': m.id === user.id }">
                {{ m.message }}

            </div>
            <div class="alert alert-info"
                 v-if="! messages.length" >
                No messages sent between you two.
            </div>
            <!--<div class="sent-message sender-message alert alert-info">-->
                <!--Accusantium alias aspernatur at blanditiis corporis eaque ipsum, minima modi-->
                <!--mollitia neque officia quaerat quo quod recusandae unde vel voluptatem voluptatum? Et.-->
            <!--</div>-->

            <!--<div class="sent-message receiver-message alert alert-info">-->
                <!--Lorem ipsum dolor sit amet, consectetur adipisicing elit.-->
            <!--</div>-->



        </section>

        <form class="form panel-footer" @submit.prevent="submit">
              <textarea
                      name="message" id="message"
                      cols="30" rows="2"
                      class="form-control"
                      placeholder="Type your message and hit enter.">

              </textarea>
            <button class="btn btn-info col-md-1">Send</button>
        </form>

    </div>

</template>

<script type="text/javascript">
    export default {
        props: ['messages'],
        ready() {
            console.log('Component ready.');
        },

        data () {

            return {
                user: {
                    name: 'Junior Zapata',
                    id: 1
                },
//                messages: []
            }
        },

        methods: {
            submit(e) {
                e.preventDefault();
            }
        }


    }
</script>
