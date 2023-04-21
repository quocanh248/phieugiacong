<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lsquetmodel extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'lsquetmodel';
    protected $fillable = [
        'id',
        'tenmodel',
        'stt',      
        'maline',
        'lot',
        
    ];
}
