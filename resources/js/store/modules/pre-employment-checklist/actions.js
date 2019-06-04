import { PreEmploymentChecklist } from '@common/model/PreEmploymentChecklist';

// get all Inventories
const getPreEmploymentChecklist = (context, payload) => {
    return PreEmploymentChecklist.get(payload.query).then((res) => {
        context.commit('PRE_EMPLOYMENT_CHECKLISTS_UPDATED', res);
    });
};

export {
    getPreEmploymentChecklist,
}
