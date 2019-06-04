import { BaseModel } from '@common/model/BaseModel';
import ClientProjectStatusResource from '@common/resource/ClientProjectStatusResource';

export class ClientProjectStatus extends BaseModel {
    constructor(data) {
        let relations = {
            'data': ClientProjectStatus
        };

        super(data, relations);
    }

    static get resource() {
        return ClientProjectStatusResource;
    }
}