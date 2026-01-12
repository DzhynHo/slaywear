<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory; // <- to jest kluczowe dla factory

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
