<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function topic() {
        return $this->belongsTo(Topic::class);
    }

    public function formData() {
        return $this->hasMany(FormData::class);
    }
}
