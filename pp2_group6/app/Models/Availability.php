<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    protected $primaryKey = 'avId';

    public $timestamps = false;
    protected $dateFormat = 'H:i:s';
    protected $primaryKey = 'avId';
    public function users () {

        return $this->belongsTo(User::class);
    }
    protected $fillable = ['avId','user_id','date','time','status'];

}
