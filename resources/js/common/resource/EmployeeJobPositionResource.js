import { BaseResource } from '@common/resource/BaseResource';

class EmployeeJobPositionResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-positions/:id'
        };

        super(options);
    }
}

export  default new EmployeeJobPositionResource();
