import _ from 'lodash';

export default {
    methods: {
        setValueFrom(defaultValue, newValue) {
            _.forOwn(defaultValue, (value, key) => {
                if (newValue && newValue.hasOwnProperty(key)) {
                    defaultValue[key] = newValue[key];
                }
            });

            return defaultValue;
        },
        isUserAdmin(data) {
            let adminUsers = [
                "mattdecoursey",
                "admin",
                "superadmin"
            ];

            if(_.includes(adminUsers, data.data.user_name)) {
                return true;
            } 
            return false;
        }
    }
}
