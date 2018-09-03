<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id';

    protected $table = 'admin';

    public $timestamps = false;

    protected $redirectTo = 'admin/index';

    protected $fillable = [
        'name', 'password',    //你要验证的字段
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
