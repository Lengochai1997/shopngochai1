<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Payment;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    private $user;
    private $payment;
    private $wallet;

    public function __construct(User $user, Payment $payment, Wallet $wallet)
    {
        $this->user = $user;
        $this->payment = $payment;
        $this->wallet = $wallet;
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect(asset(''));
        }
        return view('user.login');
    }

    public function doLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        if (Auth::attempt(['username' => $username, 'password' => $password], true)) {
            return response()->json([
                'message' => 'Đăng nhập thành công.',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Tài khoản hoặc mật khẩu không chính xác.',
                'status' => 'success'
            ], 500);
        }
    }

    public function register()
    {
        if (Auth::check()) {
            return redirect(asset(''));
        }
        return view('user.register');
    }

    public function checkEmail(Request $request)
    {
        if (!$request->has('email')) {
            return "false";
        }
        $email = $request->input('email');
        $count = $this->user->where('email', $email)->count();
        if ($count === 0) {
            return "true";
        } else {
            return "false";
        }
    }

    public function checkUsername(Request $request)
    {
        if (!$request->has('username')) {
            return "false";
        }
        $username = $request->input('username');
        $count = $this->user->where('username', $username)->count();
        if ($count === 0) {
            return "true";
        } else {
            return "false";
        }
    }

    public function doRegister(Request $request) {
        $user = $this->user->create([
            'name' => preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $request->input('name')),
            'username' => preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $request->input('username')),
            'email' => preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $request->input('email')),
            'tel' => '',
            'password' => bcrypt($request->input('password')),
        ]);
        if ($user) {
            return response()->json([
                'message' => 'Đăng ký thành công',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Đăng ký không thành công',
                'status' => 'failed'
            ], 500);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(asset(''));
    }

    public function profile()
    {
        $wallet = $this->wallet->where('user_id', Auth::user()->id)->first();
        return view('user.profile', compact('wallet'));
    }

    public function changePassword()
    {
        return view('user.change-password');
    }

    public function doChangePassword(Request $request)
    {
        $oldPassword = $request->has('old_password') ? $request->input('old_password') : '';
        $password = $request->has('password') ? $request->input('password') : '';
        $passwordConfirmation = $request->has('password_confirmation') ? $request->input('password_confirmation') : '';
        if ($oldPassword === '' || $password == '' || $passwordConfirmation == '') {
            return response()->json([
                'message' => 'Chưa nhập đủ thông, xin thử lại.',
                'status' => 'error'
            ], 500);
        }
        if ($password !== $passwordConfirmation) {
            return response()->json([
                'message' => 'Mật khẩu nhập lại chưa đúng, xin thử lại.',
                'status' => 'error'
            ], 500);
        }
        $user = $this->user->find(Auth::id());
        if (password_verify($oldPassword, $user->password)) {
            $user->update([
                'password' => bcrypt($password)
            ]);
            return response()->json([
                'message' => 'Đổi mật khẩu thành công.',
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Mật khẩu cũ không chính xác.',
                'status' => 'error'
            ], 500);
        }
    }
}
