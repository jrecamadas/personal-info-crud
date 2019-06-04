import { BaseResource } from '@common/resource/BaseResource';

class PreviewSurveyResponseResource extends BaseResource {
    constructor() {
        const options = {
            url: '/feedback/survey-responses',
        };

        super(options);
    }
}

export default new PreviewSurveyResponseResource();
