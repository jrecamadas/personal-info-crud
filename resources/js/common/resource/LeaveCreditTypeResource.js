import { BaseResource } from '@common/resource/BaseResource';

class LeaveCreditTypeResource extends BaseResource {
    constructor() {
        let options = {
            url: '/leave-credit-types/:id'
        };

        super(options);
    }
}

export default new LeaveCreditTypeResource();
