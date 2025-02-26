<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            CompanySeeder::class,
            DepartmentSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            ContractSeeder::class,
            TrainingSeeder::class,
            CareerDevelopmentSeeder::class,
        ]);
    }
}