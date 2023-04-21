<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lsquetassy extends Model
{
    use HasFactory;
    use HasFactory;
    protected $primaryKey = 'id';
    protected $table = 'lsquetassy';
    protected $fillable = [
        'id',
        'tenmodel',
        'tenversion',
        'tenthietke',
        'assy',
        'stt',      
        'maline',
        'lot',
        
    ];
}
