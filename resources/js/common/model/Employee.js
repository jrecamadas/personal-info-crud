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
import EmployeeResource from '@common/resource/EmployeeResource';
import { EmployeeSpouse } from '@common/model/EmployeeSpouse';
import { EmployeeDependent } from '@common/model/EmployeeDependent';

export class Employee extends BaseModel {
    constructor(data) {
        let relations = {
            'data': Employee,
            'positions': EmployeeJobPosition,
            'interests': EmployeeInterest,
            'educations': EmployeeEducation,
            'governmentIds': GovernmentId,
            'WorkExperience': WorkExperience,
            'shift': EmployeeWorkShift,
            'contactPerson': ContactPerson,
            'address': Address,
            'user': User,
            'spouse': EmployeeSpouse,
            'dependents': EmployeeDependent
        };

        super(data, relations);
    }

    static get resource() {
        return EmployeeResource;
    }
}
