<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Contract;
use App\Models\CareerDevelopment;
use App\Models\Training;
use App\Policies\CompanyPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\ContractPolicy;
use App\Policies\CareerDevelopmentPolicy;
use App\Policies\TrainingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Company::class => CompanyPolicy::class,
        Department::class => DepartmentPolicy::class,
        Employee::class => EmployeePolicy::class,
        Contract::class => ContractPolicy::class,
        CareerDevelopment::class => CareerDevelopmentPolicy::class,
        Training::class => TrainingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // View salary permission
        Gate::define('view-salary', function ($user) {
            return $user->hasAnyRole(['admin', 'company_admin']) || 
                   ($user->hasRole('manager') && $user->employee->subordinates->contains('id', $user->employee->id));
        });
    }
}
