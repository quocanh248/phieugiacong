<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

class logincontroller extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function dangnhap(Request $r)
    {
        if (Auth::attempt(['manhanvien' => $r->input('manhanvien'), 'password' => $r->input('password')])) {

            $q = Auth::user()->maquyen;
            $userid = Auth::user()->id;
            // $tt = DB::table('users')
            //     ->select('trangthai')
            //     ->where('users.id', '=', $userid)
            //     ->first();      
            Session::put('quyen', $q);
            Session::put('userid', $userid);
            Alert::success('Thành công', 'Đăng nhập hoàn tất');
            return redirect('dsmodel');
        } else {
            Alert::warning('Lỗi', 'Tên đăng nhập hoặc mật khẩu không chính xác!');
            return redirect('login');
        }
        Alert::warning('Lỗi', 'Tên đăng nhập hoặc mật khẩu không chính xác!');
        return redirect('login');
    }
    public function dangxuat()
    {
        Session::forget('datanew');
        Session::forget('dataassynew');
        Session::forget('quyen');
        Session::forget('userid');
        Auth::logout();
        return redirect('/');
    }
}
