<?php

namespace App\Http\Controllers\Setting;

use App\Alert;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Services\AmazonS3Service;
use App\Services\UploadFile;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $setting;
    private $alert;
    private $s3Service;

    public function __construct(Setting $setting, Alert $alert, AmazonS3Service $s3Service)
    {
        $this->setting = $setting;
        $this->alert = $alert;
        $this->s3Service = $s3Service;
    }

    public function generalSetting()
    {
        $config = getConfig('general');
        return view('admin.setting.general', compact('config'));
    }

    public function saveSetting(SettingRequest $request, $key)
    {
        $attr = $request->all();
        $setting = $this->setting->where('key', $key)->first();
        if ($setting) {
            // update setting
            $result = $setting->update([
                'value' => json_encode($attr)
            ]);
        } else {
            // store setting
            $result = $this->setting->create([
                'key' => $key,
                'value' => json_encode($attr)
            ]);
        }
        if ($result) {
            return response()->json([
                'message' => trans('message.success.updated', ['Module' => trans('setting::setting.name')]),
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => trans('message.error.updated', ['Module' => trans('setting::setting.name')]),
                'status' => 'error'
            ], 500);
        }
    }

    public function atmConfig()
    {
        $config_atm = $this->setting->where('key', 'config_atm')->first();
        $config_wallet = $this->setting->where('key', 'config_wallet')->first();
        if ($config_atm !== null && $config_wallet !== null) {
            $config_atm = json_decode($config_atm->value, true);
            $config_wallet = json_decode($config_wallet->value, true);
        }
        return view('admin.setting.atm', compact('config_atm', 'config_wallet'));
    }

    public function saveATM(Request $request)
    {
        $attr = $request->all();
        $setting = $this->setting->where('key', 'config_atm')->first();
        if ($setting) {
            // update setting
            $result = $setting->update([
                'value' => json_encode($attr)
            ]);
        } else {
            // store setting
            $result = $this->setting->create([
                'key' => 'config_atm',
                'value' => json_encode($attr)
            ]);
        }
        if ($result) {
            return response()->json([
                'message' => trans('message.success.updated', ['Module' => 'Cấu hình ATM']),
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => trans('message.error.updated', ['Module' => 'Cấu hình ATM']),
                'status' => 'error'
            ], 500);
        }
    }

    public function saveWallet(Request $request)
    {
        $attr = $request->all();
        $setting = $this->setting->where('key', 'config_wallet')->first();
        if ($setting) {
            // update setting
            $result = $setting->update([
                'value' => json_encode($attr)
            ]);
        } else {
            // store setting
            $result = $this->setting->create([
                'key' => 'config_wallet',
                'value' => json_encode($attr)
            ]);
        }
        if ($result) {
            return response()->json([
                'message' => trans('message.success.updated', ['Module' => 'Cấu hình Ví điện tử']),
                'status' => 'success'
            ], 200);
        } else {
            return response()->json([
                'message' => trans('message.error.updated', ['Module' => 'Cấu hình Ví điện tử']),
                'status' => 'error'
            ], 500);
        }
    }

    public function logo()
    {
        return view('admin.setting.logo');
    }

    public function saveLogo(Request $request)
    {
        $logo = $request->file('logo');
        $url = UploadFile::uploadFromPublic($logo, 'images');
        $setting = $this->setting->where('key', 'logo')->first();
        if ($setting) {
            // update setting
            $result = $setting->update([
                'value' => $url
            ]);
        } else {
            // store setting
            $result = $this->setting->create([
                'key' => 'logo',
                'value' => $url
            ]);
        }
        return redirect(asset('admin'));
    }

    public function pay(Request $request)
    {
        return view('admin.setting.pay');
    }

    public function addQuanHuy(Request $request)
    {
        if ($request->has('quanhuy')) {
            // get value in request
            $value = $request->input('quanhuy');
            // get setting in database
            $setting = $this->setting->where('key', 'kimcuong')->first();
            if ($setting) {
                // update
            } else {
                // create

            }
        }
        return false;

    }

    public function addKimCuong(Request $request)
    {
        // TODO: add config cấu hình rút kim cương
    }

    public function configNTN()
    {
        try {
            $config = $this->setting->where('key', config('setting.NAPTHENHANH'))->first();
            if (!$config) {
                $config = [];
            } else {
                $config = json_decode($config['value']);
            }
            return view('admin.setting.config_ntn', compact('config'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigNTN(Request $request)
    {
        try {
            $attr = $request->all();
            if (!array_key_exists('id', $attr) || !array_key_exists('key', $attr)) {
                return response()->json([
                    'message' => 'Có lỗi xảy ra.',
                    'status' => 'error'
                ], 500);
            }
            $data = [
                'id' => $attr['id'],
                'key' => $attr['key']
            ];
            $data = json_encode($data);
            // check exist config napthenhanh
            $config = $this->setting->where('key', config('setting.NAPTHENHANH'))->first();
            if ($config) {
                // update config
                $config->update([
                    'value' => $data
                ]);
            } else {
                // create config
                $this->setting->create([
                    'key' => config('setting.NAPTHENHANH'),
                    'value' => $data
                ]);
            }

            return response()->json([
                'message' => 'Cập nhật cấu hình Napthenhanh thành công.',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function configMC()
    {
        try {
            $config = $this->setting->where('key', config('setting.MUACARD'))->first();
            if (!$config) {
                $config = [];
            } else {
                $config = json_decode($config['value']);
            }
            return view('admin.setting.config_mc', compact('config'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigMC(Request $request)
    {
        try {
            $attr = $request->all();
            if (!array_key_exists('key', $attr) || !array_key_exists('callback', $attr)) {
                return response()->json([
                    'message' => 'Có lỗi xảy ra.',
                    'status' => 'error'
                ], 500);
            }
            $data = [
                'key' => $attr['key'],
                'callback' => $attr['callback'],
            ];
            $data = json_encode($data);
            // check exist config muacard
            $config = $this->setting->where('key', config('setting.MUACARD'))->first();
            if ($config) {
                // update config
                $config->update([
                    'value' => $data
                ]);
            } else {
                // create config
                $this->setting->create([
                    'key' => config('setting.MUACARD'),
                    'value' => $data
                ]);
            }

            return response()->json([
                'message' => 'Cập nhật cấu hình Muacard thành công.',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function configLoginFB()
    {
        try {
            $config = $this->setting->where('key', config('setting.LOGIN_FACEBOOK'))->first();
            if (!$config) {
                $config = [];
            } else {
                $config = json_decode($config['value']);
            }
            return view('admin.setting.config_login_fb', compact('config'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigLoginFB(Request $request)
    {
        try {
            $attr = $request->all();
            if (!array_key_exists('url', $attr)) {
                return response()->json([
                    'message' => 'Có lỗi xảy ra.',
                    'status' => 'error'
                ], 500);
            }
            $data = [
                'url' => $attr['url']
            ];
            $data = json_encode($data);
            // check exist config muacard
            $config = $this->setting->where('key', config('setting.LOGIN_FACEBOOK'))->first();
            if ($config) {
                // update config
                $config->update([
                    'value' => $data
                ]);
            } else {
                // create config
                $this->setting->create([
                    'key' => config('setting.LOGIN_FACEBOOK'),
                    'value' => $data
                ]);
            }

            return response()->json([
                'message' => 'Cập nhật cấu hình Login Facebook thành công.',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function configImgur()
    {
        try {
            $config = $this->setting->where('key', config('setting.IMGUR'))->first();
            if (!$config) {
                $config = [];
            } else {
                $config = json_decode($config['value']);
            }
            return view('admin.setting.config_imgur', compact('config'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigImgur(Request $request)
    {
        try {
            $attr = $request->all();
            if (!array_key_exists('client_id', $attr) || !array_key_exists('client_secret', $attr)) {
                return response()->json([
                    'message' => 'Có lỗi xảy ra.',
                    'status' => 'error'
                ], 500);
            }
            $data = [
                'client_id' => $attr['client_id'],
                'client_secret' => $attr['client_secret'],
            ];
            $data = json_encode($data);
            // check exist config muacard
            $config = $this->setting->where('key', config('setting.IMGUR'))->first();
            if ($config) {
                // update config
                $config->update([
                    'value' => $data
                ]);
            } else {
                // create config
                $this->setting->create([
                    'key' => config('setting.IMGUR'),
                    'value' => $data
                ]);
            }

            return response()->json([
                'message' => 'Cập nhật cấu hình Upload Image Imgur thành công.',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function configCardVip()
    {
        try {
            $config = $this->setting->where('key', config('setting.CARDVIP'))->first();
            if (!$config) {
                $config = [];
            } else {
                $config = json_decode($config['value']);
            }
            return view('admin.setting.config_cv', compact('config'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigCardVip(Request $request)
    {
        try {
            $attr = $request->all();
            if (!array_key_exists('key', $attr)) {
                return response()->json([
                    'message' => 'Có lỗi xảy ra.',
                    'status' => 'error'
                ], 500);
            }
            $data = [
                'key' => $attr['key']
            ];
            $data = json_encode($data);
            // check exist config cardvip
            $config = $this->setting->where('key', config('setting.CARDVIP'))->first();
            if ($config) {
                // update config
                $config->update([
                    'value' => $data
                ]);
            } else {
                // create config
                $this->setting->create([
                    'key' => config('setting.CARDVIP'),
                    'value' => $data
                ]);
            }
            return response()->json([
                'message' => 'Cập nhật cấu hình Cardvip thành công.',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function getConfigSliderBackground()
    {
        try {
            $slider = $this->setting->where('key', config('setting.SLIDER'))->first();
            if (!$slider) {
                $slider = [];
            } else {
                $slider = json_decode($slider['value'], true);
                $slider = $slider['slider'];
            }

            $background = $this->setting->where('key', config('setting.BACKGROUND'))->first();
            if (!$background) {
                $background = '';
            } else {
                $background = json_decode($background['value'], true);
                $background = $background['background'];
            }

            return view('admin.setting.slider_background', compact('slider', 'background'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigSlider(Request $request)
    {
        try {
            $attr = $request->all();
            if (!array_key_exists('slider', $attr)) {
                $attr['slider'] = [];
            }
            $data = [
                'slider' => $attr['slider']
            ];
            $data = json_encode($data);
            // check exist config slider
            $config = $this->setting->where('key', config('setting.SLIDER'))->first();
            if ($config) {
                // update config
                $config->update([
                    'value' => $data
                ]);
            } else {
                // create config
                $this->setting->create([
                    'key' => config('setting.SLIDER'),
                    'value' => $data
                ]);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigBackground(Request $request)
    {
        try {
            $attr = $request->all();
            if (!array_key_exists('background', $attr)) {
                $attr['background'] = '';
            }
            $data = [
                'background' => $attr['background']
            ];
            $data = json_encode($data);
            // check exist config background
            $config = $this->setting->where('key', config('setting.BACKGROUND'))->first();
            if ($config) {
                // update config
                $config->update([
                    'value' => $data
                ]);
            } else {
                // create config
                $this->setting->create([
                    'key' => config('setting.BACKGROUND'),
                    'value' => $data
                ]);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function getConfigAlert()
    {
        try {
            $alerts = $this->alert->all()->toArray();
            return view('admin.setting.config_alert', compact('alerts'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigAlert(Request $request)
    {
        try {
            if (!$request->has('url')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lỗi, xin thử lại'
                ]);
            }
            $attr = $request->all();

            $name = $attr['name'];
            $url = $attr['url'];
            $alert = $attr['alert'];

            $result = null;
            // check isset alert
            $count = $this->alert->where('url', $url)->count();
            if ($count > 0) {
                // update alert
                $result = $this->alert->where('url', $url)->first();
                $result->update($attr);
            } else {
                // create alert
                $result = $this->alert->create($attr);
            }

            return response()->json([
                'message' => 'Thêm thông báo thành công.',
                'status' => 'success',
                'alert' => $result
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function getConfigTichHop()
    {
        try {
            $config = $this->setting->where('key', config('setting.TICHHOP'))->first();
            if (!$config) {
                $config = [];
            } else {
                $config = json_decode($config['value']);
            }
            return view('admin.setting.config_tichhop', compact('config'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigTichHop(Request $request)
    {
        try {
            $attr = $request->all();
            if (!array_key_exists('secret', $attr)) {
                return response()->json([
                    'message' => 'Có lỗi xảy ra.',
                    'status' => 'error'
                ], 500);
            }
            $data = [
                'secret' => $attr['secret'],
                'kimcuong' => isset($attr['kimcuong']) ? 1 : 0,
                'quanhuy' => isset($attr['quanhuy']) ? 1 : 0,
            ];
            $data = json_encode($data);
            // check exist config cardvip
            $config = $this->setting->where('key', config('setting.TICHHOP'))->first();
            if ($config) {
                // update config
                $config->update([
                    'value' => $data
                ]);
            } else {
                // create config
                $this->setting->create([
                    'key' => config('setting.TICHHOP'),
                    'value' => $data
                ]);
            }

            return response()->json([
                'message' => 'Cập nhật cấu hình Tích hợp thành công.',
                'status' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function getConfigMessenger()
    {
        try {
            $config = $this->setting->where('key', config('setting.MESSENGER'))->first();
            if (!$config) {
                $messenger = '';
            } else {
                $messenger = $config['value'];
            }
            return view('admin.setting.config_messenger', compact('messenger'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigMessenger(Request $request)
    {
        try {
            $attr = $request->all();
            if (!array_key_exists('messenger', $attr)) {
                return abort(404);
            }
            $messenger = $attr['messenger'];
            // check exist config messenger
            $config = $this->setting->where('key', config('setting.MESSENGER'))->first();
            if ($config) {
                // update config
                $config->update([
                    'value' => $messenger
                ]);
            } else {
                // create config
                $this->setting->create([
                    'key' => config('setting.MESSENGER'),
                    'value' => $messenger
                ]);
            }
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back();
        }
    }

    public function getConfigNaptudong()
    {
        try {
            $config = $this->setting->where('key', config('setting.NAPTUDONG'))->first();
            if (!$config) {
                $config = [];
            } else {
                $config = json_decode($config['value'], true);
            }
            return view('admin.setting.config_ntd', compact('config'));
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    public function postConfigNaptudong(Request $request)
    {
        try {
            $attr = $request->all();
            if (!array_key_exists('partner_id', $attr) || !array_key_exists('partner_key', $attr)) {
                return abort(404);
            }
            $value = [
                'partner_id' => $attr['partner_id'],
                'partner_key' => $attr['partner_key']
            ];
            // check exist config messenger
            $config = $this->setting->where('key', config('setting.NAPTUDONG'))->first();
            if ($config) {
                // update config
                $config->update([
                    'value' => json_encode($value)
                ]);
            } else {
                // create config
                $this->setting->create([
                    'key' => config('setting.NAPTUDONG'),
                    'value' => json_encode($value)
                ]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật cấu hình Naptudong.com thành công'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật cấu hình Naptudong.com thất bại'
            ], 500);
        }
    }

}
