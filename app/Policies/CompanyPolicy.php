<?php
namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view companies');
    }

    public function view(User $user, Company $company)
    {
        if ($user->hasPermissionTo('view companies')) {
            // Company admins can only view their own company
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $company->id;
            }
            
            return true;
        }
        
        return false;
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create companies');
    }

    public function update(User $user, Company $company)
    {
        if ($user->hasPermissionTo('update companies')) {
            // Company admins can only update their own company
            if ($user->hasRole('company_admin')) {
                return $user->company_id === $company->id;
            }
            
            return true;
        }
        
        return false;
    }

    public function delete(User $user, Company $company)
    {
        // Only admins can delete companies, not company admins
        return $user->hasPermissionTo('delete companies') && $user->hasRole('admin');
    }
}