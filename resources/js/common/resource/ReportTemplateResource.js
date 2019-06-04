import { BaseResource } from '@common/resource/BaseResource';

class ReportTemplateResource extends BaseResource {
    constructor() {
        let options = {
            url: '/report-templates/:id'
        };

        super(options);
    }
}

export default new ReportTemplateResource();
