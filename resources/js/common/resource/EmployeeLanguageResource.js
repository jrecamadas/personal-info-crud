import { BaseResource } from '@common/resource/BaseResource';

class EmployeeLanguageResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-languages/:id'
        };

        super(options);
    }
}

export default new EmployeeLanguageResource();
