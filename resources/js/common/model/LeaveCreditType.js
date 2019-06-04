import { BaseModel } from '@common/model/BaseModel';
import LeaveCreditTypeResource from '@common/resource/LeaveCreditTypeResource';

export class LeaveCreditType extends BaseModel {
    constructor(data) {
        let relations = {
            'data': LeaveCreditType
        };

        super(data, relations);
    }

    static get resource() {
        return LeaveCreditTypeResource;
    }
}
