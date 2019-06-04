import { BaseModel } from '@common/model/BaseModel';
import ReportTemplateResource from '@common/resource/ReportTemplateResource';

export class ReportTemplate extends BaseModel {
    constructor(data) {
        let relations = {
            'data': ReportTemplate
        };

        super(data, relations);
    }

    static get resource() {
        return ReportTemplateResource;
    }
}
