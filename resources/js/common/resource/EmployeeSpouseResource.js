import { BaseResource } from '@common/resource/BaseResource';

class EmployeeSpouseResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-spouse/:id'
        };

        super(options);
    }
}

export default new EmployeeSpouseResource();
