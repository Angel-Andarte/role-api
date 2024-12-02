<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColegioUser extends Model
{
    protected $table = 'colegio_users';

    protected $fillable = [
        'user_id',
        'colegio_id',
        'email',
        'status_id',
    ];
}
