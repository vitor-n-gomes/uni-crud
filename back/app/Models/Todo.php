<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['id', 'owner_id', 'in_charge_id', 'description', 'done'];

    /**
     * Get the employee that owns the task.
     */
    public function owner()
    {
        return $this->belongsTo(Employee::class, 'owner_id', 'id');
    }

    /**
     * Get the employee that is in charge for the task.
     */
    public function inCharge()
    {
        return $this->belongsTo(Employee::class, 'in_charge_id', 'id');
    }
    
}
