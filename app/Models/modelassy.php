<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modelassy extends Model
{
    use HasFactory;
    protected $primaryKey = 'maassy';
    protected $table = 'assy';
    protected $fillable = [
        'maassy',
        'tenassy',        
    ];
}
