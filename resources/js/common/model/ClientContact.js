import { BaseModel } from '@common/model/BaseModel';
import ClientContactResource from '@common/resource/ClientContactResource';

export class ClientContact extends BaseModel {
    constructor(data) {
        let relations = {
            'data': ClientContact
        };

        super(data, relations);
    }

    static get resource() {
        return ClientContactResource;
    }
}
