<?php

namespace App\Http\Controllers\Game\FlipCard;

use App\FlipCard;
use App\FlipCardHistory;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Star;
use App\Transformer\FlipCard\FlipCardTransformer;
use Illuminate\Http\Request;
use Auth;

class FlipCardController extends Controller
{
    private $flipCard;
    private $flipCardHistory;
    private $flipCardTransformer;
    private $star;

    public function __construct(FlipCard $flipCard, FlipCardHistory $flipCardHistory, FlipCardTransformer $flipCardTransformer, Star $star)
    {
        $this->flipCard = $flipCard;
        $this->flipCardHistory = $flipCardHistory;
        $this->flipCardTransformer = $flipCardTransformer;
        $this->star = $star;
    }

    public function index($url)
    {
        $item = $this->flipCard->where('url', $url)->first();
        if (!$item) {
            return abort(404);
        }
        $item = $this->flipCardTransformer->forShow($item);
        return view('game.flip_card.index', compact('item'));
    }

    public function getRule($id)
    {
        $item = $this->flipCard->find($id);
        if (!$item) {
            return abort(404);
        }
        $rule = $item->description;
        return view('game.flip_card.popup.rule_popup', compact('rule'));
    }

    public function getHistory($id)
    {
        $item = $this->flipCard->find($id);
        if (!$item) {
            return abort(404);
        }

        $histories = $this->flipCardHistory->where('flip_card_id', $id)->orderBy('id', 'desc')->offset(0)->limit(10)->get();
        return view('game.flip_card.popup.history_popup', compact('histories'));
    }

    public function getResult($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn chưa đăng nhập'
                ], 401);
            }
            $item = $this->flipCard->find($id);
            // check slot machine
            if (!$item) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Thao tác không hợp lệ'
                ], 404);
            }
            // check wallet
            if (Auth::user()->total_money < $item->price) {
                return response()->json([
                    'message' => 'Tài khoản không đủ, nạp thêm tiền để quay',
                    'status' => 'error'
                ], 500);
            }

            UserService::minusMoney(Auth::id(), $item->price);

            $slots = json_decode($item->slots, true);
            $arrResult = [];

            // check user in star
            $star = $this->star
                ->where('type', 'flip_card')
                ->where('type_id', $id)
                ->where('user_id', Auth::id())
                ->first();
            if ($star) {
                // process star
                $ratio = json_decode($star->value);
                for ($i = 0; $i < count($ratio); $i++) {
                    for ($j = 0; $j < intval($ratio[$i]); $j++) {
                        array_push($arrResult, $i);
                    }
                }
            } else {
                foreach ($slots as $key => $slot) {
                    if ($slot['value'] > 0) {
                        for ($i = 0; $i < $slot['value']; $i++) {
                            array_push($arrResult, $key);
                        }
                    }
                }
            }
            while (count($arrResult) < 100) {
                array_push($arrResult, -1);
            }
            shuffle($arrResult);
            $flag = rand(0, count($arrResult));
            $result = $arrResult[$flag];
            if ($result == -1) {
                // process miss
                $result = [];
                $i = 0;
                do {
                    $tmp = rand(0, count($slots));
                    if (!in_array($tmp, $result)) {
                        array_push($result, $tmp);
                        $i++;
                    }
                } while ($i < 3);
                // add history miss
                $this->flipCardHistory->create([
                    'user_id' => Auth::id(),
                    'flip_card_id' => $item->id,
                    'flip_card_title' => $item->title,
                    'flip_card_price' => $item->price,
                    'result' => 'Chúc bạn may mắn lấn sau',
                    'description' => ''
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Chúc bạn may mắn lấn sau',
                    'result' => $result
                ], 200);

            } else {
                // process success
                // update wallet
                $slotResult = $slots[$result];
                array_splice($slots, $result, 1);
                updateWalletUser($item->type, $slotResult['coin']);

                // add history success
                $this->flipCardHistory->create([
                    'user_id' => Auth::id(),
                    'flip_card_id' => $item->id,
                    'flip_card_title' => $item->title,
                    'flip_card_price' => $item->price,
                    'result' => $slotResult['title'],
                    'description' => ''
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Chúc mừng bạn đã trúng ' . $slotResult['title'],
                    'image' => $slotResult['img'],
                    'images' => $slots
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
