<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['user_id', 'occupation', 'status'];

    /**
     * Get the user that owns the employee.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    /**
     * Get the my tasks
     */
    public function task()
    {
        return $this->hasMany(Todo::class, 'owner_id', 'id');
    }

     /**
     * Get the todo
     */
    public function todo()
    {
        return $this->hasMany(Todo::class, 'in_charge_id', 'id');
    }
}
