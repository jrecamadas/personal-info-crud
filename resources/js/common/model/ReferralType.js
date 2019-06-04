import { BaseModel } from '@common/model/BaseModel';
import ReferralTypeResource from '@common/resource/ReferralTypeResource';

export class ReferralType extends BaseModel {
    constructor(data) {
        let relations = {
            'data': ReferralType
        };

        super(data, relations);
    }

    static get resource() {
        return ReferralTypeResource;
    }
}
