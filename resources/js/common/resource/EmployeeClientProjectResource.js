import { BaseResource } from '@common/resource/BaseResource';

class EmployeeClientProjectResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-client-projects/:id'
        };
        super(options);
    }
}

export default new EmployeeClientProjectResource();
