<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded;

    public function times()
    {
        return $this->hasMany(Time::class);
    }

//    public function users()
//    {
//        return $this->belongsToMany(User::class);
//    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
