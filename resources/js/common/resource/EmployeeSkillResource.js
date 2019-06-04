import { BaseResource } from '@common/resource/BaseResource';

class EmployeeSkillResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-skills/:id'
        };

        super(options);
    }
}

export  default new EmployeeSkillResource();
