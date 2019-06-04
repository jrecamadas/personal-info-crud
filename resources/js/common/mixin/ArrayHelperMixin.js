import _ from 'lodash';

export default {
    methods: {
        isEmpty(arr) {
            return arr.length === 0;
        },
        isObjectExists(arr, prop, val) {
            return _.findIndex(arr, (o) => o[prop] == val) > -1;
        }
    }
}
