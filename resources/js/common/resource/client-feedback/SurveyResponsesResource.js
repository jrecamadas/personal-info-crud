import { BaseResource } from '@common/resource/BaseResource';

class SurveyResponsesResource extends BaseResource {
    constructor() {
        const options = {
            url: '/feedback/survey-responses/:id',
        };

        super(options);
    }
}

export default new SurveyResponsesResource();
