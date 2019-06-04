import { BaseModel } from '@common/model/BaseModel';
import LeaveRequestResource from '@common/resource/LeaveRequestResource';

export class LeaveRequest extends BaseModel {
    constructor(data) {
        let relations = {
            'data': LeaveRequest
        };

        super(data, relations);
    }

    static get resource() {
        return LeaveRequestResource;
    }
}
