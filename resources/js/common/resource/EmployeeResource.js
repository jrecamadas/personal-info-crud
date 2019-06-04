import { BaseResource } from '@common/resource/BaseResource';

class EmployeeResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employees/:id'
        };

        super(options);
    }
}

export  default new EmployeeResource();
