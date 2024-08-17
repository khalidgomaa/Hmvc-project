<?php

namespace Modules\Department\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Department\App\Http\Requests\StoreDepartmentRequest;
use Modules\Department\App\Http\Requests\updateDepartmentRequest;
use Modules\Department\Repositories\DepartmentRepositoryInterface;
use Modules\Employee\Repositories\EmployeeRepositoryInterface;

class DepartmentController extends Controller
{
    protected $departmentRepo;
    protected $employeeRepo;

    public function __construct(DepartmentRepositoryInterface $departmentRepo, EmployeeRepositoryInterface $employeeRepo) {
        $this->departmentRepo = $departmentRepo;
        $this->employeeRepo = $employeeRepo;
    }
    public function index()
    {
        $managers = $this->employeeRepo->getAllEmployees();
        $departments = $this->departmentRepo->getAllDepartment();
        return view('department::index', compact('departments', 'managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $managers = $this->employeeRepo->getAllEmployees();
        return view('department::create',compact( 'managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
   
        public function store(StoreDepartmentRequest $request)
        {
            try {
                $validatedData = $request->validated();
        
                $this->departmentRepo->createDepartment($validatedData);   
                session()->flash('success', 'Department created successfully.');
        
                return redirect()->route('department.index');
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to create the department. Please try again.');
        
                return redirect()->route('department.index');
            }
        }
        
    
    
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('department::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $managers = $this->employeeRepo->getAllEmployees();
        $department = $this->departmentRepo->getDepartmentById($id);
  
        return view('department::edit', compact('department', 'managers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateDepartmentRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
    
            $updateResult = $this->departmentRepo->updateDepartment($id, $validatedData);
    
            if ($updateResult) {
                session()->flash('success', 'Department updated successfully.');
                return redirect()->route('department.index');
            } else {
                session()->flash('error', 'Failed to update the department. Please try again.');
                return redirect()->route('department.index');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update the department. Please try again.');
            return redirect()->route('department.index');
        }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $this->departmentRepo->deleteDepartment($id);
            
            session()->flash('success', 'Department deleted successfully.');
            return redirect()->route('departments.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete the department. Please try again.');
    

            return redirect()->route('departments.index');
        }
    }
}
