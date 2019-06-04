import { BaseResource } from '@common/resource/BaseResource';

class EmployeeStatusResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-statuses/:id'
        };

        super(options);
    }
}

export default new EmployeeStatusResource();
