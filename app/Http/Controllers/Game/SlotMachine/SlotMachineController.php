<?php

namespace App\Http\Controllers\Game\SlotMachine;

use App\HistorySlotMachine;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\SlotMachine;
use App\Star;
use App\Transformer\SlotMachine\SlotMachineTransformer;
use Illuminate\Http\Request;
use Auth;

class SlotMachineController extends Controller
{
    private $slotMachine;
    private $historySlotMachine;
    private $star;

    public function __construct(SlotMachine $slotMachine, HistorySlotMachine $historySlotMachine, Star $star)
    {
        $this->slotMachine = $slotMachine;
        $this->historySlotMachine = $historySlotMachine;
        $this->star = $star;
    }

    public function getSlotMachine(Request $request, $url)
    {
        $view = 'game.slot_machine.index';
        $item = $this->slotMachine->where('url', $url)->first();
        switch ($item->model) {
            case 'halloween':
                $view = 'game.slot_machine.halloween';
                break;
        }
        if (!$item) {
            return abort(404);
        }
        $item = SlotMachineTransformer::forShow($item);
        return view($view, compact('item'));
    }

    public function getRule(Request $request, $id)
    {
        $item = $this->slotMachine->find($id);
        if (!$item) {
            return abort(404);
        }
        $rule = $item->description;
        return view('game.slot_machine.popup.rule_popup', compact('rule'));
    }

    public function getHistory(Request $request, $id)
    {
        $item = $this->slotMachine->find($id);
        if (!$item) {
            return abort(404);
        }

        $histories = $this->historySlotMachine->where('slot_machine_id', $id)->orderBy('id', 'desc')->offset(0)->limit(20)->get();
        return view('game.slot_machine.popup.history_popup', compact('histories'));
    }

    public function getResult(Request $request, $id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn chưa đăng nhập'
                ], 401);
            }
            $item = $this->slotMachine->find($id);
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
                ->where('type', 'slot_machine')
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
                $this->historySlotMachine->create([
                    'user_id' => Auth::id(),
                    'slot_machine_id' => $item->id,
                    'slot_machine_title' => $item->title,
                    'slot_machine_price' => $item->price,
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
                updateWalletUser($item->type, $slotResult['coin']);

                // add history success
                $this->historySlotMachine->create([
                    'user_id' => Auth::id(),
                    'slot_machine_id' => $item->id,
                    'slot_machine_title' => $item->title,
                    'slot_machine_price' => $item->price,
                    'result' => $slotResult['title'],
                    'description' => ''
                ]);

                $result = [$result, $result, $result];
                return response()->json([
                    'status' => 'success',
                    'message' => 'Chúc mừng bạn đã trúng ' . $slotResult['title'],
                    'result' => $result
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi xảy ra'
            ], 400);
        }
    }

}
