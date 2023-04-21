<?php

namespace App\Http\Controllers;

use App\Models\Lsquetmodel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\ModelS;
use App\Models\ThietKe;
use App\Models\Version;
use App\Models\Mau;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Carbon\Carbon;
use App\Exports\lsquetExport;
use App\Exports\maumodelexport;

class controllermodel extends Controller
{
    public function viewthemmodel()
    {
        $mau = Mau::get();
        $model = ModelS::get();
        return view('quanlymodel', [
            'mau' => $mau,
            'model' => $model
        ]);
    }
    public function viewthemmodelecxel()
    {
        $mau = Mau::get();
        $model = ModelS::get();
        return view('nhapmodelexcel', [
            'mau' => $mau,
            'model' => $model
        ]);
    }
    public function docexcel(Request $request)
    {
        $results1 = [];
        $file = $request->file('excel_file');
        $results = Excel::toArray([], $file);
        if (!empty($results)) {
            foreach ($results as $row) {
                $results1[] = $row;
            }
        }
        $mau = Mau::get();
        return view('nhapmodelexcel', [
            'results' => $results1,
            'mau' => $mau
        ]);
    }
    public function dsmodel()
    {

        // $models = ModelS::with('versions.thietkes.mau')->get();
        $models = DB::table('version')
            ->crossJoin('model')
            ->crossJoin('thietke')
            ->crossJoin('maus')
            ->crossJoin('users')
            ->select('tenversion',  'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'thietke.updated_at')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('model.userid', '=', DB::raw('users.id'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('maus.id', '=', DB::raw('thietke.idmau'))
            ->paginate(10);
        $model = DB::table('version')
            ->crossJoin('model')
            ->crossJoin('thietke')
            ->crossJoin('maus')
            ->crossJoin('users')
            ->distinct()
            ->select('tenmodel')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('model.userid', '=', DB::raw('users.id'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('maus.id', '=', DB::raw('thietke.idmau'))
            ->where('assy', '=', "")
            ->get();

        return view('dsmodel', [
            'model' => $models,
            't' => $model,
        ]);
    }
    public function laythongtin($mamodel)
    {
        // $version = Version::where('mamodel', $mamodel)->get();
        // $version = DB::table('version')
        //     ->crossJoin('model')
        //     ->select('maversion', 'tenversion')
        //     ->where('model.mamodel', '=', DB::raw('version.mamodel'))
        //     ->where('tenmodel', '=', $mamodel)
        //     ->get();
        $version = DB::table('version')
            ->crossJoin('model')
            ->select('maversion', 'tenversion')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('tenmodel', '=', $mamodel)
            ->orderByDesc('tenversion')
            ->get();
        return response()->json($version);
    }
    public function laythongtinversion($tenmodel)
    {
        $version = DB::table('version')
            ->crossJoin('model')
            ->select('maversion', 'tenversion')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('tenmodel', '=', $tenmodel)
            ->get();

        return response()->json($version);
    }
    public function laythongtinthietke($tenmodel, $tenversion)
    {
        $thietke = DB::table('version')
            ->crossJoin('model')
            ->crossJoin('thietke')
            ->select('tenthietke')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('tenmodel', '=', $tenmodel)
            ->where('tenversion', '=', $tenversion)
            ->get();

        return response()->json($thietke);
    }
    public function timmodel(Request $r)
    {

        $mamodel = $r->input('model');
        $maversion = $r->input('version');
        if ($r->input('tim')) {
            // $models = ModelS::with('versions.thietkes.mau')->get();
            $models = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->select('tenversion', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('model.tenmodel', '=', $mamodel)
                ->where('version.maversion', '=', $maversion)
                ->orderBy('tenthietke')
                ->get();
            $version = DB::table('version')
                ->crossJoin('model')
                ->select('tenversion', 'maversion',)
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.tenmodel', '=', $mamodel)
                ->where('version.maversion', '<>', $maversion)
                ->get();
            $model = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->distinct()
                ->select('tenmodel')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('assy', '=', "")
                ->get();
            if ($models->count() > 0) {
                return view('ketquatimmodel', [
                    'model' => $models,
                    't' => $model,
                    'version' => $version,
                ]);
            }
            return view('dsmodel', [
                't' => $model,
                'version' => $version,
            ]);
        } elseif ($r->input('nangcap')) {
            $version = DB::table('version')
                ->crossJoin('thietke')
                ->crossJoin('model')
                ->crossJoin('maus')
                ->select('*')
                ->where('thietke.idmau', '=', DB::raw('maus.id'))
                ->where('version.maversion', '=', DB::raw('thietke.maversion'))
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('version.maversion', '=', $maversion)
                ->get();
            $model = DB::table('version')
                ->crossJoin('model')
                ->select('*')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.tenmodel', '=', $mamodel)
                ->get();
            return view('nangcapversion', [
                'version' => $version,
                'model' => $model
            ]);
        } else {
            $model = DB::table('version')
                ->crossJoin('thietke')
                ->crossJoin('model')
                ->crossJoin('maus')
                ->select('*')
                ->where('thietke.idmau', '=', DB::raw('maus.id'))
                ->where('version.maversion', '=', DB::raw('thietke.maversion'))
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.tenmodel', '=', $mamodel)
                ->where('version.maversion', '=', $maversion)
                ->get();
            $models = ModelS::get();
            return view('copymodel', [
                'model' => $model,
                'models' => $models
            ]);
        }
    }
    public function nangcap(Request $r)
    {
        if ($r->input('nangcap')) {
            $version = DB::table('version')
                ->crossJoin('thietke')
                ->crossJoin('model')
                ->crossJoin('maus')
                ->select('*')
                ->where('thietke.idmau', '=', DB::raw('maus.id'))
                ->where('version.maversion', '=', DB::raw('thietke.maversion'))
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('version.maversion', '=', $r->input('nangcap'))
                ->get();
            $model = DB::table('version')
                ->crossJoin('model')
                ->select('*')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.tenmodel', '=', $r->input('copy'))
                ->get();
            return view('nangcapversion', [
                'version' => $version,
                'model' => $model
            ]);
        } else {
            $model = DB::table('version')
                ->crossJoin('thietke')
                ->crossJoin('model')
                ->crossJoin('maus')
                ->select('*')
                ->where('thietke.idmau', '=', DB::raw('maus.id'))
                ->where('version.maversion', '=', DB::raw('thietke.maversion'))
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.tenmodel', '=', $r->input('copy'))
                ->where('version.maversion', '=', $r->input('maversion'))
                ->get();
            $models = ModelS::get();
            return view('copymodel', [
                'model' => $model,
                'models' => $models
            ]);
        }
    }
    public function nangcapver(Request $r)
    {
        $mamodel = $r->input('nangcap123');
        $tenversion = $r->input('version');
        $tenthietke = $r->input('col3');
        $tenmau = $r->input('col4');
        $thietke = new ThietKe;
        $version = new Version();
        $mau = new Mau();
        $thietke_data = array();
        $userid = Session::get('userid');
        $dt = Carbon::now();
        $dt->setTimezone('Asia/Ho_Chi_Minh');
        $result = DB::table('version')
            ->crossJoin('model')
            ->select('model.mamodel')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('model.mamodel', '=', $mamodel)
            ->where('tenversion', '=',  $tenversion)
            ->get();
        if ($result->isEmpty()) {
            // Không có dữ liệu

            $version->tenversion = $tenversion;
            $version->mamodel = $mamodel;
            $version->save();

            //nhập mảng            


        } else {
            // Có dữ liệu
        }
        for ($i = 0; $i < count($tenthietke); $i++) {

            $resulttk12 = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->select('thietke.mathietke')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('model.mamodel', '=', $mamodel)
                ->where('tenversion', '=',  $tenversion)
                ->where('tenthietke', '=',  $tenthietke[$i])
                ->get();

            if ($resulttk12->isEmpty()) {

                $resultmau = DB::table('maus')
                    ->select('id')
                    ->where('tenmau', '=', $tenmau[$i])
                    ->first();

                $resulttk = DB::table('version')
                    ->crossJoin('model')
                    ->select('maversion')
                    ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                    ->where('model.mamodel', '=', $mamodel)
                    ->where('tenversion', '=',  $tenversion)
                    ->first();
                if ($resulttk && $resultmau) {
                    // Thêm mới model vào cơ sở dữ liệu

                    $thietke_row = array(
                        'assy' => "",
                        'tenthietke' => $tenthietke[$i],
                        'idmau' => $resultmau->id,
                        'maversion' => $resulttk->maversion,
                        'updated_at' => $dt
                    );
                    if (!in_array($thietke_data, $thietke_row)) {
                        array_push($thietke_data, $thietke_row);
                    }
                } else {
                    // Xử lý khi không tìm thấy kết quả
                }
            } else {
                Alert::warning('Lỗi', 'Đã có version này');
                return redirect('dsmodel');
            }
        }
        Alert::success('Thành công', 'Nâng cấp hoàn tất');
        ThietKe::insert($thietke_data);
        $models = DB::table('version')
            ->crossJoin('model')
            ->crossJoin('thietke')
            ->crossJoin('maus')
            ->crossJoin('users')
            ->select('tenversion', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('model.userid', '=', DB::raw('users.id'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('maus.id', '=', DB::raw('thietke.idmau'))
            ->where('model.mamodel', '=', $mamodel)
            ->where('version.tenversion', '=', $tenversion)
            ->orderBy('tenthietke')
            ->get();
        $version = DB::table('version')
            ->crossJoin('model')
            ->select('tenversion', 'maversion',)
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('model.mamodel', '=', $mamodel)
            ->get();

        $model = DB::table('version')
            ->crossJoin('model')
            ->crossJoin('thietke')
            ->crossJoin('maus')
            ->crossJoin('users')
            ->distinct()
            ->select('tenmodel')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('model.userid', '=', DB::raw('users.id'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('maus.id', '=', DB::raw('thietke.idmau'))
            ->where('assy', '=', "")
            ->get();
        if ($models->count() > 0) {
            return view('retuenkq', [
                'model' => $models,
                't' => $model,
                'version' => $version,
            ]);
        }
        return view('dsmodel', [
            't' => $model,
            'version' => $version,
        ]);
    }
    public function copymodel(Request $r)
    {
        $mamodel = $r->input('nangcap');
        $tenmodel = $r->input('model');
        $tenversion = $r->input('tenversion');
        $tenthietke = $r->input('col3');
        $tenmau = $r->input('col4');
        $dt = Carbon::now();
        $dt->setTimezone('Asia/Ho_Chi_Minh');
        if (strlen($tenmodel) >= 10 && strlen($tenmodel) <= 11) {
            $thietke = new ThietKe;
            $version = new Version();
            $thietke_data = array();
            $version_data = array();
            $userid = Session::get('userid');
            $model = ModelS::where('tenmodel', $tenmodel)->first();
            if ($model) {
                // Model đã tồn tại trong cơ sở dữ liệu

            } else {
                $tmodel = new ModelS();
                $tmodel->tenmodel = $tenmodel;
                $tmodel->userid = $userid;
                $tmodel->save();
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
                $tversion = new Version();
                $tversion->tenversion = $tenversion;
                $tversion->mamodel = ModelS::where('tenmodel', $tenmodel)->value('mamodel');
                $tversion->save();
            } else {
                Alert::warning('Lỗi', 'Đã có version này');
                return redirect('dsmodel');
            }
            for ($i = 0; $i < count($tenthietke); $i++) {
                $resulttk12 = DB::table('version')
                    ->crossJoin('model')
                    ->crossJoin('thietke')
                    ->select('thietke.mathietke')
                    ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                    ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                    ->where('tenmodel', '=', $tenmodel)
                    ->where('tenversion', '=',  $tenversion)
                    ->where('tenthietke', '=',  $tenthietke[$i])
                    ->get();

                if (count($resulttk12) > 0) {
                } else {
                    $resultmau = DB::table('maus')
                        ->select('id')
                        ->where('tenmau', '=', $tenmau[$i])
                        ->first();

                    $resulttk = DB::table('version')
                        ->crossJoin('model')
                        ->select('maversion')
                        ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                        ->where('tenmodel', '=', $tenmodel)
                        ->where('tenversion', '=',  $tenversion)
                        ->first();

                    if ($resulttk && $resultmau) {
                        // Thêm mới model vào cơ sở dữ liệu

                        $thietke_row = array(
                            'assy' => "",
                            'tenthietke' => $tenthietke[$i],
                            'maversion' => $resulttk->maversion,
                            'idmau' => $resultmau->id,
                            'updated_at' => $dt
                        );
                        if (!in_array($thietke_data, $thietke_row)) {
                            array_push($thietke_data, $thietke_row);
                        }
                    } else {
                        // Xử lý khi không tìm thấy kết quả
                    }
                }
            }
            ThietKe::insert($thietke_data);
            Alert::success('Thành công', 'Copy cấp hoàn tất');
            $models = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->select('tenversion', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('model.tenmodel', '=', $tenmodel)
                ->where('version.tenversion', '=', $tenversion)
                ->orderBy('tenthietke')
                ->get();

            $version = DB::table('version')
                ->crossJoin('model')
                ->select('tenversion', 'maversion',)
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.tenmodel', '=', $tenmodel)
                ->where('version.tenversion', '<>', $tenversion)
                ->get();

            $model = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->distinct()
                ->select('tenmodel')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('assy', '=', "")
                ->get();
            if ($models->count() > 0) {
                return view('retuenkq', [
                    'model' => $models,
                    't' => $model,
                    'version' => $version,
                ]);
            }
            return view('dsmodel', [
                't' => $model,
                'version' => $version,
            ]);
        } else {
            Alert::warning('Lỗi', 'Tên Model không hợp lệ');
            $models = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->select('tenversion', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('model.mamodel', '=', $mamodel)
                ->where('version.tenversion', '=', $tenversion)
                ->orderBy('tenthietke')
                ->get();

            $version = DB::table('version')
                ->crossJoin('model')
                ->select('tenversion', 'maversion',)
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.mamodel', '=', $mamodel)
                ->where('version.tenversion', '<>', $tenversion)
                ->get();
            $model = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->distinct()
                ->select('tenmodel')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('assy', '=', "")
                ->get();
            if ($models->count() > 0) {
                return view('retuenkq', [
                    'model' => $models,
                    't' => $model,
                    'version' => $version,
                ]);
            }
            return view('dsmodel', [
                't' => $model,
                'version' => $version,
            ]);
        }
    }
    public function nhapmodeltay(Request $request)
    {
        $tenmodel = $request->input('model');
        $tenversion = $request->input('version');
        $tenthietke = $request->input('thietke12');
        $mamau = $request->input('mau');
        $idmau = Mau::where('mamau', $mamau)->value('id');
        $dt = Carbon::now();
        $dt->setTimezone('Asia/Ho_Chi_Minh');
        $model = ModelS::where('tenmodel', $tenmodel)->first();
        if ($model) {
            // Model đã tồn tại trong cơ sở dữ liệu

        } else {
            // Thêm mới model vào cơ sở dữ liệu
            $userid = Session::get('userid');
            $model = new ModelS();
            $model->tenmodel = $tenmodel;
            $model->userid = $userid;
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
        $resulttk12 = DB::table('version')
            ->crossJoin('model')
            ->crossJoin('thietke')
            ->select('thietke.mathietke')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('tenmodel', '=', $tenmodel)
            ->where('tenversion', '=',  $tenversion)
            ->where('tenthietke', '=',  $tenthietke)
            ->get();
            
        if (count($resulttk12) > 0) {
            // Alert::warning('Lỗi', 'Đã có bản thiết kế này');
            return redirect()->back()->with('errol', 'Đã có  thiết kế này');
        } else {
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
                $thietke->assy = "";
                $thietke->tenthietke = $tenthietke;
                $thietke->idmau = $idmau;
                $thietke->maversion = $resulttk->maversion;
                $thietke->updated_at  = $dt;
                // Lưu thay đổi
                $thietke->save();
                $modelsds = DB::table('version')
                    ->crossJoin('model')
                    ->crossJoin('thietke')
                    ->crossJoin('maus')
                    ->crossJoin('users')
                    ->select('tenversion', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.created_at')
                    ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                    ->where('model.userid', '=', DB::raw('users.id'))
                    ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                    ->where('maus.id', '=', DB::raw('thietke.idmau'))
                    ->orderByDesc('thietke.created_at')
                    ->limit(5)
                    ->get();
                Session::put('datanew', $modelsds);

                // Alert::success('Thành công', 'Thêm model mới hoàn tất');

                return redirect()->back()->with('success', 'Thao tác thành công!');
            } else {
            }
        }
    }

    public function themmodelexcel(Request $request)
    {
        // Lưu trữ các giá trị dữ liệu vào cơ sở dữ liệu
        $tenmodel = $request->input('col1');
        $tenversion = $request->input('col2');
        $tenthietke = $request->input('col3');
        $tenmau = $request->input('col4');
        $thietke = new ThietKe;
        $version = new Version();
        $mau = new Mau();
        $thietke_data = array();
        $model_data = array();
        $version_data = array();
        $userid = Session::get('userid');
        $dt = Carbon::now();
        $dt->setTimezone('Asia/Ho_Chi_Minh');
        for ($i = 0; $i < count($tenmodel); $i++) {
            $model = ModelS::where('tenmodel', $tenmodel[$i])->first();
            if ($model) {
                // Model đã tồn tại trong cơ sở dữ liệu

            } else {
                $model_row = array(
                    'tenmodel' => $tenmodel[$i],
                    'userid' => $userid,
                );
                if (!in_array($model_row, $model_data)) {
                    array_push($model_data, $model_row);
                }
            }
        }
        ModelS::insert($model_data);
        for ($i = 0; $i < count($tenmodel); $i++) {
            $result = DB::table('version')
                ->crossJoin('model')
                ->select('model.mamodel')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('tenmodel', '=', $tenmodel[$i])
                ->where('tenversion', '=',  $tenversion[$i])
                ->get();
            if ($result->isEmpty()) {                // Không có dữ liệu

                $version_row = array(
                    'tenversion' => $tenversion[$i],
                    'mamodel' => ModelS::where('tenmodel', $tenmodel[$i])->value('mamodel'),
                );
                if (!in_array($version_row, $version_data)) {
                    array_push($version_data, $version_row);
                }
            } else {
                // Có dữ liệu
            }
        }
        Version::insert($version_data);
        for ($i = 0; $i < count($tenmodel); $i++) {

            $tentk = substr($tenthietke[$i], 0, 4);
            $resulttk12 = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->select('thietke.mathietke')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('tenmodel', '=', $tenmodel[$i])
                ->where('tenversion', '=',  $tenversion[$i])
                ->where('tenthietke', '=',  $tentk)
                ->get();

            if (count($resulttk12) > 0) {
            } else {
                $resultmau = DB::table('maus')
                    ->select('id')
                    ->where('tenmau', '=', $tenmau[$i])
                    ->first();

                $resulttk = DB::table('version')
                    ->crossJoin('model')
                    ->select('maversion')
                    ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                    ->where('tenmodel', '=', $tenmodel[$i])
                    ->where('tenversion', '=',  $tenversion[$i])
                    ->first();

                if ($resulttk && $resultmau) {
                    // Thêm mới model vào cơ sở dữ liệu

                    $thietke_row = array(
                        'assy' => "",
                        'tenthietke' => $tentk,
                        'maversion' => $resulttk->maversion,
                        'idmau' => $resultmau->id,
                        'updated_at' => $dt
                    );
                    if (!in_array($thietke_data, $thietke_row)) {
                        array_push($thietke_data, $thietke_row);
                    }
                } else {
                    // Xử lý khi không tìm thấy kết quả
                }
            }
        }
        ThietKe::insert($thietke_data);
        Alert::success('Thành công', 'Nhập excel vào CSDL hoàn tất');
        return redirect('dsmodel');
    }
    public function capnhatmodel($mamodel, $maversion, $mathietke)
    {
        $models = ModelS::where('mamodel', '<>', $mamodel)->get();
        $versions = Version::where('maversion', '<>', $maversion)
            ->where('mamodel', '=', $mamodel)
            ->get();
        $thietkes = ThietKe::where('mathietke', '<>', $mathietke)->get();
        $thietke = ThietKe::join('version', 'version.maversion', '=', 'thietke.maversion')
            ->join('model', 'version.mamodel', '=', 'model.mamodel')
            ->where('version.maversion', $maversion)
            ->where('model.mamodel', $mamodel)
            ->where('thietke.mathietke', $mathietke)
            ->select('thietke.*', 'version.tenversion')
            ->first();
        $maus = Mau::where('id', '<>', $thietke->idmau)->get();
        $mau = Mau::where('id', '=', $thietke->idmau)->first();

        $model = ModelS::where('mamodel', $mamodel)->first();
        $version = Version::join('model', 'version.mamodel', '=', 'model.mamodel')
            ->where('version.maversion', $maversion)
            ->select('version.*', 'model.tenmodel')
            ->first();

        return view('capnhatmodel', [
            'model' => $model,
            'version' => $version,
            'thietke' => $thietke,
            'models' => $models,
            'versions' => $versions,
            'thietkes' => $thietkes,
            'maus' => $maus,
            'mau' => $mau
        ]);
    }
    public function  capnhatthietke(Request $r)
    {
        // $mamodel = $r->input('model');
        $maversion = $r->input('version');
        $tenthietke = $r->input('thietke');
        $mamodel = $r->input('model');
        $dt = Carbon::now();
        $dt->setTimezone('Asia/Ho_Chi_Minh');
        if ($r->input('capnhat')) {
            $mathietke = $r->input('capnhat');
            $maus = $r->input('mau');
            $mau = Mau::where('mamau', '=', $maus)->first();
            // dd($mathietke, $maversion, $tenthietke, $mau->id);
            // $models = ModelS::with('versions.thietkes.mau')->get();
            DB::table('thietke')
                ->where('mathietke', $mathietke)
                ->update(
                    [
                        'maversion' => $maversion,
                        'tenthietke' => $tenthietke,
                        'idmau' => $mau->id,
                        'updated_at' => $dt
                    ]
                );
            Alert::success('Thành công', 'cập nhật hoàn tất');
            $models = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->select('tenversion', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('model.mamodel', '=', $mamodel)
                ->where('version.maversion', '=', $maversion)
                ->orderBy('tenthietke')
                ->get();

            $version = DB::table('version')
                ->crossJoin('model')
                ->select('tenversion', 'maversion',)
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.tenmodel', '=', $mamodel)
                ->where('version.maversion', '<>', $maversion)
                ->get();
            $model = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->distinct()
                ->select('tenmodel')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('assy', '=', "")
                ->get();
            if ($models->count() > 0) {
                return view('ketquatimmodel', [
                    'model' => $models,
                    't' => $model,
                    'version' => $version,
                ]);
            }
            return view('dsmodel', [
                't' => $model,
                'version' => $version,
            ]);
        } else {
            $models = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->select('tenversion', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('model.mamodel', '=', $mamodel)
                ->where('version.maversion', '=', $maversion)
                ->orderBy('tenthietke')
                ->get();

            $version = DB::table('version')
                ->crossJoin('model')
                ->select('tenversion', 'maversion',)
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.tenmodel', '=', $mamodel)
                ->where('version.maversion', '<>', $maversion)
                ->get();
            $model = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->distinct()
                ->select('tenmodel')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('assy', '=', "")
                ->get();
            if ($models->count() > 0) {
                return view('ketquatimmodel', [
                    'model' => $models,
                    't' => $model,
                    'version' => $version,
                ]);
            }
            return view('dsmodel', [
                't' => $model,
                'version' => $version,
            ]);
        }
    }
    public function xoamodel($i)
    {
        DB::table('thietke')->where([
            ['maversion', '=', $i],
        ])->delete();
        DB::table('version')->where([
            ['maversion', '=', $i],
        ])->delete();
        // $model = ModelS::where('mamodel', $i)->firstOrFail();
        // $version = Version::where('mamodel', $i)->get();
        // $maversions = $version->pluck('maversion'); // Lấy các maversions tương ứng trong bảng thietke
        // ThietKe::whereIn('maversion', $maversions)->delete();
        // $model->versions()->delete();
        // $model->delete();
        Alert::success('Thành công', 'Xóa Ver  hoàn tất');
        return redirect('dsmodel');
    }
    public function xoathietke($mathietke)
    {
        DB::table('thietke')->where([
            ['mathietke', '=', $mathietke],
        ])->delete();
        Alert::success('Thành công', 'Xóa số thiết kế hoàn tất');
        return redirect()->back();
    }
    public function themlsquet($tenmodel, $tenversion, $tenthietke, $stt, $maline, $lot)
    {
        $dt = Carbon::now();
        $dt->setTimezone('Asia/Ho_Chi_Minh');
        $ngay = $dt->format('Y-m-d');
        $lsquet = Lsquetmodel::where('tenmodel', $tenmodel)
            ->where('tenversion', $tenversion)
            ->where('tenthietke', $tenthietke)
            ->where('maline', $maline)
            ->where('lot', $lot)
            ->where('stt', $stt)
            ->whereDate('updated_at', $ngay)
            ->first();
        if ($lsquet) {
            // Model đã tồn tại trong cơ sở dữ liệu

        } else {
            // Thêm mới model vào cơ sở dữ liệu
            $lsq = new Lsquetmodel();
            $lsq->tenmodel = $tenmodel;
            $lsq->stt = $stt;
            $lsq->tenversion = $tenversion;
            $lsq->tenthietke = $tenthietke;
            $lsq->maline = $maline;
            $lsq->lot = $lot;
            $lsq->save();
        }
    }
    public function xemlsquet()
    {
        $dt = Carbon::now();
        $dt->setTimezone('Asia/Ho_Chi_Minh');
        $ngay = $dt->format('Y-m-d');
        $lsquet = Lsquetmodel::orderBy('updated_at', 'desc')
            ->orderBy('tenmodel', 'asc')
            ->orderBy('tenthietke', 'desc')
            ->get();
        return view('xemlsquet', [
            'date' => $ngay,
            'lsquet' => $lsquet,
        ]);
    }
    public function timlsquet(Request $r)
    {
        $date =  $r->input('date');
        $lsquet = Lsquetmodel::whereDate('updated_at', $r->input('date'))
            ->orderBy('updated_at')
            ->orderBy('tenthietke', 'desc')
            ->get();
        if ($r->input('tim')) {

            return view('xemlsquet', [
                'date' => $date,
                'lsquet' => $lsquet,
            ]);
        } else {

            return Excel::download(new LsquetExport($date), 'lsquetngay' . $date . '.xlsx');
        }
    }
    public function mauexcelmodel()
    {

        return Excel::download(new maumodelexport(), 'filemauassy.xlsx');
    }
}
