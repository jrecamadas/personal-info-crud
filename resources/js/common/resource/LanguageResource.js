import { BaseResource } from '@common/resource/BaseResource';

class LanguageResource extends BaseResource {
    constructor() {
        let options = {
            url: '/languages/:id'
        };

        super(options);
    }
}

export default new LanguageResource();
