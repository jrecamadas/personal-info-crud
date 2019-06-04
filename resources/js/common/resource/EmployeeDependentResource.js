import { BaseResource } from '@common/resource/BaseResource';

class EmployeeDependentResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-dependent/:id'
        };

        super(options);
    }
}

export default new EmployeeDependentResource();
