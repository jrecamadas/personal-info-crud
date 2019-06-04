import { BaseResource } from '@common/resource/BaseResource';

class WorkShiftResource extends BaseResource {
    constructor() {
        let options = {
            url: '/work-shifts/:id'
        };

        super(options);
    }
}

export  default new WorkShiftResource();
