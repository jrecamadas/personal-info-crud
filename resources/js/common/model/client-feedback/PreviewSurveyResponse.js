/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import PreviewSurveyResponseResource from '@common/resource/client-feedback/PreviewSurveyResponseResource';

export class PreviewSurveyResponse extends BaseModel {
    constructor(data) {
        const relations = {
            data: '',
        };

        super(data, relations);
    }

    static get resource() {
        return PreviewSurveyResponseResource;
    }
}
