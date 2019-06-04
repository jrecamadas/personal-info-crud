import { BaseResource } from '@common/resource/BaseResource';

class EmployeeLeaveCreditHistoryResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-leave-credit-histories/:id'
        };

        super(options);
    }
}

export default new EmployeeLeaveCreditHistoryResource();
