<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['assign_by', 'assign_to', 'title', 'description', 'deadline', 'file', 'status_id'];

    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function assignTo(){
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }

    public function assignBy(){
        return $this->belongsTo(User::class, 'assign_by', 'id');
    }
}
