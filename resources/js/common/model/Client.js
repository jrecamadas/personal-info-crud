import { BaseModel } from '@common/model/BaseModel';
import ClientResource from '@common/resource/ClientResource';
import { ClientContact } from '@common/model/ClientContact';
import { ClientProject } from '@common/model/EmployeeInterest';

export class Client extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Client,
            'contacts': ClientContact,
            //'projects': ClientProject
        };

        super(data, relations);
    }

    static get resource() {
        return ClientResource;
    }
}
