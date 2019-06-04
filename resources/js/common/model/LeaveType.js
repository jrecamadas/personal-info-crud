import { BaseModel } from '@common/model/BaseModel';
import LeaveTypeResource from '@common/resource/LeaveTypeResource';

export class LeaveType extends BaseModel {
    constructor(data) {
        let relations = {
            'data': LeaveType
        };

        super(data, relations);
    }

    static get resource() {
        return LeaveTypeResource;
    }
}
