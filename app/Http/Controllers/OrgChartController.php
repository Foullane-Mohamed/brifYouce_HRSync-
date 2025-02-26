<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class OrgChartController extends Controller
{
    public function index()
    {
        $departments = Department::with(['employees' => function ($query) {
            $query->whereNull('manager_id');
            $query->with(['subordinates' => function ($q) {
                $q->with('subordinates');
            }]);
        }])->get();
        
        return view('org-chart.index', compact('departments'));
    }
}