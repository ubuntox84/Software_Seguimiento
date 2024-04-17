<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPetition extends Model
{
    use HasFactory;
    protected $table = 'user_petitions';
    protected $fillable = [
        'courses', 
        'articles',
        'state_petition',
        'code_petition',
        'processing_date',
        'processing_status',
        'observations',
        'voucher_imagen_path',
        'petition_imagen_path',
        'record_pdf_path',
        'user_petition_id',
        'user_processor_id',
        'petition_id',
        'subject',
        'excel_record',
        'backup',
        'agreement_number',
    ];

    protected $casts = [
        //   'created_at'=>'date:Y-m-d',
        'processing_date' => 'date:Y-m-d',
        'courses'=>'json',
        'articles'=>'json',
        'backup'=>'json',
        'excel_record'=>'json',
    ];
  
    public function user_petition()
    {
        return $this->hasOne(User::class, 'id', 'user_petition_id');
    }

    public function user_processor()
    {
        return $this->hasOne(User::class, 'id', 'user_processor_id');
    }

    public function petition()
    {
        return $this->hasOne(Petition::class, 'id', 'petition_id');
    }
   
}
