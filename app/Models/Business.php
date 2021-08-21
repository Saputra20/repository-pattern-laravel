<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = "stores";
    protected $fillable = ['account_id', 'avatar', 'name', 'npwp', 'website', 'phone', 'address', 'social_media'];
}
