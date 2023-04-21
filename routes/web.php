<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GiaoVienController;
use App\Http\Controllers\controllermodel;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\assycontroller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', [logincontroller::class, 'login'])->name('login');
Route::get('/dangxuat', [logincontroller::class, 'dangxuat']);
Route::post('/dangnhap', [logincontroller::class, 'dangnhap']);
Route::get('/laythongtinversion/{tenmodel}', [controllermodel::class, 'laythongtinversion']);
Route::get('/laythongtinthietke/{tenmodel}/{tenversion}', [controllermodel::class, 'laythongtinthietke']);
Route::get('/checkmodel/{tenmodel}', [GiaoVienController::class, 'checkmodel']);
Route::get('/themlsquet/{tenmodel}/{tenversion}/{tenthietke}/{stt}/{maline}/{lot}', [controllermodel::class, 'themlsquet']);
Route::get('/laythongtin/{mamodel}', [controllermodel::class, 'laythongtin']);
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [GiaoVienController::class, 'quetqr']);
Route::get('/quetqrassy', [assycontroller::class, 'quetqrassy']);
Route::middleware('auth')->group(function () {
Route::get('/pc', [GiaoVienController::class, 'pc']);
Route::post('/them', [GiaoVienController::class, 'them']);
Route::post('/themmodel', [GiaoVienController::class, 'themmodel']);
Route::get('/quetqr', [GiaoVienController::class, 'quetqr']);

Route::get('/viewthemmodelecxel', [controllermodel::class, 'viewthemmodelecxel']);
Route::get('/viewthemmodel', [controllermodel::class, 'viewthemmodel']);
Route::get('/dsmodel', [controllermodel::class, 'dsmodel']);
Route::post('/docexcel', [controllermodel::class, 'docexcel']);
Route::post('/themmodelexcel', [controllermodel::class, 'themmodelexcel']);
Route::GET('/nhapmodeltay', [controllermodel::class, 'nhapmodeltay']);
Route::GET('/timmodel', [controllermodel::class, 'timmodel']);
Route::post('/nangcap', [controllermodel::class, 'nangcap']);
Route::GET('/nangcapver', [controllermodel::class, 'nangcapver']);
Route::GET('/copymodel', [controllermodel::class, 'copymodel']);

Route::get('/xoamodel/{i}', [controllermodel::class, 'xoamodel']);
Route::get('/xoathietke/{mathietke}', [controllermodel::class, 'xoathietke']);

Route::get('/capnhatmodel/{mamodel}/{maversion}/{mathietke}', [controllermodel::class, 'capnhatmodel']);
Route::GET('/capnhatthietke', [controllermodel::class, 'capnhatthietke']);
Route::get('/xemlsquet', [controllermodel::class, 'xemlsquet']);
Route::get('/timlsquet', [controllermodel::class, 'timlsquet']);
Route::get('/mauexcelmodel', [controllermodel::class, 'mauexcelmodel']);

// Quét phiếu gia công có ASSY


Route::get('/themassybangtay', [assycontroller::class, 'themassybangtay']);
Route::get('/dsassy', [assycontroller::class, 'dsassy']);

Route::post('/nhapassytay', [assycontroller::class, 'nhapassytay']);
Route::GET('/timassy', [assycontroller::class, 'timassy']);

Route::get('/viewthemassyecxel', [assycontroller::class, 'viewthemassyecxel']);

Route::post('/docexcelassy', [assycontroller::class, 'docexcelassy']);
Route::post('/themassyexcel', [assycontroller::class, 'themassyexcel']);
Route::GET('/copymodelassy', [assycontroller::class, 'copymodelassy']);
Route::GET('/nangcapverassy', [assycontroller::class, 'nangcapverassy']);
Route::get('/capnhatmodelassy/{mamodel}/{maversion}/{mathietke}', [assycontroller::class, 'capnhatmodelassy']);
Route::GET('/capnhatassy', [assycontroller::class, 'capnhatassy']);

Route::get('/xemlsquetassy', [assycontroller::class, 'xemlsquetassy']);
Route::get('/timlsquetassy', [assycontroller::class, 'timlsquetassy']);
Route::get('/mauexcelassy', [assycontroller::class, 'mauexcelassy']);
});
Route::get('/checkassy/{tenmodel}/{tenversion}', [assycontroller::class, 'checkassy']);
Route::get('/checkmauassy/{tenmodel}/{tenversion}/{assy}', [assycontroller::class, 'checkmauassy']);
Route::get('/laythongtinassy/{tenmodel}/{tenversion}', [assycontroller::class, 'laythongtinassy']);
Route::get('/laythongtinthietke/{tenmodel}/{tenversion}/{assy}', [assycontroller::class, 'laythongtinthietke']);
Route::get('/getverassy/{mamodel}', [assycontroller::class, 'getverassy']);
Route::get('/themlsquetassy/{tenmodel}/{tenversion}/{tenthietke}/{stt}/{maline}/{lot}/{assy}', [assycontroller::class, 'themlsquetassy']);
Route::get('/layassy/{tenmodel}/{tenversion}', [assycontroller::class, 'layassy']);