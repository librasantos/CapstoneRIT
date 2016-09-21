require('../bootstrap');

class AdminService {

    constructor(){
        this._userResource = Vue.resource('/api/users');
        this._groupResource = Vue.resource('/api/groups');
        this._userGroupsResource = Vue.resource('/api/users/{userId}/groups{/groupId}');
    }

    getUsers() {
        return this._userResource.get();
    }

    getGroups() {
        return this._groupResource.get();
    }

    attachUserToGroup(userId, groupId) {
        return this._userGroupsResource.post({userId: userId, groupId: groupId});
    }

    detachUserToGroup(userId, groupId) {
        return this._userGroupsResource.delete({userId: userId, groupId: groupId});
    }

    getUserGroups(userId) {
        return this._userGroupsResource.get({userId: userId});
    }

}

export let adminService = new AdminService();