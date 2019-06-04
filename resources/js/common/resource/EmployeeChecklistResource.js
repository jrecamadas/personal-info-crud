import { BaseResource } from '@common/resource/BaseResource';

class EmployeeChecklistResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-checklist/:id'
        };

        super(options);
    }
}

export default new EmployeeChecklistResource();