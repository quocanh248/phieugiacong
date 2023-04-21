<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class hocphan extends Model
{
    use HasFactory;
    protected $primaryKey = 'idhocphan';
    protected $table = 'hoc_phan';
    protected $fillable = [
        'idhocphan',
        'tenhocphan',
        'idnhomhocphan',
    ];
    public function nhomhocphan()
    {
        return $this->belongsTo(nhomhocphan::class, 'idnhomhocphan');
    }
    public function getgv($idnhomhocphan)
    {    
        $gv = DB::table('giaovien')
        ->crossJoin('nhom_hoc_phan')
        ->crossJoin('hoc_phan')
        ->select('idgiaovien', 'tengiaovien')
        ->where('nhom_hoc_phan.idnhomhocphan', '=', DB::raw('hoc_phan.idnhomhocphan'))
        ->where('nhom_hoc_phan.idnhomhocphan', '=', DB::raw('giaovien.idnhomhocphan'))
        ->where('idhocphan', '=', $idnhomhocphan)
        ->get();
        
        
      
       return $gv;
    }
}
