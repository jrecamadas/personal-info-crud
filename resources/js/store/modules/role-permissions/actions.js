import { ResourceRolePermission } from '@common/model/acl/ResourceRolePermission';

const getPermissions = (context, payload) => {
    return ResourceRolePermission.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_PERMISSIONS', {data: res.data, extra: payload.extra});
    });
};

const getPermissionsByRoleId = (context, roleid) => {
    return ResourceRolePermission.get({role_id: roleid}).then((res) => {
        context.commit('CLEAR_STATES');
        //context.commit('GET_PERMISSIONS', {data: res.data);
        context.commit('SAVE_META', res.meta);
    });
};

const savePermission = (context, payload) => {
    const id    = payload.id;
    const data = { role_id: payload.role_id, resource_id: payload.resource_id, can_add: payload.can_add, can_edit: payload.can_edit, can_view: payload.can_view, can_delete: payload.can_delete };
    const role_permission = (id != "" && id > 0) ? new ResourceRolePermission({id:id}) : new ResourceRolePermission();
    return role_permission.save(data);
};

const saveMeta = (context, meta) => {
    context.commit('SAVE_META', meta);
};

export {
    getPermissions,
    getPermissionsByRoleId,
    savePermission,
    saveMeta
}
