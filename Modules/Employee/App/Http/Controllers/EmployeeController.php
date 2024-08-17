<?php

namespace Modules\Employee\App\Http\Controllers;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Employee\App\Http\Requests\StoreEmployeeRequest;
use Modules\Employee\App\Http\Requests\UpdateEmployeeRequest;
use Modules\Employee\Repositories\EmployeeRepositoryInterface;


class EmployeeController extends Controller {
    protected $employeeRepo;

    public function __construct(EmployeeRepositoryInterface $employeeRepo) {
        $this->employeeRepo = $employeeRepo;
    }
    public function index() {
       $employees= $this->employeeRepo->getAllEmployees();
        return view('employee::index',compact($employees));
    }
    public function store(StoreEmployeeRequest $request) {
        try {
            $this->employeeRepo->createEmployee($request->validated());
            return redirect()->route('employees.list')->with('status', 'Employee added successfully!');
        } catch (\Exception $e) {
      
            return redirect()->back()->withErrors(['error' => 'Unable to add employee.']);
        }
    }

    public function edit(UpdateEmployeeRequest $request, $id) {
        try {
            $employee = $this->employeeRepo->getEmployeeById($id);
            if (!$employee) {
                return redirect()->route('employees.list')->withErrors(['error' => 'Employee not found.']);
            }
            $this->employeeRepo->updateEmployee($id, $request->validated());
            return redirect()->route('employees.list')->with('status', 'Employee updated successfully!');
        } catch (\Exception $e) {
    
            return redirect()->back()->withErrors(['error' => 'Unable to update employee.']);
        }
    }

    public function show($id) {
        try {
            $employee = $this->employeeRepo->getEmployeeById($id);
            if (!$employee) {
                return redirect()->route('employees.list')->withErrors(['error' => 'Employee not found.']);
            }
            return view('employees.show', compact('employee'));
        } catch (\Exception $e) {
       
            return redirect()->route('employees.list')->withErrors(['error' => 'Unable to fetch employee details.']);
        }
    }

    public function delete($id) {
        try {
            $employee = $this->employeeRepo->getEmployeeById($id);
            if (!$employee) {
                return redirect()->route('employees.list')->withErrors(['error' => 'Employee not found.']);
            }
            $this->employeeRepo->deleteEmployee($id);
            return redirect()->route('employees.list')->with('status', 'Employee deleted successfully!');
        } catch (\Exception $e) {
     
            return redirect()->route('employees.list')->withErrors(['error' => 'Unable to delete employee.']);
        }
    }

    // public function search(Request $request) {
    //     try {
    //         $query = $request->input('query');
    //         $employees = $this->employeeRepo->searchEmployee($query);
    //         return view('employees.list', compact('employees'));
    //     } catch (\Exception $e) {
        
    //         return redirect()->route('employees.list')->withErrors(['error' => 'Unable to search employees.']);
    //     }
    // }
}