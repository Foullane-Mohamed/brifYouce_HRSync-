<?php

namespace App\Policies;

use App\Models\Training;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TrainingPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view trainings');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Training $training): bool
    {
        if ($user->hasPermissionTo('view trainings')) {
            // Les admins d'entreprise ne peuvent voir que les formations concernant leur entreprise
            if ($user->hasRole('company_admin')) {
                return $training->employees->contains(function ($employee) use ($user) {
                    return $employee->user->company_id === $user->company_id;
                });
            }
            
            // Les managers ne peuvent voir que les formations de leurs subordonnés
            if ($user->hasRole('manager')) {
                return $training->employees->contains(function ($employee) use ($user) {
                    return $user->employee && $employee->manager_id === $user->employee->id;
                });
            }
            
            // Les employés ne peuvent voir que les formations auxquelles ils sont inscrits
            if ($user->hasRole('employee') && !$user->hasAnyRole(['admin', 'company_admin', 'manager'])) {
                return $user->employee && $training->employees->contains('id', $user->employee->id);
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
        return $user->hasPermissionTo('create trainings');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Training $training): bool
    {
        if ($user->hasPermissionTo('update trainings')) {
            // Les admins d'entreprise ne peuvent mettre à jour que les formations concernant leur entreprise
            if ($user->hasRole('company_admin')) {
                return $training->employees->contains(function ($employee) use ($user) {
                    return $employee->user->company_id === $user->company_id;
                });
            }
            
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Training $training): bool
    {
        if ($user->hasPermissionTo('delete trainings')) {
            // Les admins d'entreprise ne peuvent supprimer que les formations concernant leur entreprise
            if ($user->hasRole('company_admin')) {
                return $training->employees->contains(function ($employee) use ($user) {
                    return $employee->user->company_id === $user->company_id;
                });
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Training $training): bool
    {
        return $user->hasAnyRole(['admin', 'company_admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Training $training): bool
    {
        return $user->hasRole('admin');
    }
}