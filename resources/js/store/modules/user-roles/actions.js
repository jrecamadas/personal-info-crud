import { UserRole } from '@common/model/acl/UserRole';

const getUserRole = (context, id) => {
    context.commit('CLEAR_STATES');
    return UserRole.get(id).then((res) => {
        context.commit('GET_USER', res.data);
    }).catch((e) => {
        return [];
        //throw new Error('Can\'t find user role!');
    })
};

// get all user roles
const getUserRoles = (context, payload) => {
    return UserRole.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_USER_ROLE', {data: res.data, extra: payload.extra});
    });
};

const saveUserRole = (context, payload) => {
    const id = payload.id;
    const userRole = (id != null && id != "" && id > 0) ? new UserRole({ id:id }) : new UserRole();
    let data = { 
        is_enabled: payload.is_enabled, 
        user_id: payload.user_id, 
        role_id: payload.role_id 
    };
    
    return userRole.save(data);
}

const deleteUserRole = (context, id) => {
    const userRole = new UserRole({id: id});
    return userRole.delete().then((res) => {
        context.commit('DELETE_USER_ROLE');
    });
};

export {
    getUserRole,
    getUserRoles,
    saveUserRole,
    deleteUserRole
}
