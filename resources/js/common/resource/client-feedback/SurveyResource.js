import { BaseResource } from '@common/resource/BaseResource';

class SurveyResource extends BaseResource {
    constructor() {
        const options = {
            url: '/feedback/project-surveys/:id',
        };

        super(options);
    }
}

export default new SurveyResource();
