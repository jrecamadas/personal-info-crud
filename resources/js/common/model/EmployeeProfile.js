import { BaseModel } from '@common/model/BaseModel';
import { EmployeeJobPosition } from '@common/model/EmployeeJobPosition';
import { EmployeeInterest } from '@common/model/EmployeeInterest';
import { EmployeeEducation } from '@common/model/EmployeeEducation';
import { GovernmentId } from '@common/model/GovernmentId';
import { WorkExperience } from '@common/model/WorkExperience';
import { EmployeeWorkShift } from '@common/model/EmployeeWorkShift';
import { ContactPerson } from '@common/model/ContactPerson';
import { Address } from '@common/model/Address';
import { User } from '@common/model/User';
import EmployeeProfileResource from '@common/resource/EmployeeProfileResource';

export class EmployeeProfile extends BaseModel {
    constructor(data) {
        let relations = {
            'data': EmployeeProfile,
            'positions': EmployeeJobPosition,
            'interests': EmployeeInterest,
            'educations': EmployeeEducation,
            'governmentIds': GovernmentId,
            'WorkExperience': WorkExperience,
            'shift': EmployeeWorkShift,
            'contactPerson': ContactPerson,
            'address': Address,
            'user': User
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeProfileResource;
    }
}
