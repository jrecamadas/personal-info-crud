import { BaseModel } from '@common/model/BaseModel';
import EducationalAttainmentResource from '@common/resource/EducationalAttainmentResource';

export class EducationalAttainment extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EducationalAttainment
        };

        super(data, relations);
    }

    static get resource() {
        return EducationalAttainmentResource;
    }
}
