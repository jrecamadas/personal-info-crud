import { AbilityBuilder, Ability } from '@casl/ability';

export const ability = new Ability();

export default function defineAbilityFor (user) {
    const { rules, can, cannot } = AbilityBuilder.extract();
    const userPermissions = user.permissions.data;
    const rolePermissions = user.role.data.permissions.data;
    let resourceVar = '';

    userPermissions.forEach(function (permission) {
        resourceVar = permission.resource.data.name;

        if(permission.can_add) {
            can('add', resourceVar);
        } else {
            cannot('add', resourceVar);
        }

        if(permission.can_edit) {
            can('update', resourceVar);
        } else {
            cannot('update', resourceVar);
        }

        if(permission.can_view) {
            can('view', resourceVar);
        } else {
            cannot('view', resourceVar);
        }

        if(permission.can_delete) {
            can('delete', resourceVar);
        } else {
            cannot('delete', resourceVar);
        }
    });
   
    return rules;
}