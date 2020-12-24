<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function getLogin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect(asset('admin'));
        }
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {

        try {
            $params = $request->all();
            $username = $params['username'];
            $password = $params['password'];
            if (Auth::guard('admin')->attempt(['username' => $username, 'password' => $password])) {
                return redirect(asset('admin'));
            } else {
                return redirect(asset('admin/login'))->with('error', trans('admin::message.login.error'));
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function getLogout()
    {
        Auth::guard('admin')->logout();
        return redirect(asset('admin'));
    }
}
