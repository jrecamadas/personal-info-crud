import { SurveySent } from '@common/model/client-feedback/SurveySent';

const getSurveySent = (context, payload) => SurveySent.get(payload.query).then((res) => {
    context.commit('CLEAR_STATES');
    context.commit('GET_SURVEY_SENT', { data: res.data, extra: payload.extra });
    context.commit('SAVE_META', res.meta);
});

const updateSurveySentRemarks = (context, payload) => {
    const { id } = payload;
    const data = {
        remarks: payload.remarks,
        isExpired: 1,
    };

    const surveySent = new SurveySent({ id });

    return surveySent.save(data).then((res) => {
        context.commit('SURVEY_SENT_UPDATED', { data: res.data });
    });
};

export { getSurveySent, updateSurveySentRemarks };
