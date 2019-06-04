import { BaseResource } from '@common/resource/BaseResource';

class CheckPasswordResource extends BaseResource {
    constructor() {
        let options = {
            url: '/checkpass'
        };

        super(options);
    }
}

export default new CheckPasswordResource();
