import { BaseResource } from '@common/resource/BaseResource';

class EmployeeOtherDetailResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-other-details/:id'
        };

        super(options);
    }
}

export  default new EmployeeOtherDetailResource();
