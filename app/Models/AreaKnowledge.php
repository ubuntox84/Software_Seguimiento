<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaKnowledge extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'total_credits',
        'curricula_id'
     ];

     public function courses(){
      return $this->hasMany(Course::class,'area_knowledge_id','id');
     }
     public function curriculas(){
      return $this->belongsTo(Curricula::class,'curricula_id','id');
     }
}
