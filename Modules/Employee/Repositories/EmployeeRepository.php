<?php

namespace Modules\Employee\Repositories;


use Modules\Employee\App\Models\Employee;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getAllEmployees()
    {
        return Employee::all();
    }

    public function getEmployeeById($id)
    {
        return Employee::find($id);
    }

    public function createEmployee(array $data)
    {
        return Employee::create($data);
    }

    public function updateEmployee($id, array $data)
    {
        return Employee::where('id', $id)->update($data);
    }

    public function deleteEmployee($id)
    {
        return Employee::destroy($id);
    }
}
