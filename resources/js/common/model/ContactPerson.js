import { BaseModel } from '@common/model/BaseModel';
import ContactPersonResource from '@common/resource/ContactPersonResource';

export class ContactPerson extends BaseModel {
    constructor(data) {
        let relations = {
            'data': ContactPerson
        };

        super(data, relations);
    }

    static get resource() {
        return ContactPersonResource;
    }
}
