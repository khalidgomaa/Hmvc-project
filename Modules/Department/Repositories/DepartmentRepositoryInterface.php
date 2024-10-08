<?php

namespace Modules\Department\Repositories;

interface DepartmentRepositoryInterface
{
    public function getAllDepartments();

    public function getDepartmentById($id);

    public function createDepartment(array $data);

    public function updateDepartment($id, array $data);

    public function deleteDepartment($id);
}
