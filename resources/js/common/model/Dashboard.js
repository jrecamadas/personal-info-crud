import { BaseModel } from '@common/model/BaseModel';
import DashboardResource from '@common/resource/DashboardResource';

export class Dashboard extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Dashboard
        };

        super(data, relations);
    }

    static get resource() {
        return DashboardResource;
    }
}