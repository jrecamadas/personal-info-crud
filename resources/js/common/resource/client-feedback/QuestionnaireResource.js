import { BaseResource } from '@common/resource/BaseResource';

class QuestionnaireResource extends BaseResource {
    constructor() {
        const options = {
            url: '/feedback/questionnaires/:id',
        };

        super(options);
    }
}

export default new QuestionnaireResource();
