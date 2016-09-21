<template>
    <div >
        <a href="#" v-for="user in list"
           class="list-group-item"
           v-bind.class="{'active': (selectedUser && selectedUser.id === user.id)}"
           @click="select(user)" >
            {{ user.name }}
        </a>
    </div>
</template>

<script>
    export default{
        props: [
            'list',
        ],
        data(){
            return{
                selectedUser: null
            }
        },
        methods: {
            select(user) {
                this.selectedUser = user;
                this.$emit('selection', user);
            },
        },
    }
</script>
