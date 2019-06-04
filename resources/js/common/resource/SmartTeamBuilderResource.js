import { BaseResource } from '@common/resource/BaseResource';

class SmartTeamBuilderResource extends BaseResource {
    constructor() {
        let options = {
            url: '/smart-team-builder/:id'
        };

        super(options);
    }
}

export  default new SmartTeamBuilderResource();
