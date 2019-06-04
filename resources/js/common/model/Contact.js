import { BaseModel } from '@common/model/BaseModel';
import ContactResource from '@common/resource/ContactResource';

export class Contact extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Contact
        };

        super(data, relations);
    }

    static get resource() {
        return ContactResource;
    }
}
