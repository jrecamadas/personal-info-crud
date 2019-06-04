import { BaseResource } from '@common/resource/BaseResource';

class LeaveRequestResource extends BaseResource {
    constructor() {
        let options = {
            url: '/leave-requests/:id'
        };

        super(options);
    }
}

export default new LeaveRequestResource();
