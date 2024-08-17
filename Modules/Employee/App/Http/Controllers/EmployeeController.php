<?php

namespace Modules\Employee\App\Http\Controllers;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Auth\Repositories\User\UserRepositoryInterface;
use Modules\Department\Repositories\DepartmentRepositoryInterface;
use Modules\Employee\App\Http\Requests\StoreEmployeeRequest;
use Modules\Employee\App\Http\Requests\UpdateEmployeeRequest;
use Modules\Employee\Repositories\EmployeeRepositoryInterface;


class EmployeeController extends Controller {

    protected $employeeRepo;
    protected $departmentRepo;
    protected $userRepo;

    public function __construct(EmployeeRepositoryInterface $employeeRepo,
    DepartmentRepositoryInterface $departmentRepo,
    UserRepositoryInterface $userRepo) {


        $this->userRepo = $userRepo;
        $this->employeeRepo = $employeeRepo;
        $this->departmentRepo = $departmentRepo;
    }
    public function index() {
        $employees= $this->employeeRepo->getAllEmployees();
        return view('employee::index',compact('employees'));
    }




    public function create() {
        $users = $this->userRepo->getAllUsers();
        $employees = $this->employeeRepo->getAllEmployees();
        $departments = $this->departmentRepo->getAllDepartments();
        return view('employee::create', compact('users', 'employees', 'departments'));
    }



    public function store(StoreEmployeeRequest $request)
    {
        try {
            // Create employee and get the instance
            $employee = $this->employeeRepo->createEmployee($request->validated());
    
            // Handle image if provided
            if (!empty($request->image_id)) {
                $this->handleImage($request->image_id, $employee);
            }
    
            return redirect()->route('employee::index')->with('status', 'Employee added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Unable to add employee.']);
        }
    }
    



    public function edit($id)
    {
        $employees = $this->employeeRepo->getAllEmployees();
        $users= $this->userRepo->getAllUsers();
        $departments = $this->departmentRepo->getDepartmentById($id);



        $employee = $this->employeeRepo->getEmployeeById($id);
        return view('employee::edit', compact('employee','departments', 'users','employees'));
    }



    public function update(UpdateEmployeeRequest $request, $id) {
        try {
      
            $users= $this->userRepo->getAllUsers();
            $employees= $this->employeeRepo->getAllEmployees();
          
            $users= $this->departmentRepo->getAllDepartment();

            $validatedData = $request->validated();

            $employee = $this->employeeRepo->updateEmployee($id, $validatedData);
        
            if (!$employee) {
                return redirect()->route('employee::index')->withErrors(['error' => 'Employee not found.']);
            }
            if (!empty($request->image_id)) {
                $this->handleImage($request->image_id, $employee);
            }
            $this->employeeRepo->editEmployee($id);
            return redirect()->route('employee::create');
        } catch (\Exception $e) {
    
            return redirect()->back()->withErrors(['error' => 'Unable to update employee.']);
        }
    }

 
    

    public function delete($id) {
        try {
            $employee = $this->employeeRepo->getEmployeeById($id);

            if (!$employee) {
                return redirect()->route('employee::index')->withErrors(['error' => 'Employee not found.']);
            }
            $this->employeeRepo->deleteEmployee($id);
            return redirect()->route('employee::index')->with('status', 'Employee deleted successfully!');
      
      
        } catch (\Exception $e) {
     
            return redirect()->route('employee::index')->withErrors(['error' => 'Unable to delete employee.']);
        }
    }



    protected function handleImage($imageId, $employee)
{
    $tempImage = TempImage::find($imageId);

    if ($tempImage) {
        $exArray = explode('.', $tempImage->name);
        $ext = last($exArray);

        $newImageName = $employee->id . '.' . $ext;
        $spath = public_path('temp_images/' . $tempImage->name);
        $dpath = public_path('uploads/employee/' . $newImageName);

        if (File::exists($spath)) {
            File::copy($spath, $dpath);

            // Update employee image path and save
            $employee->image = $newImageName;
            $employee->save();
        } else {
            throw new \Exception('Source image not found.');
        }
    } else {
        throw new \Exception('Temporary image not found.');
    }
}
}