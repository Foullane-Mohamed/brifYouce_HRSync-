<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view employees');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Employee $employee): bool
    {
        if ($user->hasPermissionTo('view employees')) {
            // Les admins d'entreprise ne peuvent voir que les employés de leur entreprise
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $employee->user->company_id;
            }
            
            // Les managers ne peuvent voir que les employés de leur département ou leurs subordonnés
            if ($user->hasRole('manager')) {
                return $user->employee && (
                    ($user->employee->department_id === $employee->department_id) ||
                    ($employee->manager_id === $user->employee->id)
                );
            }
            
            // Les employés ne peuvent voir que leur propre profil
            if ($user->hasRole('employee') && !$user->hasAnyRole(['admin', 'company_admin', 'manager'])) {
                return $user->employee && $user->employee->id === $employee->id;
            }
            
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create employees');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Employee $employee): bool
    {
        if ($user->hasPermissionTo('update employees')) {
            // Les admins d'entreprise ne peuvent mettre à jour que les employés de leur entreprise
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $employee->user->company_id;
            }
            
            // Les managers ne peuvent mettre à jour que leurs subordonnés
            if ($user->hasRole('manager')) {
                return $user->employee && $employee->manager_id === $user->employee->id;
            }
            
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Employee $employee): bool
    {
        if ($user->hasPermissionTo('delete employees')) {
            // Les admins d'entreprise ne peuvent supprimer que les employés de leur entreprise
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $employee->user->company_id;
            }
            
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Employee $employee): bool
    {
        return $user->hasAnyRole(['admin', 'company_admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Employee $employee): bool
    {
        return $user->hasRole('admin');
    }
}