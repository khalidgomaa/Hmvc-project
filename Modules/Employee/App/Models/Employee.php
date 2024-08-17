<?php

namespace Modules\Employee\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\App\Models\User;
use Modules\Department\App\Models\Department;
use Modules\Employee\Database\factories\EmployeeFactory;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id','first_name', 'last_name', 'salary', 'image', 'manager_id','department_id'];


    
    protected static function newFactory()
    {
        //return EmployeeFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function manger()
    {
        return $this->belongsTo(Employee::class, 'manager_id'); 
    }
}

