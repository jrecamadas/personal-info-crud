import { BaseResource } from '@common/resource/BaseResource';

class ApproverResource extends BaseResource {
    constructor() {
        let options = {
            url: '/approver/:id'
        };

        super(options);
    }
}

export  default new ApproverResource();
