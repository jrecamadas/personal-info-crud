import { BaseResource } from '@common/resource/BaseResource';

class EmployeeLocationResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-locations/:id'
        };

        super(options);
    }
}

export default new EmployeeLocationResource();
