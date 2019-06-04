/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import SurveySubmittedNotificationResource from '@common/resource/client-feedback/SurveySubmittedNotificationResource';

export class SurveySubmittedNotification extends BaseModel {
    constructor(data) {
        const relations = {
            data: SurveySubmittedNotification,
        };

        super(data, relations);
    }

    static get resource() {
        return SurveySubmittedNotificationResource;
    }
}
