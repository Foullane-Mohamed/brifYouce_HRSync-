<?php
namespace Database\Seeders;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        $contractTypes = ['CDI', 'CDD', 'Internship', 'Freelance'];
        
        foreach ($employees as $employee) {
            // Determine contract type based on position
            $contractType = $this->determineContractType($employee->position);
            
            // Create contract
            $startDate = $employee->hire_date;
            $endDate = null;
            
            // For temporary contracts, set an end date
            if ($contractType === 'CDD') {
                $endDate = (clone $startDate)->addYears(1);
            } elseif ($contractType === 'Internship') {
                $endDate = (clone $startDate)->addMonths(6);
            } elseif ($contractType === 'Freelance') {
                $endDate = (clone $startDate)->addMonths(rand(1, 12));
            }
            
            Contract::create([
                'employee_id' => $employee->id,
                'type' => $contractType,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'details' => $this->generateContractDetails($contractType, $employee->position),
            ]);
        }
    }
    
    private function determineContractType($position)
    {
        // Managers and senior positions usually get permanent contracts
        if (str_contains($position, 'Manager') || str_contains($position, 'Senior') || str_contains($position, 'Director')) {
            return 'CDI';
        }
        
        // Interns get internship contracts
        if (str_contains($position, 'Intern')) {
            return 'Internship';
        }
        
        // Specialists might be freelancers
        if (str_contains($position, 'Specialist') && rand(0, 10) > 7) {
            return 'Freelance';
        }
        
        // Assign random contract type with weighted probability
        $rand = rand(1, 10);
        if ($rand <= 6) {
            return 'CDI'; // 60% chance of permanent contract
        } elseif ($rand <= 9) {
            return 'CDD'; // 30% chance of fixed-term contract
        } else {
            return rand(0, 1) ? 'Internship' : 'Freelance'; // 10% chance of internship or freelance
        }
    }
    
    private function generateContractDetails($contractType, $position)
    {
        $details = "Contract for the position of $position. ";
        
        switch ($contractType) {
            case 'CDI':
                $details .= "Permanent contract with a 3-month probation period. Standard company benefits apply, including health insurance, retirement plan, and paid time off.";
                break;
            case 'CDD':
                $details .= "Fixed-term contract for one year with possibility of renewal or conversion to permanent status based on performance and company needs. Limited benefits apply.";
                break;
            case 'Internship':
                $details .= "Six-month internship with focus on professional development and training. Performance reviews at 3 and 6 months with possibility of permanent position upon successful completion.";
                break;
            case 'Freelance':
                $details .= "Project-based contract with defined deliverables and timelines. Contractor responsible for own taxes and insurance. No employee benefits included.";
                break;
        }
        
        return $details;
    }
}
