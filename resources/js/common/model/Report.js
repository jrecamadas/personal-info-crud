import { BaseModel } from '@common/model/BaseModel';
import ReportResource from '@common/resource/ReportResource';

export class Report extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Report
        };

        super(data, relations);
    }

    static get resource() {
        return ReportResource;
    }
}
