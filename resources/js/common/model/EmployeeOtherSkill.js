import { BaseModel } from '@common/model/BaseModel';
import EmployeeOtherSkillResource from '@common/resource/EmployeeOtherSkillResource';

export class EmployeeOtherSkill extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeOtherSkill
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeOtherSkillResource;
    }
}
