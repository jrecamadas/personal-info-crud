/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import SurveyResource from '@common/resource/client-feedback/SurveyResource';

export class Survey extends BaseModel {
    constructor(data) {
        const relations = {
            data: Survey,
        };

        super(data, relations);
    }

    static get resource() {
        return SurveyResource;
    }
}
