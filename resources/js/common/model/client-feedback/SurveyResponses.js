/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import SurveyResponsesResource from '@common/resource/client-feedback/SurveyResponsesResource';

export class SurveyResponses extends BaseModel {
    constructor(data) {
        const relations = {
            data: SurveyResponses,
        };

        super(data, relations);
    }

    static get resource() {
        return SurveyResponsesResource;
    }
}
