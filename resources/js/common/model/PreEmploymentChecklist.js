import { BaseModel } from '@common/model/BaseModel';
import PreEmploymentChecklistResource from '@common/resource/PreEmploymentChecklistResource';

export class PreEmploymentChecklist extends BaseModel {
    constructor(data) {
        let relations = {
            'data':PreEmploymentChecklist
        };

        super(data, relations);
    }

    static get resource() {
        return PreEmploymentChecklistResource;
    }
}
