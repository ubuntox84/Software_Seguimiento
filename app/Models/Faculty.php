<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;
    
    protected $guarded = [];
   /**
    * Get all of the curriculas for the Faculty
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function curriculas()
   {
       return $this->hasMany(Curricula::class, 'faculty_id', 'id');
   }
 
  public function departments()
  {
      return $this->hasMany(Department::class, 'faculty_id', 'id');
  }
 public function users()
  {
      return $this->hasMany(User::class, 'faculty_id', 'id');
  }
}
