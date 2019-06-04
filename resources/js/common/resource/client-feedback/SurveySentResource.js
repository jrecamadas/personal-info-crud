import { BaseResource } from '@common/resource/BaseResource';

class SurveySentResource extends BaseResource {
    constructor() {
        const options = {
            url: '/feedback/survey-sent/:id',
        };

        super(options);
    }
}

export default new SurveySentResource();
