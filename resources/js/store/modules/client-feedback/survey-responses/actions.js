/* eslint-disable import/no-extraneous-dependencies */
import { SurveyResponses } from '@common/model/client-feedback/SurveyResponses';

const getSurveyResponses = (context, payload) => SurveyResponses.get(payload.query).then((res) => {
    context.commit('CLEAR_STATES');
    context.commit('GET_SURVEY_RESPONSES', { data: res.data, extra: payload.extra });
    context.commit('SAVE_META', res.meta);
});

const saveResponse = (context, payload) => {
    const { id } = payload;
    const data = {
        response: payload.response,
    };
    const surveyResponse = new SurveyResponses({ id });
    return surveyResponse.save(data);
};

export { getSurveyResponses, saveResponse };
