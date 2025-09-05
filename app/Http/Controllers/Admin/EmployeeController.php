<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        // Fetch all employees
         $employees = Employee::paginate(15);

        return view('admin.employees.index', compact('employees'));
    }
}
