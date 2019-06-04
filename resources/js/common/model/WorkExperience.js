import { BaseModel } from '@common/model/BaseModel';
import WorkExperienceResource from '@common/resource/WorkExperienceResource';

export class WorkExperience extends BaseModel {
    constructor(data) {
        let relations = {
            'data': WorkExperience
        };

        super(data, relations);
    }

    static get resource() {
        return WorkExperienceResource;
    }
}

