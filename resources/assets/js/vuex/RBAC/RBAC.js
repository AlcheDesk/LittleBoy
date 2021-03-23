//TODO
//need import types, types is about mutations_types
import * as types from '../types'
import * as api from '../../axios/RBAC/RBAC'


const state = {
    permissions: {},
    roles: {},
    groupPermissions: {},
    groupUsers: {},
    users: {},
    userLogs: {}
};

const getters = {
    getPermissions(state) {
        return state.permissions;
    },
    getSelectPermissions(state) {
        return state.permissions.data ? state.permissions.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getRoles(state) {
        return state.roles;
    },
    getGroupPermissions(state) {
        return state.groupPermissions;
    },
    getGroupUsers(state) {
        return state.groupUsers;
    },
    getUsers(state) {
        return state.users;
    },
    getSelectUsers(state) {
        return state.users.data ? state.users.data.map(item => { return { label: item.name, value: item } }) : [];
    },
    getUserLogs(state) {
        return state.userLogs;
    }
};


const mutations = {
    [types.READ_PERMISSIONS](state, obj) {
        state.permissions = obj || {};
    },
    [types.READ_ROLES](state, obj) {
        state.roles = obj || {};
    },
    [types.READ_GROUP_PERMISSIONS](state, obj) {
        state.groupPermissions = obj || {};
    },
    [types.READ_GROUP_USERS](state, obj) {
        state.groupUsers = obj || {};
    },
    [types.READ_USERS](state, obj) {
        state.users = obj || {};
    },
    [types.READ_USER_LOGS](state, obj) {
        state.userLogs = obj || {};
    },
};

const actions = {
    readPermissions({ state, commit }, obj) {
        api.getPermissions(obj).then((res) => {
            commit('READ_PERMISSIONS', res);
        }, (err) => {
            console.log(err);
        })
    },
    addPermission({ commit }, obj) {
        return api.addPermission(obj);
    },
    updatePermission({ commit }, obj) {
        return api.updatePermission(obj);
    },
    deletePermission({ commit }, obj) {
        return api.deletePermission(obj);
    },
    readPermissionUserAndRoleMessage({ commit }, obj) {
        return api.getPermissionUserAndRoleMessage(obj);
    },
    validatePermissionName({ commit }, obj) {
        return api.validatePermissionName(obj);
    },
    readRoles({ state, commit }, obj) {
        api.getRoles(obj).then((res) => {
            commit('READ_ROLES', res);
        }, (err) => {
            console.log(err);
        })
    },
    addRole({ commit }, obj) {
        return api.addRole(obj);
    },
    updateRole({ commit }, obj) {
        return api.updateRole(obj);
    },
    deleteRole({ commit }, obj) {
        return api.deleteRole(obj);
    },
    readRoleAboutUserAndPermissionMessage({ commit }, obj) {
        return api.getRoleAboutUserAndPermissionMessage(obj);
    },
    validateRoleName({ commit }, obj) {
        return api.validateRoleName(obj);
    },
    readGroupPermissions({ commit }, obj) {
        api.getGroupPermissions(obj).then((res) => {
            commit('READ_GROUP_PERMISSIONS', res);
        }, (err) => {
            console.log(err);
        })
    },
    associateGroupAndPermissions({ commit }, obj) {
        return api.postAssociateGroupPermissions(obj);
    },
    deleteGroupPermissionAssociate({ commit }, obj) {
        return api.deleteGroupPermissionAssociate(obj);
    },
    readGroupUsers({ commit }, obj) {
        api.getGroupUsers(obj).then((res) => {
            commit('READ_GROUP_USERS', res);
        }, (err) => {
            console.log(err);
        })
    },
    associateGroupAndUsers({ commit }, obj) {
        return api.postAssociateGroupUsers(obj);
    },
    deleteGroupUserAssociate({ commit }, obj) {
        return api.deleteGroupUserAssociate(obj);
    },
    readUsers({ commit }, obj) {
        api.getUsers(obj).then((res) => {
            commit('READ_USERS', res);
        }, (err) => {
            console.log(err);
        })
    },
    addUser({ commit }, obj) {
        return api.addUser(obj);
    },
    updateUser({ commit }, obj) {
        return api.updateUser(obj);
    },
    deleteUser({ commit }, obj) {
        return api.deleteUser(obj);
    },
    validateUserNameOrEmail({ commit }, obj) {
        return api.validateUserNameOrEmail(obj);
    },
    getUserAboutRolesAndPermissionsMessage({ commit }, obj) {
        return api.getUserAboutRolesAndPermissionsMessage(obj);
    },
    readUserLogs({ commit }, obj) {
        api.getUserLogs(obj).then((res) => {
            commit('READ_USER_LOGS', res);
        }, (err) => {
            console.log(err);
        })
    },
    activateAccountUserByUserId({ commit }, obj) {
        return api.activateAccountUserByUserId(obj);
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}