import { BaseResource } from '@common/resource/BaseResource';

class EmployeeOtherSkillResource extends BaseResource {
    constructor() {
        let options = {
            url: '/employee-other-skill/:id'
        };

        super(options);
    }
}

export  default new EmployeeOtherSkillResource();
