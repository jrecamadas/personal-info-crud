/* eslint-disable import/no-extraneous-dependencies */
import { EmailTemplate } from '@common/model/client-feedback/EmailTemplate';

const getEmailTemplates = (context, payload) => EmailTemplate.get(payload.query).then((res) => {
    context.commit('CLEAR_STATES');
    context.commit('GET_EMAIL_TEMPLATES', {
        data: res.data,
        extra: payload.extra,
    });
    context.commit('META_SET', res.meta);
});

const getEmailTemplate = (context, payload) => EmailTemplate.get(payload.query).then((res) => {
    context.commit('CLEAR_EDIT_EMAIL');
    context.commit('GET_EMAIL_TEMPLATE', res.data);
});

const saveEmailTemplate = (context, payload) => {
    const { id } = payload;
    const data = {
        templateName: payload.emailName,
        emailSubject: payload.emailSubject,
        emailBody: payload.emailBody,
    };
    const emailtemplate = id !== '' && id > 0 ? new EmailTemplate({ id }) : new EmailTemplate();
    return emailtemplate.save(data).then((res) => {
        context.commit('CUSTOM_EMAIL', { data: res.data });
        context.commit('EMAIL_TEMPLATES_UPDATED', { data: res.data });
    });
};

const clearCustomEmail = (context) => {
    context.commit('CLEAR_CUSTOM_EMAIL');
};

const editEmailTemplate = (context, payload) => {
    // const id = payload.id;
    const data = {
        id: payload.id,
        templateName: payload.templateName,
        emailSubject: payload.emailSubject,
        emailBody: payload.emailBody,
    };
    context.commit('CLEAR_EDIT_EMAIL');
    context.commit('EDIT_EMAIL_TEMPLATE', data);
};

const updateTemplateStatus = (context, payload) => {
    const data = {
        isActive: payload.isActive,
    };
    const emailtemplate = new EmailTemplate();
    return emailtemplate.save(data).then((res) => {
        context.commit('EMAIL_TEMPLATES_UPDATED', { data: res.data });
    });
};

const deleteEmailTemplate = (context, id) => {
    const emailtemplate = new EmailTemplate({ id });
    return emailtemplate.delete().then(res => ((res) ? 0 : 1));
};

export {
    getEmailTemplates,
    saveEmailTemplate,
    deleteEmailTemplate,
    updateTemplateStatus,
    editEmailTemplate,
    getEmailTemplate,
    clearCustomEmail,
};
