import { apiGet, apiPost, apiPatch, apiDelete } from '../index'

//permissions
export function getPermissions(param) {
    return apiGet('/api/permissions/', param);
}

export function addPermission(param) {
    return apiPost('/api/permissions/', param);
}

export function updatePermission(param) {
    return apiPatch('/api/permissions/', param);
}

export function deletePermission(param) {
    return apiDelete('/api/permissions/' + param.id + '/');
}

export function getPermissionUserAndRoleMessage(param) {
    return apiGet('/api/permissions/' + param.id + '/message');
}

export function validatePermissionName(param) {
    return apiGet('/api/count/permissions/', param);
}


//roles-group
export function getRoles(param) {
    return apiGet('/api/roles/', param);
}

export function addRole(param) {
    return apiPost('/api/roles/', param);
}

export function updateRole(param) {
    return apiPatch('/api/roles/', param);
}

export function deleteRole(param) {
    return apiDelete('/api/roles/' + param.id + '/');
}

export function getRoleAboutUserAndPermissionMessage(param) {
    return apiGet('/api/roles/' + param.id + '/message');
}

export function validateRoleName(param) {
    return apiGet('/api/count/roles/', param);
}


//group permissions
export function getGroupPermissions(param) {
    return apiGet('/api/roles/' + param.id + '/permissions/', param.data);
}

export function postAssociateGroupPermissions(param) {
    return apiPost('/api/roles/' + param.id + '/permissions/', param.data);
}

export function deleteGroupPermissionAssociate(param) {
    return apiDelete('/api/roles/' + param.gid + '/permissions/' + param.pid + '/');
}

//group users
export function getGroupUsers(param) {
    return apiGet('/api/roles/' + param.id + '/users/', param.data);
}
export function postAssociateGroupUsers(param) {
    return apiPost('/api/roles/' + param.id + '/users/', param.data);
}
export function deleteGroupUserAssociate(param) {
    return apiDelete('/api/roles/' + param.gid + '/users/' + param.uid + '/');
}


//user
export function getUsers(param) {
    return apiGet('/api/users/', param);
}

export function addUser(param) {
    return apiPost('/api/users/', param);
}

export function updateUser(param) {
    return apiPatch('/api/users/', param);
}

export function deleteUser(param) {
    return apiDelete('/api/users/' + param.id + '/');
}

export function validateUserNameOrEmail(param) {
    return apiGet('/api/count/users/', param);
}

export function getUserAboutRolesAndPermissionsMessage(param) {
    return apiGet('/api/users/' + param.id + '/message/');
}

export function getUserLogs(param) {
    return apiGet('/api/userActivityLogs/', param);
}


export function activateAccountUserByUserId(param) {
    return apiGet('/api/users/active/', param);
}