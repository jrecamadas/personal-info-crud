import { BaseModel } from '@common/model/BaseModel';
import EmployeeSkillResource from '@common/resource/EmployeeSkillResource';

export class EmployeeSkill extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeSkill
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeSkillResource;
    }
}
