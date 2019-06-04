import { BaseResource } from '@common/resource/BaseResource';

class AssetResource extends BaseResource {
    constructor() {
        let options = {
            url: '/assets/:id'
        };

        super(options);
    }
}

export default new AssetResource();
