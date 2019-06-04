import { BaseResource } from '@common/resource/BaseResource';

class QuestionResource extends BaseResource {
    constructor() {
        const options = {
            url: '/feedback/questions/:id',
        };

        super(options);
    }
}

export default new QuestionResource();
