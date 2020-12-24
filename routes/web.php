<?php

Route::get('/', 'Home\HomeController@index');
Route::get('login', 'User\UserController@login');
Route::post('login', 'User\UserController@doLogin');
Route::get('register', 'User\UserController@register');
Route::post('register', 'User\UserController@doRegister');

// Check email
Route::get('check-email', 'User\UserController@checkEmail');
Route::get('check-username', 'User\UserController@checkUsername');

// Login Facebook
Route::get('facebook/redirect', 'Auth\SocialController@redirectToProvider');
Route::get('facebook/callback', 'Auth\SocialController@handleProviderCallback');
// Login Google

// Test
//Route::get('test', 'Test\TestController@testCharge');

Route::get('danh-muc/{key}/{up?}/{down?}/{id?}', 'Category\CategoryController@getAccountByCategory');
Route::post('get-accounts', 'Account\AccountController@getListAccount');
Route::get('tai-khoan/{id}', 'Account\AccountController@getAccount');
// check buy account
Route::get('account/check/{id}', 'Account\AccountController@checkBuy');

// random
Route::get('random/{id}', 'Random\AccountController@index');
Route::get('random/buy/{id}', 'Random\AccountController@buy');
Route::post('random/buy', 'Random\AccountController@doBuy');

// spin
Route::get('vong-quay/{id}', 'Spin\SpinController@index');
// get result spin
Route::get('spin/get-result/{id}', 'Spin\SpinController@getResult');

// spin coin
Route::get('vong-quay-tien/{id}', 'Spin\SpinCoinController@index');
// get result spin coin
Route::get('spin-coin/get-result/{id}', 'Spin\SpinCoinController@getResult');

// random coin
Route::get('gift/{id}', 'GiftBox\GiftResourceController@gift');
// open box
Route::get('open-box/{id}', 'GiftBox\BoxResourceController@openBox');

// slot machine
Route::group(['prefix' => 'slot-machine'], function () {
    Route::get('{url}', 'Game\SlotMachine\SlotMachineController@getSlotMachine');
    Route::get('rule/{id}', 'Game\SlotMachine\SlotMachineController@getRule');
    Route::get('history/{id}', 'Game\SlotMachine\SlotMachineController@getHistory');
    Route::get('result/{id}', 'Game\SlotMachine\SlotMachineController@getResult');
});

// flip card
Route::group(['prefix' => 'flip-card'], function () {
    Route::get('{url}', 'Game\FlipCard\FlipCardController@index');
    Route::get('rule/{id}', 'Game\FlipCard\FlipCardController@getRule');
    Route::get('history/{id}', 'Game\FlipCard\FlipCardController@getHistory');
    Route::get('result/{id}', 'Game\FlipCard\FlipCardController@getResult');
});

// get result slot machine
// ----------------------------------------------------------------

Route::group(['prefix' => 'callback'], function () {
    Route::get('napthenhanh', 'Charge\CallbackController@napTheNhanh');
    Route::get('muacard', 'Charge\CallbackController@muaCard');
    Route::get('cardvip', 'Charge\CallbackController@cardVip');
    Route::get('naptudong', 'Charge\CallbackController@napTuDong');
    Route::get('tichhop/{key}', 'Wallet\CallbackController@tichHop');
});

Route::group(['middleware' => 'auth'], function () {
    // logout
    Route::get('logout', 'User\UserController@logout');
    // change info
    Route::get('change-info', 'User\UserController@changeInfo');
    // user
    Route::group(['prefix' => 'user'], function () {
        Route::get('profile', 'User\UserController@profile');
        Route::get('change-password', 'User\UserController@changePassword');
        Route::post('change-password', 'User\UserController@doChangePassword');
        Route::get('nap-the', 'Charge\ChargeController@charge');
        Route::get('nap-atm', 'Charge\ChargeController@atm');
        Route::post('do-charge', 'Charge\ChargeController@doCharge');
        Route::get('the-da-nap', 'Charge\ChargeController@charged');
        Route::get('tai-khoan-da-mua', 'Account\AccountController@historyAccountBought');
        Route::get('tai-khoan-random', 'Account\AccountController@historyAccountRandom');
        Route::get('tai-khoan-vong-quay', 'Account\AccountController@historyAccountSpin');
        Route::get('rut-kim-cuong', 'Wallet\WalletController@withoutKimCuong');
        Route::get('rut-quan-huy', 'Wallet\WalletController@withoutQuanHuy');
        Route::get('mo-hom', 'Account\AccountController@historyBox');
        Route::get('quay-xeng', 'Account\AccountController@historySlotMachine');
        Route::get('lat-the-bai', 'Account\AccountController@historyFlipCard');
    });
    // charge
    Route::get('charge/list', 'Charge\ChargeController@chargeList');
    // buy account
    Route::get('account/buy/{id}', 'Account\AccountController@buyAccount');
    // history account
    Route::get('history-account/list', 'History\BuyAccountController@list');
    Route::get('history-account-all', 'History\BuyAccountController@listAll');
    // history random
    Route::get('history-random/list', 'History\BuyRandomController@list');
    // history spin
    Route::get('history-spin/list', 'History\BuySpinController@list');
    // history box
    Route::get('history-box/list', 'History\BuyBoxController@bought');
    // history slot machine
    Route::get('history-slot-machine/list', 'History\SlotMachineController@list');
    // history flip card
    Route::get('history-flip-card/list', 'History\FlipCardController@list');
    // wallet for user
    Route::group(['prefix' => 'wallet'], function () {
        Route::get('list', 'Wallet\HistoryController@index');
        Route::post('without-quanhuy', 'Wallet\HistoryController@withoutQuanhuy');
        Route::post('without-kimcuong', 'Wallet\HistoryController@withoutKimcuong');
    });
    // modal show info account
    Route::get('account/info/{id}', 'Account\AccountController@showInfo');

    // modal show info account random
    Route::get('random/info/{id}', 'Random\AccountController@showInfo');
});

Route::get('admin/login', 'Admin\AuthController@getLogin');
Route::post('admin/login', 'Admin\AuthController@postLogin');

Route::group(['prefix' => 'admin', 'middleware' => ['check_admin']], function () {

    // dashboard admin
    Route::get('', 'Admin\AdminController@dashboard');

    // logout
    Route::get('logout', 'Admin\AuthController@getLogout');

    // Route for supper admin
    Route::group(['middleware' => 'is_super'], function () {

        // Begin manager admin
        Route::get('list', 'Admin\AdminController@list');
        Route::get('create', 'Admin\AdminController@create');
        Route::post('store', 'Admin\AdminController@store');
        Route::get('edit/{id}', 'Admin\AdminController@edit');
        Route::post('update/{id}', 'Admin\AdminController@update');
        Route::get('delete/{id}', 'Admin\AdminController@delete');
        Route::get('check-unique', 'Admin\AdminController@checkUnique');
        Route::get('change-pass/{id}', 'Admin\AdminController@getChangePass');
        Route::post('change-pass/{id}', 'Admin\AdminController@postChangePass');
        Route::get('reset-income/{id}', 'Admin\AdminController@resetIncome');
        // End manager admin

        // setting
        Route::group(['prefix' => 'setting'], function () {
            // general
            Route::get('setting/general', 'Setting\SettingController@generalSetting');
            Route::post('save/{key}', 'Setting\SettingController@saveSetting');
            // atm
            Route::get('atm', 'Setting\SettingController@atmConfig');
            Route::post('save-atm', 'Setting\SettingController@saveATM');
            Route::post('save-wallet', 'Setting\SettingController@saveWallet');
            // logo
            Route::get('logo', 'Setting\SettingController@logo');
            Route::post('logo', 'Setting\SettingController@saveLogo');
            // pay
            Route::get('pay', 'Setting\SettingController@pay');
            // add quanhuy
            Route::post('add-quanhuy', 'Setting\SettingController@addQuanHuy');
            // add kimcuong
            Route::post('add-kimcuong', 'Setting\SettingController@addKimCuong');
            // config napthenhanh
            Route::get('config-ntn', 'Setting\SettingController@configNTN');
            Route::post('config-ntn', 'Setting\SettingController@postConfigNTN');
            // config muacard
            Route::get('config-mc', 'Setting\SettingController@configMC');
            Route::post('config-mc', 'Setting\SettingController@postConfigMC');
            // config muacard
            Route::get('config-cv', 'Setting\SettingController@configCardVip');
            Route::post('config-cv', 'Setting\SettingController@postConfigCardVip');
            // config login facebook
            Route::get('config-login-fb', 'Setting\SettingController@configLoginFB');
            Route::post('config-login-fb', 'Setting\SettingController@postConfigLoginFB');
            // config imgur upload image
            Route::get('config-imgur', 'Setting\SettingController@configImgur');
            Route::post('config-imgur', 'Setting\SettingController@postConfigImgur');
            // config slider & background
            Route::get('config-slider-background', 'Setting\SettingController@getConfigSliderBackground');
            Route::post('config-slider', 'Setting\SettingController@postConfigSlider');
            Route::post('config-background', 'Setting\SettingController@postConfigBackground');
            // config alert
            Route::get('config-alert', 'Setting\SettingController@getConfigAlert');
            Route::post('config-alert', 'Setting\SettingController@postConfigAlert');
            // config tichhop
            Route::get('config-tichhop', 'Setting\SettingController@getConfigTichHop');
            Route::post('config-tichhop', 'Setting\SettingController@postConfigTichHop');
            // config messenger
            Route::get('config-messenger', 'Setting\SettingController@getConfigMessenger');
            Route::post('config-messenger', 'Setting\SettingController@postConfigMessenger');
            // config naptudong.com
            Route::get('config-ntd', 'Setting\SettingController@getConfigNaptudong');
            Route::post('config-ntd', 'Setting\SettingController@postConfigNaptudong');
        });
        // user
        Route::group(['prefix' => 'user'], function () {
            Route::resource('user', 'User\UserResourceController');
            Route::get('list', 'User\UserResourceController@list');
            Route::get('change-password/{id}', 'User\UserResourceController@changePassword');
            Route::post('change-password/{id}', 'User\UserResourceController@doChangePassword');
        });
        // category
        Route::group(['prefix' => 'category'], function () {
            Route::resource('category', 'Category\CategoryResourceController');
        });
        // payment
        Route::group(['prefix' => 'payment'], function () {
            Route::resource('payment', 'Payment\PaymentResourceController');
            Route::get('list', 'Payment\PaymentResourceController@list');
            Route::post('save-position', 'Payment\PaymentResourceController@savePosition');
            Route::get('statistical', 'Payment\PaymentResourceController@statistical');
        });
        // charge
        Route::group(['prefix' => 'charge'], function () {
            Route::resource('charge', 'Charge\ChargeResourceController');
            Route::get('list', 'Charge\ChargeResourceController@list');
            Route::get('approved', 'Charge\ChargeResourceController@approved');
            Route::get('card-true/{id}', 'Charge\ChargeResourceController@cardTrue');
            Route::get('card-false/{id}', 'Charge\ChargeResourceController@cardFalse');
        });
        // spin
        Route::group(['prefix' => 'spin'], function () {
            // spin
            Route::resource('spin', 'Spin\SpinResourceController');
            Route::resource('account', 'Spin\AccountResourceController');
            Route::get('list', 'Spin\SpinResourceController@list');
            Route::get('list-account/{id}', 'Spin\SpinResourceController@listAccount');

            // spin coin
            Route::resource('coin', 'Spin\SpinCoinResourceController');
            Route::get('list-coin', 'Spin\SpinCoinResourceController@list');
        });
        // history
        Route::group(['prefix' => 'history'], function () {
            Route::get('account', 'History\HistoryController@historyAccount');
            Route::get('random', 'History\HistoryController@historyRandom');
            Route::get('spin', 'History\HistoryController@historySpin');
            Route::get('spin-coin', 'History\HistoryController@historySpinCoin');
            Route::get('wallet', 'History\HistoryController@historyWallet');
            Route::get('box', 'History\HistoryController@historyBox');
            Route::get('slot-machine', 'History\HistoryController@historySlotMachine');
            Route::get('flip-card', 'History\HistoryController@historyFlipCard');
        });
        // top charge
        Route::group(['prefix' => 'top-charge'], function () {
            Route::get('/', 'Charge\TopChargeController@index');
            Route::post('save', 'Charge\TopChargeController@save');
            Route::get('reset', 'Charge\TopChargeController@reset');
        });
        // wallet
        Route::group(['prefix' => 'wallet'], function () {
            Route::resource('wallet', 'Wallet\WalletResourceController');
            Route::resource('history', 'Wallet\HistoryResourceController');
            Route::get('approved/{id}', 'Wallet\HistoryController@approved');
            Route::get('refuse/{id}', 'Wallet\HistoryController@refuse');
        });
        // alert
        Route::group(['prefix' => 'alert'], function () {
            Route::resource('alert', 'Alert\AlertResourceController');
        });

        // random
        Route::group(['prefix' => 'random'], function () {
            Route::resource('random', 'Random\RandomResourceController');
            Route::get('list', 'Random\RandomResourceController@list');
        });

        // gift box
        Route::group(['prefix' => 'gift-box'], function () {
            Route::resource('gift', 'GiftBox\GiftResourceController');
            Route::resource('box', 'GiftBox\BoxResourceController');
            Route::get('list-boxes/{id}', 'GiftBox\GiftResourceController@listBoxes');
        });

        // slot machine
        Route::group(['prefix' => 'slot-machine'], function () {
             Route::resource('slot-machine', 'Game\SlotMachine\SlotMachineResourceController');
        });

        // slot machine
        Route::group(['prefix' => 'flip-card'], function () {
            Route::resource('flip-card', 'Game\FlipCard\FlipCardResourceController');
        });

        // star
        Route::group(['prefix' => 'star'], function () {
            Route::resource('star', 'Star\StarResourceController');
            Route::get('list', 'Star\StarResourceController@list');
            Route::get('spin/{id}', 'Star\StarResourceController@addSpinStar');
            Route::get('spin-coin/{id}', 'Star\StarResourceController@addSpinStar');
            Route::get('spin-coin/{id}', 'Star\StarResourceController@addSpinCoinStar');
            Route::get('slot-machine/{id}', 'Star\StarResourceController@addSlotMachineStar');
        });

        // Router for virtual history
        Route::group(['prefix' => 'virtual-history'], function () {
            Route::resource('virtual-history', 'VirtualHistory\VirtualHistoryResourceController');
        });
        // Router for virtual history special
        Route::group(['prefix' => 'virtual-history-special'], function () {
            Route::resource('virtual-history-special', 'VirtualHistory\VirtualSpecialHistoryResourceController');
        });

        // Router for virtual history
        Route::group(['prefix' => 'virtual'], function () {
            Route::get('create', 'VirtualHistory\VirtualHistoryController@create');
            Route::post('create-users', 'VirtualHistory\VirtualHistoryController@createUsers');
            Route::post('create-histories', 'VirtualHistory\VirtualHistoryController@createHistories');
        });
    });

    // for upload image
    Route::group(['prefix' => 'upload'], function () {
        Route::post('image', 'Upload\ImageController@uploadImage');
    });

    // account
    Route::group(['prefix' => 'account'], function () {
        Route::resource('account', 'Account\AccountResourceController');
        Route::get('list', 'Account\AccountResourceController@list');
        Route::get('type/{id}/{accountId?}', 'Account\AccountResourceController@getType');
    });

    // random
    Route::group(['prefix' => 'random'], function () {
        Route::resource('account', 'Random\AccountResourceController');
        Route::get('list-account/{id?}', 'Random\RandomResourceController@listAccount');
    });

});
