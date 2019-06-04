import { BaseModel } from '@common/model/BaseModel';
import ApproverResource from '@common/resource/ApproverResource';

export class Approver extends BaseModel {
    constructor(data) {
        let relations = {
            'data':Approver
        };

        super(data, relations);
    }

    static get resource() {
        return ApproverResource;
    }
}
