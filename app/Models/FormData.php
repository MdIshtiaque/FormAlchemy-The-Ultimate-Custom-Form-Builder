<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function form() {
        return $this->belongsTo(Form::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
