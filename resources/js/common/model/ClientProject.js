import { BaseModel } from '@common/model/BaseModel';
import ClientProjectResource from '@common/resource/ClientProjectResource';

export class ClientProject extends BaseModel {
    constructor(data) {
        let relations = {
            'data': ClientProject
        };

        super(data, relations);
    }

    static get resource() {
        return ClientProjectResource;
    }
}
