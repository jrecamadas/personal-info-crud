import { BaseResource } from '@common/resource/BaseResource';

class EmployeeInterestResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-interests/:id'
        };

        super(options);
    }
}

export  default new EmployeeInterestResource();
