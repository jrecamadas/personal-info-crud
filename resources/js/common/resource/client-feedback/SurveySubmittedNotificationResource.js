import { BaseResource } from '@common/resource/BaseResource';

class SurveySubmittedNotificationResource extends BaseResource {
    constructor() {
        const options = {
            url: '/surveysubmitted/:id',
            public: {
                get: true,
            },
        };

        super(options);
    }
}

export default new SurveySubmittedNotificationResource();
