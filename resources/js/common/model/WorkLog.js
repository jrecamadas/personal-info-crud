import { BaseModel } from '@common/model/BaseModel';
import WorkLogResource from '@common/resource/WorkLogResource';

export class WorkLog extends BaseModel {
    constructor(data) {
        let relations = {
            'data': WorkLog
        };

        super(data, relations);
    }

    static get resource() {
        return WorkLogResource;
    }
}
