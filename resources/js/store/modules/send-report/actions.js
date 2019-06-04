import { SendReport } from '@common/model/SendReport';

const send = (context, payload) => {
    let sendReport = new SendReport()
    return sendReport.save(payload).then((res) => {
        context.commit('SEND_REPORT', {data:res});
    });
};


export {
    send
}
