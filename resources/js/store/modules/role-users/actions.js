import { RoleUser } from '@common/model/acl/RoleUser';

const getUserRole = (context, id) => {
    context.commit('CLEAR_STATES');
    return RoleUser.get({id:id}).then((res) => {
        context.commit('USER_ROLE_UPDATED', {data: res.data});
    }).catch((e) => {
        return [];
        //throw new Error('Can\'t find user role!');
    })
};

// get all user roles
const getUserRoles = (context, payload) => {
    return RoleUser.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_USER_ROLE', {data: res.data, extra: payload.extra});
    });
};

const saveUserRole = (context, payload) => {
    const id = payload.id;
    const contact = (id != null && id != "" && id > 0) ? new RoleUser({id:id}) : new RoleUser();
    return contact.save(payload).then( (res) => {
        context.commit('USER_ROLE_UPDATED', {data: res.data});
    });
}

export {
    getUserRole,
    getUserRoles,
    saveUserRole
}
