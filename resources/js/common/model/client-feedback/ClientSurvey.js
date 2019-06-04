/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import { SurveyResponses } from '@common/model/client-feedback/SurveyResponses';
import ClientSurveyResource from '@common/resource/client-feedback/ClientSurveyResource';

export class ClientSurvey extends BaseModel {
    constructor(data) {
        const relations = {
            data: ClientSurvey,
            surveyResponses: SurveyResponses,
        };

        super(data, relations);
    }

    static get resource() {
        return ClientSurveyResource;
    }
}
