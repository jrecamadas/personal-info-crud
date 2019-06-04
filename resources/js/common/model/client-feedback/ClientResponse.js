/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import ClientResponseResource from '@common/resource/client-feedback/ClientResponseResource';

export class ClientResponse extends BaseModel {
    constructor(data) {
        const relations = {
            data: ClientResponse,
        };

        super(data, relations);
    }

    static get resource() {
        return ClientResponseResource;
    }
}
