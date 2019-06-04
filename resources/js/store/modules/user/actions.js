import { User } from '@common/model/User';

const setUserData = (context, payload) => {
    context.commit('USER_LOGGED_IN_DATA', payload);
}

const getUsers = (context, payload) => {
	return User.get(payload.query).then((res) => {
		context.commit('CLEAR_STATES');
		context.commit('GET_USERS', {data: res.data, extra: payload.extra});
		context.commit('SAVE_META', res.meta);
	});   
}

const getUser = (context, payload) => {
	 return User.get({id:payload}).then((res) => {
        context.commit('CLEAR_USER');
        context.commit('GET_USER', {data: res.data});
    });
}

const checkUsername = (context, payload) => {
    return User.get(payload).then((res) => {
        context.commit('CLEAR_USER');
        context.commit('GET_USER', {data: res.data});
    });
}

const checkEmail = (context, payload) => {
    return User.get(payload).then((res) => {
        context.commit('CLEAR_USER');
        context.commit('GET_USER', {data: res.data});
    });
}

const deleteUser = (context, payload) => {
    const user = new User({id: payload});
    return user.delete().then((res) => {
        context.commit('DELETE_USER',{});
    });
}

const saveUser = (context, payload) => {
    let data = {};
    let id = payload.id;
    let user = (id != "" && id > 0) ? new User({ id: id }) : new User();

    if(payload.password) {
        data = {
            password: payload.password,
            is_verified: payload.is_verified,
            can_login: payload.can_login, 
            user_name: payload.user_name, 
            email: payload.email,
            updated_by_user_id: payload.updated_by_user_id
        };
    } else {
        data = {
            is_verified: payload.is_verified,
            can_login: payload.can_login, 
            user_name: payload.user_name, 
            email: payload.email,
            updated_by_user_id: payload.updated_by_user_id
        };
    }
    
    return user.save(data);
}


export {
    setUserData,
    getUsers,
    getUser,
    deleteUser,
    saveUser,
    checkUsername,
    checkEmail
}
