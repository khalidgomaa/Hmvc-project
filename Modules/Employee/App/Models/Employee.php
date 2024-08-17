<?php

namespace Modules\Employee\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\App\Models\User;
use Modules\Employee\Database\factories\EmployeeFactory;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['user_id','first_name', 'last_name', 'salary', 'image', 'manager_name'];

    
    protected static function newFactory()
    {
        //return EmployeeFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
