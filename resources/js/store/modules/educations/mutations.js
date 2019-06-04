import _ from 'lodash';

const EDUCATIONS_UPDATED = (state, payload) => {
    state.education = payload.data;
}

const DELETE_EDUCATION = (state) => {}

export {
    EDUCATIONS_UPDATED,
    DELETE_EDUCATION
}
