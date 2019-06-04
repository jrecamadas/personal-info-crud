import { BaseResource } from '@common/resource/BaseResource';

class PreEmploymentChecklistResource extends BaseResource {
    constructor() {
        let options = {
            url: '/pre-employment-checklist/:id'
        };

        super(options);
    }
}

export  default new PreEmploymentChecklistResource();
