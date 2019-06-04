import { BaseModel } from '@common/model/BaseModel';
import AddressResource from '@common/resource/AddressResource';

export class Address extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Address
        };

        super(data, relations);
    }

    static get resource() {
        return AddressResource;
    }
}
