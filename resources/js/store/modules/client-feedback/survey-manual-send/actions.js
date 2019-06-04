/* eslint-disable import/prefer-default-export */
import { SendManual } from '@common/model/client-feedback/SendManual';

const sendManual = (context, payload) => {
    const { id } = payload;
    const data = {
        subject: payload.emailSubject,
        body: payload.emailBody,
        recipientId: payload.recipientId,
    };

    const send = new SendManual({ id });
    return send.save(data).then(() => {
        context.commit('CLEAR_STATES');
    });
};

export { sendManual };
