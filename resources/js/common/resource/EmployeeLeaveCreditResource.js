import { BaseResource } from '@common/resource/BaseResource';

class EmployeeLeaveCreditResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-leave-credits/:id'
        };

        super(options);
    }
}

export default new EmployeeLeaveCreditResource();
