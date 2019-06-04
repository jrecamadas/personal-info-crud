import { Questionnaire } from '@common/model/client-feedback/Questionnaire';

const getQuestionnaires = (context, payload) => Questionnaire.get(payload.query).then((res) => {
    context.commit('CLEAR_STATES');
    context.commit('GET_QUESTIONNAIRE', { data: res.data, extra: payload.extra });
    context.commit('SAVE_META', res.meta);
});

const saveQuestionnaire = (context, payload) => {
    const { id } = payload;
    const data = {
        name: payload.name,
    };
    // eslint-disable-next-line eqeqeq
    const questionnaire = id != '' && id > 0 ? new Questionnaire({ id }) : new Questionnaire();
    return questionnaire.save(data);
};

const updateQuestionnaireStatus = (context, payload) => {
    const { id } = payload;
    const data = {
        isActive: payload.isActive,
    };
    const questionnaire = new Questionnaire({ id });
    return questionnaire.save(data);
};

export { getQuestionnaires, saveQuestionnaire, updateQuestionnaireStatus };
