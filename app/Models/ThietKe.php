<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThietKe extends Model
{
    use HasFactory;
    protected $primaryKey = 'mathietke';
    protected $table = 'thietke';
    protected $fillable = [
        'mathietke',
        'tenthietke',
        'idmau',
        'maversion',
        'assy',
        
    ];
    public function version()
    {
        return $this->belongsTo(Version::class, 'maversion');
    }
    
}
