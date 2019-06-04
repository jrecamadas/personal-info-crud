import { BaseResource } from '@common/resource/BaseResource';

class EmployeeReportResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-reports/:id'
        };

        super(options);
    }
}

export default new EmployeeReportResource();
