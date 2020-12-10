<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;


    public function students(){

        return $this->belongsTo(Student::class);
    }

    public function users(){

        return $this->belongsTo(Student::class);
    }



    protected $fillable = ['student_id','user_id','date','startsAt','subject','status','cancelToken','hasRight'];

}
