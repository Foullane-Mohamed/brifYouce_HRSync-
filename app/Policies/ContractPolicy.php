<?php

namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view contracts');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contract $contract): bool
    {
        if ($user->hasPermissionTo('view contracts')) {
            // Les admins d'entreprise ne peuvent voir que les contrats de leur entreprise
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $contract->employee->user->company_id;
            }
            
            // Les managers ne peuvent voir que les contrats de leurs subordonnés
            if ($user->hasRole('manager')) {
                return $user->employee && $contract->employee->manager_id === $user->employee->id;
            }
            
            // Les employés ne peuvent voir que leurs propres contrats
            if ($user->hasRole('employee') && !$user->hasAnyRole(['admin', 'company_admin', 'manager'])) {
                return $user->employee && $user->employee->id === $contract->employee_id;
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
        return $user->hasPermissionTo('create contracts');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contract $contract): bool
    {
        if ($user->hasPermissionTo('update contracts')) {
            // Les admins d'entreprise ne peuvent mettre à jour que les contrats de leur entreprise
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $contract->employee->user->company_id;
            }
            
            // Les managers ne peuvent mettre à jour que les contrats de leurs subordonnés
            if ($user->hasRole('manager')) {
                return $user->employee && $contract->employee->manager_id === $user->employee->id;
            }
            
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contract $contract): bool
    {
        if ($user->hasPermissionTo('delete contracts')) {
            // Les admins d'entreprise ne peuvent supprimer que les contrats de leur entreprise
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $contract->employee->user->company_id;
            }
            
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contract $contract): bool
    {
        return $user->hasAnyRole(['admin', 'company_admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contract $contract): bool
    {
        return $user->hasRole('admin');
    }
}