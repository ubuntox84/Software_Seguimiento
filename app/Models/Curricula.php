<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curricula extends Model
{
    use HasFactory;
    protected $guarded = [];
   //  protected $fillable = [
    
   //     'name',
   //     'resolution',
   //     'state',
   //     'date_approved',
   //     'date_active',
   //     'date_inactive',
   //  ];
    protected $casts = [ 
      'date_approved'=>'date:Y-m-d',
      'date_active'=>'date:Y-m-d',
      'date_inactive'=>'date:Y-m-d',
   ];

      public function getStateColorsAttribute(){

         return [
            0=>'red',
            1=>'green',
         ][$this->state] ??'gray';

      }

      // public function getDateApprovedForHumansAttribute(){
      //    return $this->date_approved->format('M, d Y');
      // }
      // public function getDateActiveForHumansAttribute(){
      //    return $this->date_active->format('M, d Y');
      // }

      // public function getDateInactiveForHumansAttribute(){
      //    return $this->date_inactive->format('M, d Y');
      // }

      
      // public function getDateApprovedEditingAttribute(){
      //    return $this->date_approved->format('m/d/Y');
      // }
      // public function getDateActiveEditingAttribute(){
      //    return $this->date_active->format('m/d/Y');
      // }
      // public function getDateInactiveEditingAttribute(){
      //    return $this->date_inactive->format('m/d/Y');
      // }


      // public function setDateApprovedEditingAttribute($value){
      //     $this->date_approved=Carbon::parse($value);
      // }
      // public function setDateActiveEditingAttribute($value){
      //     $this->date_active=Carbon::parse($value);
      // }
      // public function setDateInactiveEditingAttribute($value){
      //     $this->date_inactive=Carbon::parse($value);
      // }

    public function areasKnowledge(){
        return $this->hasMany(AreaKnowledge::class,'curricula_id','id');
     }
     public function courses(){
        return $this->hasMany(Course::class,'curricula_id','id');
     } 
     /**
      * Get the user that owns the Curricula
      *
      * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
      */
     public function faculties()
     {
         return $this->belongsTo(Faculty::class, 'faculty_id', 'id');
     }
   //   protected function dateApproved(): Attribute
   //  {
   //      return Attribute::make(
   //          get: fn ($value) =>Carbon::parse($value)->format('Y-m-d'),
   //          set: fn ($value) => strtolower($value),
   //      );
   //  }
  public function departments()
     {
         return $this->belongsTo(Department::class, 'department_id', 'id');
     }
}
