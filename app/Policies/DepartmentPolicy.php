<?php
namespace App\Policies;

use App\Models\Department;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view departments');
    }

    public function view(User $user, Department $department)
    {
        if ($user->hasPermissionTo('view departments')) {
            // Company admins and managers can only view departments in their company
            if ($user->hasRole('company_admin') || $user->hasRole('manager')) {
                return $user->company_id === $department->company_id;
            }
            
            return true;
        }
        
        return false;
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create departments');
    }

    public function update(User $user, Department $department)
    {
        if ($user->hasPermissionTo('update departments')) {
            // Company admins can only update departments in their company
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $department->company_id;
            }
            
            return true;
        }
        
        return false;
    }

    public function delete(User $user, Department $department)
    {
        if ($user->hasPermissionTo('delete departments')) {
            // Company admins can only delete departments in their company
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $department->company_id;
            }
            
            return true;
        }
        
        return false;
    }
}
