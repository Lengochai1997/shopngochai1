<?php

use App\Setting;
use App\TopCharge;
use App\Category;
use App\Random;
use App\Alert;
use App\Wallet;

if (!function_exists('getConfig')) {
    function getConfig($config) {
        $config = Setting::where('key', $config)->first();
        if (!$config) {
            return [];
        }
        $config = json_decode($config['value'], true);
        return $config;
    }
}

if (!function_exists('getLogo')) {
    function getLogo() {
        $config = Setting::where('key', 'logo')->first()->toArray();
        if (!$config) {
            return null;
        }
        $config = $config['value'];
        return $config;
    }
}

if (!function_exists('appendTopCharge')) {
    function appendTopCharge($user_id, $value) {
        $topCharge = TopCharge::where('user_id', $user_id)->get();
        if (count($topCharge) === 0) {
            TopCharge::create([
                'user_id' => $user_id,
                'total' => $value
            ]);
        } else {
            $topCharge = $topCharge[0];
            $topCharge->update([
                'total' => $topCharge->total + $value
            ]);
        }
    }
}

if (!function_exists('plusCountAccount')) {
    function plusCountAccount($category_id) {
        $category = Category::find($category_id);
        $category->update([
            'count_account' => $category->count_account + 1
        ]);
    }
}

if (!function_exists('plusCountSold')) {
    function plusCountSold($category_id) {
        $category = Category::find($category_id);
        $category->update([
            'count_sold' => $category->count_sold + 1
        ]);
    }
}

if (!function_exists('roundPrice')) {
    function roundPrice($price) {
        if ($price > 10000) {
            return round($price*0.8/1000)*1000;
        }
        return 0;
    }
}

if (!function_exists('plusRandomAccount')) {
    function plusRandomAccount($random_id, $value = 1) {
        $random = Random::findOrFail($random_id);
        if ($random) {
            $random->update([
                'count_account' => $random->count_account + $value
            ]);
        }
    }
}

if (!function_exists('plusRandomSell')) {
    function plusRandomSell($random_id, $value = 1) {
        $random = Random::findOrFail($random_id);
        if ($random) {
            $random->update([
                'count_selled' => $random->count_selled + $value
            ]);
        }
    }
}

if (!function_exists('checkRequest')) {
    function checkRequest($attr) {
        if (!$attr) return [];
        $result = [];
        foreach ($attr as $key => $value) {
            $result[$key] = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $value);
        }
        return $result;
    }
}

if (!function_exists('checkUrl')) {
    function checkAlert($current) {
        $alert = Alert::where('url', $current)->first();
        if (!$alert) {
            return false;
        }
        return $alert->toArray();
    }
}

if (!function_exists('updateWalletUser')) {
    function updateWalletUser($type, $value, $user_id = null) {
        $user_id = $user_id !== null ? $user_id : Auth::id();
        // add to wallet user
        $wallet = Wallet::where('user_id', $user_id)->first();
        if ($wallet) {
            if ($type == 'kimcuong') {
                $wallet->update([
                    'kimcuong' => $wallet->kimcuong + $value
                ]);
            } else if ($type == 'quanhuy') {
                $wallet->update([
                    'quanhuy' => $wallet->quanhuy + $value
                ]);
            }
        } else {
            if ($type == 'kimcuong') {
                Wallet::create([
                    'user_id' => $user_id,
                    'kimcuong' => $value,
                    'quanhuy' => 0,
                ]);
            } else if ($type == 'quanhuy') {
                Wallet::create([
                    'user_id' => $user_id,
                    'quanhuy' => $value,
                    'kimcuong' => 0
                ]);
            }
        }
    }
}

if (!function_exists('hiddenUsername')) {
    function hiddenUsername($str) {
        return preg_replace("/(?!^).(?!$)/", "*", $str);
    }
}

if (!function_exists('processImagesAccount')) {
    function processImagesAccount($images) {
        $images = json_decode($images, true);
        if(!is_array($images)) {
            return [];
        }
        $imagesTmp = [];
        if (array_key_exists('images_des', $images)) {
            foreach ($images['images_des'] as $image) {
                array_push($imagesTmp, $image);
            }
        }
        if (array_key_exists('images_hero', $images)) {
            foreach ($images['images_hero'] as $image) {
                array_push($imagesTmp, $image);
            }
        }
        if (array_key_exists('images_skin', $images)) {
            foreach ($images['images_skin'] as $image) {
                array_push($imagesTmp, $image);
            }
        }
        if (count($imagesTmp) == 0) {
            return $images;
        }
        return $imagesTmp;
    }
}
