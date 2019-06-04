import { ResourceUserRolePermission } from '@common/model/acl/ResourceUserRolePermission';

const getUserRolePermissions = (context, payload) => {
    return ResourceUserRolePermission.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_USER_ROLE_PERMISSIONS', {data: res.data, extra: payload.extra});
    });
};

const saveUserRolePermission = (context, payload) => {
    const id    = payload.id;
    const data  = {
        can_add: payload.can_add,
        can_edit: payload.can_edit,
        can_view: payload.can_view,
        can_delete: payload.can_delete,
        resource_id: payload.resource_id,
        user_role_id: payload.user_role_id
    };
    const userRolePermission = (id != "" && id > 0) ? new ResourceUserRolePermission({id:id}) : new ResourceUserRolePermission();
    return userRolePermission.save(data);

};

export {
    getUserRolePermissions,
    saveUserRolePermission,
}
