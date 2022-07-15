<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'group_id', 'title',
    ];

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}
