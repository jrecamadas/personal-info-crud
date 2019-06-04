import { BaseModel } from '@common/model/BaseModel';
import SendReportResource from '@common/resource/SendReportResource';

export class SendReport extends BaseModel {
    constructor(data) {
        let relations = {
            'data': SendReport
        };

        super(data, relations);
    }

    static get resource() {
        return SendReportResource;
    }
}
