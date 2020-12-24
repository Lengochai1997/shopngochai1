<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Social;
use App\User;
use Illuminate\Http\Request;
use Socialite;
use Auth;

class SocialController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function redirectToProvider()
    {
//        return Socialite::driver('facebook')->redirect();

        $config = getConfig(config('setting.LOGIN_FACEBOOK'));
        if (!$config) {
            return redirect(asset('/'));
        }
        $url = $config['url'];
        return redirect($url);
    }

    public function handleProviderCallback(Request $request)
    {
        // login with Socialite
//        $key = '8a73d35c3db3c405cdb0bce26a6d9404';
//        $user = Socialite::driver('facebook')->user();
//        $provider_id = $user->id;
//        $name = $user->name;
//        $email = $user->email;
//        $password = $provider_id.$key;

        // login with redirect
        $provider_id = $request->input('fbid');
        $email = $request->input('email');
        $name = $request->input('name');
        $key = $request->input('key'); // 8a73d35c3db3c405cdb0bce26a6d9404
        $password = $provider_id.$key;

        $user = $this->user->where('provider_id', $provider_id)->where('provider', 'facebook')->get();
        if (count($user) > 0) {
            if (Auth::attempt(['username' => $provider_id, 'password' => $password], true)) {
                return redirect(asset(''));
            } else {
                return redirect(asset('login'));
            }
        } else {
            $user = $this->user->create([
                'name' => $name,
                'email' => $email,
                'username' => $provider_id,
                'provider_id' => $provider_id,
                'provider' => 'facebook',
                'password' => bcrypt($password),
            ]);
            Auth::login($user);
            return redirect(asset(''));
        }
    }
}
