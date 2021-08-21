<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['account_id', 'avatar', 'first_name', 'last_name', 'place_of_birth', 'date_of_birth', 'gender', 'provice', 'regency'];
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAvatarAttribute($value)
    {
        $account = $this->account()->first();

        if ($value) {
            return $value;
        } else {
            return "https://www.gravatar.com/avatar/" . md5($account->email) . ".jpg";
        }
    }

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }
}
