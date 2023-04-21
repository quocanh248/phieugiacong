<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mau extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'maus';
    protected $fillable = [
        'id',
        'mamau',
        'tenmau',
    ];
    public function thietkes()
    {
        return $this->hasMany(ThietKe::class, 'id');
    }
}