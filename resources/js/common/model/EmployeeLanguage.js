import { BaseModel } from '@common/model/BaseModel';
import EmployeeLanguageResource from '@common/resource/EmployeeLanguageResource';

export class EmployeeLanguage extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeLanguage
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeLanguageResource;
    }
}
