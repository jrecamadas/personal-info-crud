import { BaseResource } from '@common/resource/BaseResource';

class EmployeeEducationResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-educations/:id'
        };

        super(options);
    }
}

export default new EmployeeEducationResource();
