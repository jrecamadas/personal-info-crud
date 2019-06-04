import { BaseModel } from '@common/model/BaseModel';
import LeaveApproverResource from '@common/resource/LeaveApproverResource';

export class LeaveApprover extends BaseModel {
    constructor(data) {
        let relations = {
            'data': LeaveApprover
        };

        super(data, relations);
    }

    static get resource() {
        return LeaveApproverResource;
    }
}
