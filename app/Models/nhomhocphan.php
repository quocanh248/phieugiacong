<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nhomhocphan extends Model
{
    use HasFactory;
    protected $primaryKey = 'idnhomhocphan';
    protected $table = 'nhomhocphan';
    protected $fillable = [
        'idnhomhocphan',
        'tennhomhocphan',
        
    ];
}
