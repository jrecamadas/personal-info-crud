import { BaseResource } from '@common/resource/BaseResource';

class SkillResource extends BaseResource {
    constructor() {
        let options = {
            url: '/skills/:id'
        };

        super(options);
    }
}

export default new SkillResource();
