<?php

namespace Modules\Department\Repositories;



use Modules\Department\App\Models\Department;
use Modules\Employee\Repositories\EmployeeRepositoryInterface;

class DepartmentRepository implements DepartmentRepositoryInterface
{



    public function __construct() {

    }
    public function getAllDepartments()
    {

        return Department::with('manager')->paginate(10);
    }

    public function getDepartmentById($id)
    {
        return Department::find($id);
    }

    public function createDepartment(array $data)
    {
        return Department::create($data);
    }

    public function updateDepartment($id, array $data)
    {
        return Department::where('id', $id)->update($data);
    }

    public function deleteDepartment($id)
    {
        return Department::destroy($id);
    }
}
