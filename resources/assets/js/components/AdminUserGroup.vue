<template>


    <section >
        <div class="panel panel-primary" v-if="user">
            <section class="panel-heading">
                {{ user.name }}
            </section>

            <form class="panel-body">
                <div v-for="g in groups">

                    {{ g.name }}: <br/>

                    <label class="btn btn-primary active">
                        <input type="checkbox" autocomplete="off" checked class="hidden" @change="toggle($event)"> Si
                    </label>

                </div>
            </form>
        </div>
        <div v-if="! user">
            No contact selected.
        </div>
    </section>
</template>

<script>

    export default{
        props: ['groups', 'user'],
        data(){
            return {
            }
        },
        methods: {
            toggle(event) {
                console.log('Will toggle', event.target.value);
                console.log(event.target.parentNode.attributes.class);
                if(event.target.value) {
                    event.target.parentNode.class.replace(/\ active$/, '');
                    event.target.value = 0;
                } else {
                    event.target.parentNode.attributes.class += ' active';
                    event.target.value = !event.target.value;
                }
                console.log(event.target.parentNode.attributes.class);

            },
            attach() {
                console.log('Attaching...');
            },
            detach() {
                console.log('Detaching...');
            }
        }

    }
</script>
