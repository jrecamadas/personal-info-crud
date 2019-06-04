import { BaseModel } from '@common/model/BaseModel';
import ApplicantResource from '@common/resource/ApplicantResource';

export class Applicant extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Applicant
        };

        super(data, relations);
    }

    static get resource() {
        return ApplicantResource;
    }
}
