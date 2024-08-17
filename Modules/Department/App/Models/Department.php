<?php

namespace Modules\Department\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Department\Database\factories\DepartmentFactory;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['name', 'manager_id'];

    
    protected static function newFactory()
    {
        //return DepartmentFactory::new();
    }
    public function manager()
    {
        return $this->belongsTo('Modules\Employee\App\Models\Employee', 'manager_id');
    }
}
