import { Role } from '@common/model/acl/Role';

const getRoles = (context, payload) => {
    return Role.get(payload.query).then((res) => {
        context.commit('CLEAR_STATES');
        context.commit('GET_ROLES', {data: res.data, extra: payload.extra});
        context.commit('SAVE_META', res.meta);
    });
};

const fetchRole = (context, payload) => {
    var x = []
    
    payload.forEach(userRole => {
        const {id, display_name, is_enabled} = userRole.role.data;
        x.push({
            id: id,
            text: display_name,
            is_enabled: is_enabled
        });
    });
    
    context.commit('GET_ROLE', x);

    return x
}

const deleteRole = (context, id) => {
    const role = new Role({id: id});
    return role.delete().then((res) => {
        context.commit('DELETE_ROLE');
    });
};

const saveRole = (context, payload) => {
    const id    = payload.id;
    const data  = { 
        name: payload.name, 
        display_name: payload.display_name, 
        description: payload.description, 
        is_enabled: payload.is_enabled, 
        updated_by_user_id: payload.updated_by_user_id
    };

    const role = (id != "" && id > 0) ? new Role({ id:id }) : new Role();

    return role.save(data);
};

const getRole = (context, id) => {
    return Role.get({id:id}).then((res) => {
        context.commit('EDIT_ROLE', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find role!');
    })
}

const searchRoleByName = (context, name) => {
    return Role.get({name: name, withTrashed: true}).then((res) => {
        context.commit('EDIT_ROLE', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find role!');
    })
}

const saveMeta = (context, meta) => {
    context.commit('SAVE_META', meta);
};

export {
    getRoles,
    fetchRole,
    deleteRole,
    saveRole,
    getRole,
    searchRoleByName,
    saveMeta
}
