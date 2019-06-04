import { BaseResource } from '@common/resource/BaseResource';

class EmployeeWorkShiftResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-shifts/:id'
        };

        super(options);
    }
}

export  default new EmployeeWorkShiftResource();
