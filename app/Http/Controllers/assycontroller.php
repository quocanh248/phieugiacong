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
use App\Models\modelassy;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use Carbon\Carbon;
use App\Exports\lsquetassyExport;
use App\Exports\mauassyexport;
use App\Models\Lsquetassy;

class assycontroller extends Controller
{
    public function quetqrassy()
    {
        $mau = Mau::orderBy('id', 'asc')->get();
        $assy = modelassy::get();
        return view('assy2', [
            'assy' => $assy,
            'mau' => $mau,
        ]);
    }
    public function checkassy($tenmodel, $tenversion)
    {

        $results = DB::table('model')
            ->join('version', 'model.mamodel', '=', 'version.mamodel')
            ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
            ->join('maus', 'maus.id', '=', 'thietke.idmau')
            ->select('model.tenmodel', 'version.tenversion', 'thietke.tenthietke', 'maus.tenmau', 'mamau', 'assy')
            ->where('model.tenmodel', '=', $tenmodel)
            ->where('version.tenversion', '=', $tenversion)
            ->where('assy', '<>', "")
            ->orderBy('idmau', 'asc')
            ->get();

        return response()->json($results);
    }
    public function layassy($tenmodel, $tenversion)
    {

        $results = DB::table('model')
            ->join('version', 'model.mamodel', '=', 'version.mamodel')
            ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
            ->join('maus', 'maus.id', '=', 'thietke.idmau')
            ->distinct()
            ->select('assy')
            ->where('model.tenmodel', '=', $tenmodel)
            ->where('version.tenversion', '=', $tenversion)
            ->where('assy', '<>', "")
            ->orderBy('assy', 'asc')
            ->get();

        return response()->json($results);
    }
    public function checkmauassy($tenmodel, $tenversion, $assy)
    {

        $results = DB::table('model')
            ->join('version', 'model.mamodel', '=', 'version.mamodel')
            ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
            ->join('maus', 'maus.id', '=', 'thietke.idmau')
            ->select('model.tenmodel', 'version.tenversion', 'thietke.tenthietke', 'maus.tenmau', 'mamau', 'assy')
            ->where('model.tenmodel', '=', $tenmodel)
            ->where('version.tenversion', '=', $tenversion)
            ->where('assy', '=', $assy)
            ->orderBy('idmau', 'asc')
            ->get();

        return response()->json($results);
    }
    public function themassybangtay()
    {
        $mau = Mau::get();
        $model = DB::table('model')
            ->join('version', 'model.mamodel', '=', 'version.mamodel')
            ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
            ->distinct()
            ->select('model.tenmodel', 'model.mamodel')
            ->where('assy', '<>', "")
            ->orderBy('model.mamodel', 'asc')
            ->get();
        return view('themassybangtay', [
            'mau' => $mau,
            'model' => $model
        ]);
    }
    public function dsassy()
    {
        $ver = new Version();
        $model = DB::table('model')
            ->join('version', 'model.mamodel', '=', 'version.mamodel')
            ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
            ->distinct()
            ->select('model.tenmodel', 'model.mamodel')
            ->where('assy', '<>', "")
            ->orderBy('model.mamodel', 'asc')
            ->get();
        return view('dsassy', [
            'model' => $model,
            'ver' => $ver,
        ]);
    }
    public function laythongtinassy($tenmodel, $tenversion)
    {
        $assy = DB::table('version')
            ->crossJoin('model')
            ->crossJoin('thietke')
            ->distinct()
            ->select('assy')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('tenmodel', '=', $tenmodel)
            ->where('tenversion', '=', $tenversion)
            ->where('assy', '<>', "")
            ->get();

        return response()->json($assy);
    }
    public function laythongtinthietke($tenmodel, $tenversion, $assy)
    {
        $thiteke = DB::table('version')
            ->crossJoin('model')
            ->crossJoin('thietke')
            ->select('tenthietke')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('tenmodel', '=', $tenmodel)
            ->where('tenversion', '=', $tenversion)
            ->where('assy', '=', $assy)
            ->get();

        return response()->json($thiteke);
    }
    //Nhập assy tay
    public function nhapassytay(Request $request)
    {
        $tenmodel = $request->input('model');
        $tenversion = $request->input('version');
        $assy = $request->input('assy');
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
            ->where('assy', '=',  $assy)
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
                $thietke->tenthietke = $tenthietke;
                $thietke->idmau = $idmau;
                $thietke->maversion = $resulttk->maversion;
                $thietke->assy = $assy;
                $thietke->updated_at  = $dt;
                // Lưu thay đổi
                $thietke->save();
                $modelsds = DB::table('version')
                    ->crossJoin('model')
                    ->crossJoin('thietke')
                    ->crossJoin('maus')
                    ->crossJoin('users')
                    ->select('tenversion', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'assy', 'thietke.created_at')
                    ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                    ->where('model.userid', '=', DB::raw('users.id'))
                    ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                    ->where('maus.id', '=', DB::raw('thietke.idmau'))
                    ->where('assy', '<>', "")
                    ->orderByDesc('thietke.created_at')
                    ->limit(5)
                    ->get();
                Session::put('dataassynew', $modelsds);

                // Alert::success('Thành công', 'Thêm model mới hoàn tất');

                return redirect()->back()->with('success', 'Thao tác thành công!');
            } else {
            }
        }
    }
    public function timassy(Request $r)
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
                ->select('tenversion', 'assy', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('model.tenmodel', '=', $mamodel)
                ->where('version.maversion', '=', $maversion)
                ->where('assy', '<>', "")
                ->orderBy('assy', 'desc')
                ->orderBy('tenthietke', 'desc')
                ->get();
            $version = DB::table('version')
                ->crossJoin('model')
                ->select('tenversion', 'maversion',)
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.tenmodel', '=', $mamodel)
                ->where('version.maversion', '<>', $maversion)
                ->get();
            $model = DB::table('model')
                ->join('version', 'model.mamodel', '=', 'version.mamodel')
                ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
                ->distinct()
                ->select('model.tenmodel', 'model.mamodel')
                ->where('assy', '<>', "")
                ->orderBy('model.mamodel', 'asc')
                ->get();
            if ($models->count() > 0) {
                return view('ketquatimassy', [
                    'model' => $models,
                    't' => $model,
                    'version' => $version,
                ]);
            }
            return view('dsassy', [
                'model' => $model,
                'ver' => $version,
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
                ->where('assy', '<>', "")
                ->get();
            $model = DB::table('version')                
                ->crossJoin('model')               
                ->select('*')              
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.tenmodel', '=', $mamodel)         
                ->get();
            return view('nangcapversionassy', [
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
                ->where('assy', '<>', "")
                ->get();
            $models = ModelS::get();
            return view('copymodelassy', [
                'model' => $model,
                'models' => $models
            ]);
        }
    }
    public function getverassy($mamodel)
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
            ->crossJoin('thietke')
            ->distinct()
            ->select('version.maversion', 'tenversion')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('tenmodel', '=', $mamodel)
            ->where('assy', '<>', "")
            ->orderByDesc('tenversion')
            ->get();
        return response()->json($version);
    }
    public function viewthemassyecxel()
    {
        $mau = Mau::get();
        $model = DB::table('model')
            ->join('version', 'model.mamodel', '=', 'version.mamodel')
            ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
            ->distinct()
            ->select('model.tenmodel', 'model.mamodel')
            ->where('assy', '<>', "")
            ->orderBy('model.mamodel', 'asc')
            ->get();
        return view('themassybangexcel', [
            'mau' => $mau,
            'model' => $model
        ]);
    }
    public function docexcelassy(Request $request)
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
        return view('themassybangexcel', [
            'results' => $results1,
            'mau' => $mau
        ]);
    }
    public function copymodelassy(Request $r)
    {
        $mamodel = $r->input('nangcap');
        $tenmodel = $r->input('model');
        $tenversion = $r->input('tenversion');
        $assy = $r->input('col2');
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
                return redirect('dsassy');
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
                    ->where('assy', '=',  $assy[$i])
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
                            'assy' => $assy[$i],
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
                ->select('tenversion', 'assy', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('model.tenmodel', '=', $tenmodel)
                ->where('version.tenversion', '=', $tenversion)
                ->orderBy('assy', 'desc')
                ->orderBy('tenthietke', 'desc')
                ->get();

            $version = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->select('tenversion', 'version.maversion',)
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('model.mamodel', '=', $mamodel)
                ->where('version.tenversion', '<>', $tenversion)
                ->where('assy', '<>', "")
                ->get();

            $model = DB::table('model')
                ->join('version', 'model.mamodel', '=', 'version.mamodel')
                ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
                ->distinct()
                ->select('model.tenmodel', 'model.mamodel')
                ->where('assy', '<>', "")
                ->orderBy('model.mamodel', 'asc')
                ->get();
            if ($models->count() > 0) {
                return view('returnkqassy', [
                    'model' => $models,
                    't' => $model,
                    'version' => $version,
                ]);
            }
            return view('dsassy', [
                'model' => $model,
                'ver' => $version,
            ]);
        } else {
            Alert::warning('Lỗi', 'Tên Model không hợp lệ');
            $models = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->crossJoin('maus')
                ->crossJoin('users')
                ->select('tenversion', 'assy', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('model.userid', '=', DB::raw('users.id'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('maus.id', '=', DB::raw('thietke.idmau'))
                ->where('model.mamodel', '=', $mamodel)
                ->where('version.tenversion', '=', $tenversion)
                ->orderBy('assy', 'desc')
                ->orderBy('tenthietke', 'desc')
                ->get();

            $version = DB::table('version')
                ->crossJoin('model')
                ->crossJoin('thietke')
                ->select('tenversion', 'version.maversion',)
                ->where('model.mamodel', '=', DB::raw('version.mamodel'))
                ->where('thietke.maversion', '=', DB::raw('version.maversion'))
                ->where('model.mamodel', '=', $mamodel)
                ->where('version.tenversion', '<>', $tenversion)
                ->where('assy', '<>', "")
                ->get();
            $model = DB::table('model')
                ->join('version', 'model.mamodel', '=', 'version.mamodel')
                ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
                ->distinct()
                ->select('model.tenmodel', 'model.mamodel')
                ->where('assy', '<>', "")
                ->orderBy('model.mamodel', 'asc')
                ->get();
            if ($models->count() > 0) {
                return view('returnkqassy', [
                    'model' => $models,
                    't' => $model,
                    'version' => $version,
                ]);
            }
            return view('dsassy', [
                'model' => $model,
                'ver' => $version,
            ]);
        }
    }
    public function nangcapverassy(Request $r)
    {
        $mamodel = $r->input('nangcap123');
        $tenversion = $r->input('version');
        $assy = $r->input('colassy');

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
            //Alert::warning('Lỗi', 'Đã có version này');
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
                ->where('assy', '=',  $assy[$i])
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
                        'assy' => $assy[$i],
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
                return redirect('dsassy');
            }
        }
        Alert::success('Thành công', 'Nâng cấp hoàn tất');
        ThietKe::insert($thietke_data);
        $models = DB::table('version')
            ->crossJoin('model')
            ->crossJoin('thietke')
            ->crossJoin('maus')
            ->crossJoin('users')
            ->select('tenversion', 'assy', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('model.userid', '=', DB::raw('users.id'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('maus.id', '=', DB::raw('thietke.idmau'))
            ->where('model.mamodel', '=', $mamodel)
            ->where('version.tenversion', '=', $tenversion)
            ->where('assy', '<>', "")
            ->orderBy('assy', 'desc')
            ->orderBy('tenthietke', 'desc')
            ->get();
        $version = DB::table('version')
            ->crossJoin('model')
            ->select('tenversion', 'maversion',)
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('model.mamodel', '=', $mamodel)
            ->get();

        $model = DB::table('model')
            ->join('version', 'model.mamodel', '=', 'version.mamodel')
            ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
            ->distinct()
            ->select('model.tenmodel', 'model.mamodel')
            ->where('assy', '<>', "")
            ->orderBy('model.mamodel', 'asc')
            ->get();
        if ($models->count() > 0) {
            return view('returnkqassy', [
                'model' => $models,
                't' => $model,
                'version' => $version,
            ]);
        }
        return view('dsassy', [
            'model' => $model,
            'ver' => $version,
        ]);
    }
    public function capnhatmodelassy($mamodel, $maversion, $mathietke)
    {
        $models = ModelS::where('mamodel', '<>', $mamodel)->get();
        $versions = Version::where('maversion', '<>', $maversion)
            ->where('mamodel', '=', $mamodel)
            ->get();
        $thietkes = ThietKe::where('mathietke', '<>', $mathietke)
            ->where('assy', '<>', "")->get();
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

        return view('capnhatmodelassy', [
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
    public function  capnhatassy(Request $r)
    {
        // $mamodel = $r->input('model');
        $maversion = $r->input('version');
        $tenthietke = $r->input('thietke');
        $assy = $r->input('assy');
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
                        'assy' => $assy,
                        'maversion' => $maversion,
                        'tenthietke' => $tenthietke,
                        'idmau' => $mau->id,
                        'updated_at' => $dt
                    ]
                );
            Alert::success('Thành công', 'cập nhật hoàn tất');
            $view = "ketquatimassy";
            $d = $this->returnview($view, $mamodel, $maversion);
            return $d;
        } else {
            $view = "ketquatimassy";
            $d = $this->returnview($view, $mamodel, $maversion);
            return $d;
        }
    }
    public function returnview($view, $mamodel, $maversion)
    {
        $models = DB::table('version')
            ->crossJoin('model')
            ->crossJoin('thietke')
            ->crossJoin('maus')
            ->crossJoin('users')
            ->select('tenversion', 'assy', 'thietke.mathietke', 'version.maversion', 'model.mamodel', 'tenmodel', 'tenmau', 'mamau', 'tenthietke', 'name', 'thietke.updated_at')
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('model.userid', '=', DB::raw('users.id'))
            ->where('thietke.maversion', '=', DB::raw('version.maversion'))
            ->where('maus.id', '=', DB::raw('thietke.idmau'))
            ->where('model.mamodel', '=', $mamodel)
            ->where('version.maversion', '=', $maversion)
            ->where('assy', '<>', "")
            ->orderBy('assy', 'desc')
            ->orderBy('tenthietke', 'desc')
            ->get();
        $model = DB::table('model')
            ->join('version', 'model.mamodel', '=', 'version.mamodel')
            ->join('thietke', 'version.maversion', '=', 'thietke.maversion')
            ->distinct()
            ->select('model.tenmodel', 'model.mamodel')
            ->where('assy', '<>', "")
            ->orderBy('model.mamodel', 'asc')
            ->get();
        $version = DB::table('version')
            ->crossJoin('model')
            ->select('tenversion', 'maversion',)
            ->where('model.mamodel', '=', DB::raw('version.mamodel'))
            ->where('model.mamodel', '=', $mamodel)
            ->where('version.maversion', '<>', $maversion)
            ->get();
        return view($view, [
            'model' => $models,
            't' => $model,
            'version' => $version,
        ]);
    }
    public function themassyexcel(Request $request)
    {
        // Lưu trữ các giá trị dữ liệu vào cơ sở dữ liệu
        $tenmodel = $request->input('col1');
        $tenversion = $request->input('col2');
        $assy = $request->input('col3');
        $tenthietke = $request->input('col5');
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

            if (strlen($tentk) == 3) {
                $t = "0";
                $tentk = $t . '' . $tentk;
            }

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
                        'assy' => $assy[$i],
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
        return redirect('dsassy');
    }
    public function themlsquetassy($tenmodel, $tenversion, $tenthietke, $stt, $maline, $lot, $assy)
    {
        $dt = Carbon::now();
        $dt->setTimezone('Asia/Ho_Chi_Minh');
        $ngay = $dt->format('Y-m-d');
        $lsquet = Lsquetassy::where('tenmodel', $tenmodel)
            ->where('tenversion', $tenversion)
            ->where('tenthietke', $tenthietke)
            ->where('maline', $maline)
            ->where('lot', $lot)
            ->where('assy', $assy)
            ->where('stt', $stt)
            ->whereDate('updated_at', $ngay)
            ->first();
        if ($lsquet) {
            // Model đã tồn tại trong cơ sở dữ liệu

        } else {
            // Thêm mới model vào cơ sở dữ liệu
            $lsq = new Lsquetassy();
            $lsq->tenmodel = $tenmodel;
            $lsq->assy = $assy;
            $lsq->stt = $stt;
            $lsq->tenversion = $tenversion;
            $lsq->tenthietke = $tenthietke;
            $lsq->maline = $maline;
            $lsq->lot = $lot;
            $lsq->save();
        }
    }
    public function xemlsquetassy()
    {
        $dt = Carbon::now();
        $dt->setTimezone('Asia/Ho_Chi_Minh');
        $ngay = $dt->format('Y-m-d');
        $lsquet = Lsquetassy::orderBy('updated_at', 'desc')
            ->orderBy('tenmodel', 'asc')
            ->orderBy('assy', 'desc')
            ->orderBy('tenthietke', 'desc')
            ->get();
        return view('xemlsquetassy', [
            'date' => $ngay,
            'lsquet' => $lsquet,
        ]);
    }
    public function timlsquetassy(Request $r)
    {
        $date =  $r->input('date');
        $lsquet = Lsquetassy::whereDate('updated_at', $r->input('date'))
            ->orderBy('updated_at')
            ->orderBy('assy', 'desc')
            ->orderBy('tenthietke', 'desc')
            ->get();
        if ($r->input('tim')) {

            return view('xemlsquet', [
                'date' => $date,
                'lsquet' => $lsquet,
            ]);
        } else {

            return Excel::download(new LsquetassyExport($date), 'lsquetassyngay' . $date . '.xlsx');
        }
    }
    public function mauexcelassy()
    {

        return Excel::download(new mauassyexport(), 'filemaumodel.xlsx');
    }
}
