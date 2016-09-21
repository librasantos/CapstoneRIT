

require('./bootstrap');

Vue.config.debug = true;

Vue.component('group-asignment', require('./components/AdminUserGroup.vue'));
Vue.component('user-list', require('./components/AdminUserList.vue'));

import { adminService } from './components/AdminService';


const admin = new Vue({
    created: function() {

        adminService.getUsers().then(function (resp) {
            this.userList = resp.body;
        }.bind(this));

        adminService.getGroups().then(function(resp){
            this.groupList = resp.body;
        }.bind(this));
    },
    data: function() {
        return {
            userList: [],
            groupList: [],
            selectedUser: null,
        }
    },
    methods: {
        modifyUser: function(user) {
            this.selectedUser = user;
        }
    }
}).$mount('#app');