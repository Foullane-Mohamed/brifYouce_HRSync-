<?php

namespace App\Policies;

use App\Models\CareerDevelopment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CareerDevelopmentPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view career developments');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CareerDevelopment $careerDevelopment): bool
    {
        if ($user->hasPermissionTo('view career developments')) {
            // Les admins d'entreprise ne peuvent voir que les développements de carrière de leur entreprise
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $careerDevelopment->employee->user->company_id;
            }
            
            // Les managers ne peuvent voir que les développements de carrière de leurs subordonnés
            if ($user->hasRole('manager')) {
                return $user->employee && $careerDevelopment->employee->manager_id === $user->employee->id;
            }
            
            // Les employés ne peuvent voir que leurs propres développements de carrière
            if ($user->hasRole('employee') && !$user->hasAnyRole(['admin', 'company_admin', 'manager'])) {
                return $user->employee && $user->employee->id === $careerDevelopment->employee_id;
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
        return $user->hasPermissionTo('create career developments');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CareerDevelopment $careerDevelopment): bool
    {
        if ($user->hasPermissionTo('update career developments')) {
            // Les admins d'entreprise ne peuvent mettre à jour que les développements de carrière de leur entreprise
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $careerDevelopment->employee->user->company_id;
            }
            
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CareerDevelopment $careerDevelopment): bool
    {
        if ($user->hasPermissionTo('delete career developments')) {
            // Les admins d'entreprise ne peuvent supprimer que les développements de carrière de leur entreprise
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $careerDevelopment->employee->user->company_id;
            }
            
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CareerDevelopment $careerDevelopment): bool
    {
        return $user->hasAnyRole(['admin', 'company_admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CareerDevelopment $careerDevelopment): bool
    {
        return $user->hasRole('admin');
    }
}