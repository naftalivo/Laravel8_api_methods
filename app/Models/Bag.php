<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['number', 'brand', 'people_id'];

    public $table = "bags";

    protected $primaryKey = 'id';

    public function person(){
        return $this->hasOne(Person::class, 'id', 'people_id ');
    }
}
