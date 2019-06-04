import { BaseResource } from '@common/resource/BaseResource';

class LeaveApproverResource extends BaseResource {
    constructor() {
        let options = {
            url: '/leave-approvers/:id'
        };

        super(options);
    }
}

export default new LeaveApproverResource();
