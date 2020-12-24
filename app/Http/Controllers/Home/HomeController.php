<?php

namespace App\Http\Controllers\Home;

use App\Category;
use App\FlipCard;
use App\Gift;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Random;
use App\Setting;
use App\SlotMachine;
use App\Spin;
use App\SpinCoin;
use App\TopCharge;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{

    private $category;
    private $random;
    private $spin;
    private $spinCoin;
    private $topCharge;
    private $user;
    private $payment;
    private $gift;
    private $slotMachine;
    private $flipCard;

    public function __construct(Category $category,
                                Random $random,
                                Spin $spin,
                                SpinCoin $spinCoin,
                                TopCharge $topCharge,
                                User $user,
                                Payment $payment,
                                Gift $gift,
                                SlotMachine $slotMachine, FlipCard $flipCard)
    {
        $this->category = $category;
        $this->random = $random;
        $this->spin = $spin;
        $this->spinCoin = $spinCoin;
        $this->topCharge = $topCharge;
        $this->user = $user;
        $this->payment = $payment;
        $this->gift = $gift;
        $this->slotMachine = $slotMachine;
        $this->flipCard = $flipCard;
    }

    public function index()
    {
        $categories = $this->category->all()->toArray();
        $randoms = $this->random->where('status', 1)->get();
        $spins = $this->spin->where('status', 1)->get();
        $spin_coins = $this->spinCoin->where('status', 1)->get();
        $topCharge = $this->topCharge->orderBy('total', 'desc')->offset(0)->limit(5)->get();
        $payments = $this->payment->where('status', 1)->get()->toArray();
        $gifts = $this->gift->where('status', 1)->get();
        $slotMachines = $this->slotMachine->where('status', 1)->get();
        $flipCards = $this->flipCard->where('status', 1)->get();
        $slider = $this->getSlider();
        $background = $this->getBackground();
        return view('home.index', compact('categories', 'randoms', 'spins', 'spin_coins', 'topCharge', 'payments', 'gifts', 'slotMachines', 'flipCards', 'slider', 'background'));
    }

    private function getSlider()
    {
        $slider = getConfig(config('setting.SLIDER'));
        if (array_key_exists('slider', $slider)) {
            return $slider['slider'];
        } else {
            return 'https://via.placeholder.com/1000x300';
        }
    }

    private function getBackground()
    {
        $background = getConfig(config('setting.BACKGROUND'));
        if (array_key_exists('background', $background)) {
            return $background['background'];
        } else {
            return 'https://via.placeholder.com/1000x300';
        }
    }

    public function support()
    {

    }

    public function contact()
    {

    }

    public function rules()
    {

    }
}
