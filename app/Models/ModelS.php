<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelS extends Model
{
    use HasFactory;
    protected $primaryKey = 'mamodel';
    protected $table = 'model';
    protected $fillable = [
        'mamodel',
        'tenmodel',
        'userid',
        
    ];
    public function versions()
    {
        return $this->hasMany(Version::class, 'mamodel');
    }
}
