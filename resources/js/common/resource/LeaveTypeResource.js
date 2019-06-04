import { BaseResource } from '@common/resource/BaseResource';

class LeaveTypeResource extends BaseResource {
    constructor() {
        let options = {
            url: '/leave-types/:id'
        };

        super(options);
    }
}

export default new LeaveTypeResource();
