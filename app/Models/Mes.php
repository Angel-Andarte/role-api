<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    protected $table = 'meses';
    protected $fillable = ['name', 'num_mes', 'status_id'];
}
