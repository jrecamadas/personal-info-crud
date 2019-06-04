import { BaseResource } from '@common/resource/BaseResource';

class EmployeeApproverResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-approvers/:id'
        };

        super(options);
    }
}

export default new EmployeeApproverResource();
