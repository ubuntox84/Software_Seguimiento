<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];
   /**
    * Get the faculties that owns the Department
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function faculties()
   {
       return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
   }
    /**
     * Get all of the users for the Department
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'department_id', 'id');
    }
}
