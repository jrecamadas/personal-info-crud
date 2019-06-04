import { BaseModel } from '@common/model/BaseModel';
import PersonalInformationResource from '@common/resource/PersonalInformationResource';

export class Personal_Info extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Personal_Info
        };
        super(data, relations);
    }
    static get resource() {
        return PersonalInformationResource;
    }
}
