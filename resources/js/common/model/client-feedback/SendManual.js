/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import SendManualResource from '@common/resource/client-feedback/SendManualResource';

export class SendManual extends BaseModel {
    constructor(data) {
        const relations = {
            data: SendManual,
        };

        super(data, relations);
    }

    static get resource() {
        return SendManualResource;
    }
}
