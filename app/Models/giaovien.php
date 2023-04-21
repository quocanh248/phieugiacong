<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class giaovien extends Model
{
    use HasFactory;
    protected $primaryKey = 'idgiaovien';
    protected $table = 'giaovien';
    protected $fillable = [
        'idgiaovien',
        'tengiaovien',
        'idnhomhocphan',
    ];
    public function nhomhocphan()
    {
        return $this->belongsTo(nhomhocphan::class, 'idnhomhocphan');
    }
}

