<?php

namespace App\Http\Controllers;

use App\Models\giaovien;
use App\Models\hocphan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\ModelS;
use App\Models\ThietKe;
use App\Models\Version;
use Illuminate\Support\Facades\Session;

class GiaoVienController  extends Controller
{

    public function pc()
    {
        $hp = hocphan::get();
        $gv = new hocphan;

        return view('phancong', [
            'hp' => $hp,
            'gv' => $gv,
        ]);
    }
    public function quetqr()
    {
        $results = DB::table('model')
            ->join('version', 'model.mamodel', '=', 'version.mamodel')
            ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
            ->join('maus', 'maus.id', '=', 'thietke.idmau')
            ->select('model.tenmodel', 'version.tenversion', 'thietke.tenthietke', 'maus.tenmau', 'mamau')           
            ->where('model.tenmodel', '=', '81801FL451')
            ->get();

        $storedValues = [];

        // Lặp qua các kết quả và thêm vào mảng storedValues
        foreach ($results as $result) {
            $storedValues[] = [
                'Model' => $result->tenmodel,
                'version' => $result->tenversion,
                'designnumber' => $result->tenthietke,
                'color' => $result->mamau
            ];
        }


        return view('quetmaqr2', [

            'results' => $results
        ]);
    }
    public function checkmodel($tenmodel)
    {

        $results = DB::table('model')
            ->join('version', 'model.mamodel', '=', 'version.mamodel')
            ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
            ->join('maus', 'maus.id', '=', 'thietke.idmau')
            ->select('model.tenmodel', 'version.tenversion', 'thietke.tenthietke', 'maus.tenmau', 'mamau')
            ->where('model.tenmodel', '=', $tenmodel)
            ->get();

        $storedValues = [];

        // Lặp qua các kết quả và thêm vào mảng storedValues
        foreach ($results as $result) {
            $storedValues[] = [
                'Model' => $result->tenmodel,
                'version' => $result->tenversion,
                'designnumber' => $result->tenthietke,
                'color' => $result->mamau
            ];
        }

        return response()->json($results);
    }
    public function themmodel(Request $r)
    {
        $tenmodel = $r->input('input1');
        $tenversion = $r->input('input2');
        $tenthietke = $r->input('input3');
        $mau = $r->input('mau');

        $thietke = new ThietKe;
        $model = ModelS::where('tenmodel', $tenmodel)->first();
        if ($model) {
            // Model đã tồn tại trong cơ sở dữ liệu

        } else {
            // Thêm mới model vào cơ sở dữ liệu
            $model = new ModelS();
            $model->tenmodel = $tenmodel;
            $model->save();
        }
        $result = DB::table('version')
            ->crossJoin('model')
            ->select('model.mamodel')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('tenmodel', '=', $tenmodel)
            ->where('tenversion', '=',  $tenversion)
            ->get();
        if ($result->isEmpty()) {
            // Không có dữ liệu
            $version = new Version();
            $version->tenversion = $tenversion;
            $version->mamodel = ModelS::where('tenmodel', $tenmodel)->value('mamodel');
            $version->save();
        } else {
            // Có dữ liệu
        }
        $resulttk = DB::table('version')
            ->crossJoin('model')
            ->select('maversion')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('tenmodel', '=', $tenmodel)
            ->where('tenversion', '=',  $tenversion)
            ->first();

        if ($resulttk) {
            // Thêm mới model vào cơ sở dữ liệu
            $thietke = new ThietKe();
            $thietke->tenthietke = $tenthietke;
            $thietke->mau = $mau;
            $thietke->maversion = $resulttk->maversion;
            // Lưu thay đổi
            $thietke->save();
        } else {
            // Xử lý khi không tìm thấy kết quả
        }
    }
    public function them(Request $r)
    {
        $subjects = $r->input('subjects');

        foreach ($subjects as $subjectId) {

            $gv = $r->input('teachers.' . $subjectId);

            DB::table('gvhp')->insert([
                'idgv' => $gv,
                'idhp' => $subjectId,

            ]);
        }
    }
    public function timmamodel($tenmodel)
    {
        $mamodel = ModelS::where('tenmodel', $tenmodel)->value('mamodel');
        return $mamodel;
    }
}
