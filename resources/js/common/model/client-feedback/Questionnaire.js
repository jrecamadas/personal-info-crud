/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import QuestionnaireResource from '@common/resource/client-feedback/QuestionnaireResource';

export class Questionnaire extends BaseModel {
    constructor(data) {
        const relations = {
            data: Questionnaire,
        };

        super(data, relations);
    }

    static get resource() {
        return QuestionnaireResource;
    }
}
