import { Survey } from '@common/model/client-feedback/Survey';

const getSurveys = (context, payload) => Survey.get(payload.query).then((res) => {
    context.commit('GET_SURVEYS', {
        data: res.data,
        extra: payload.extra,
    });
    context.commit('SAVE_META', res.meta);
});

const getSurvey = (context, payload) => Survey.get(payload.query).then((res) => {
    context.commit('CLEAR_SURVEY_DATA');
    context.commit('EDIT_SURVEY', {
        data: res.data,
    });
});

const saveSurvey = (context, payload) => {
    const { id } = payload;
    const data = {
        projectSurveyName: payload.projectSurveyName,
        questionnaireId: payload.questionnaireId,
        emailTemplateId: payload.emailTemplateId,
        projectId: payload.projectId,
        clientId: payload.clientId,
        recurringType: payload.recurringType,
        recipientId: payload.recipientId,
        isConfirmationNeeded: payload.isConfirmation,
        isConfirmed: payload.isConfirmed
    };

    const survey =
        id != '' && id > 0
            ? new Survey({
                id,
            })
            : new Survey();
    return survey.save(data).then((res) => {
        context.commit('SAVE_META', res.meta);
    });
};

const editSurvey = (context, payload) => {
    context.commit('EDIT_SURVEY', {
        data: payload,
    });
};

const clearSurveyData = (context) => {
    context.commit('CLEAR_SURVEY_DATA');
};

const deleteSurvey = (context, id) => {
    const survey = new Survey({
        id,
    });
    return survey.delete().then(res => ((res) ? 0 : 1));
};

export { getSurveys, getSurvey, saveSurvey, deleteSurvey, editSurvey, clearSurveyData };
