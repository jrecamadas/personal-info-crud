/* eslint-disable import/prefer-default-export */
import { BaseModel } from '@common/model/BaseModel';
import EmailTemplateResource from '@common/resource/client-feedback/EmailTemplateResource';

export class EmailTemplate extends BaseModel {
    constructor(data) {
        const relations = {
            data: EmailTemplate,
        };

        super(data, relations);
    }

    static get resource() {
        return EmailTemplateResource;
    }
}
