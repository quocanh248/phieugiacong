<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Version extends Model
{
    use HasFactory;
    protected $primaryKey = 'maversion';
    protected $table = 'version';
    protected $fillable = [
        'maversion',
        'tenversion',
        'mamodel',
        'created_at',
    ];
    public function model()
    {
        return $this->belongsTo(ModelS::class, 'mamodel');
    }

    public function thietkes()
    {
        return $this->hasMany(ThietKe::class, 'maversion');
    }
    public function getversion($mamodel)
    {
        $version = DB::table('version')
            ->crossJoin('model')            
            ->select('tenversion')
            ->where('version.mamodel', '=', DB::raw('model.mamodel'))           
            ->where('version.mamodel', '=', $mamodel)
            ->get();



        return $version;
    }
}
