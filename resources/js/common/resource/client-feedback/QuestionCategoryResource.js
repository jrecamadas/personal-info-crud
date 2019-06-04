import { BaseResource } from '@common/resource/BaseResource';

class QuestionCategoryResource extends BaseResource {
    constructor() {
        const options = {
            url: '/feedback/question-categories/:id',
        };

        super(options);
    }
}

export default new QuestionCategoryResource();
