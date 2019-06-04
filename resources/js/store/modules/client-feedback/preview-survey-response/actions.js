/* eslint-disable import/prefer-default-export */
import { PreviewSurveyResponse } from '@common/model/client-feedback/PreviewSurveyResponse';

const getSurveyResponse = (context, payload) => PreviewSurveyResponse.get(payload).then((res) => {
    context.commit('CLEAR_STATES');
    context.commit('GET_SURVEY_RESPONSE', {
        data: res.data,
        extra: payload.extra,
    });
    context.commit('SAVE_META', res.meta);
});

export { getSurveyResponse };
