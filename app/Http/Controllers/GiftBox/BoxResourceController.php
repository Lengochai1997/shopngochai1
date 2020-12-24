<?php

namespace App\Http\Controllers\GiftBox;

use App\Box;
use App\HistoryBox;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Transformer\Box\BoxTransformer;
use App\Wallet;
use Illuminate\Http\Request;
use Auth;

class BoxResourceController extends Controller
{
    private $box;
    private $historyBox;
    private $wallet;

    public function __construct(Box $box, HistoryBox $historyBox, Wallet $wallet)
    {
        $this->box = $box;
        $this->historyBox = $historyBox;
        $this->wallet = $wallet;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $status = $request->has('status') ? $request->input('status') : null;
        $gift_id = $request->has('gift_id') ? $request->input('gift_id') : null;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $accounts = $this->box
            ->where(function ($query) use ($gift_id) {
                if ($gift_id !== null && $gift_id !== '') {
                    $query->where('gift_id', $gift_id);
                }
            })
            ->where(function ($query) use ($status) {
                if ($status !== null && $status !== '') {
                    $query->where('status', $status);
                }
            })
            ->where('value', 'like', "%{$sSearch}%")
            ->offset($offset)->limit($limit)
            ->get();
        $data = BoxTransformer::forDataTables($accounts);
        $count = $this->box
            ->where(function ($query) use ($gift_id) {
                if ($gift_id !== null && $gift_id !== '') {
                    $query->where('gift_id', $gift_id);
                }
            })
            ->where(function ($query) use ($status) {
                if ($status !== null && $status !== '') {
                    $query->where('status', $status);
                }
            })
            ->where('value', 'like', "%{$sSearch}%")
            ->count();
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $gift_id = $request->input('gift_id');
            $boxes = explode('|', $request->input('boxes'));
            foreach ($boxes as $box) {
                $item = [
                    'gift_id' => $gift_id,
                    'value' => $box,
                    'status' => 0,
                    'description' => ''
                ];
                $this->box->create($item);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Thêm hòm quà thành công'
            ], 200);
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $item = $this->box->find($id);
            if ($item) {
                return view('admin.gift_box.edit_box', compact('item'));
            }
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $params = $request->all();
            $item = $this->box->find($id);
            $gift = $item->gift;
            if ($item) {
                $item->update($params);
                return redirect(asset('admin/gift-box/list-boxes/'.$gift->id));
            }
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->box->find($id);
            if ($item) {
                $item->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Xóa thành công'
                ], 200);
            }
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function openBox($id)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn chưa đăng nhập'
                ], 401);
            }
            $box = $this->box->find($id);
            $gift = $box->gift;
            if (!$box || $box->status != 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Hòm quà không tồn tại khoặc đã bị mua'
                ], 400);
            }
            if (Auth::user()->total_money < $gift->price) {
                return response()->json([
                    'message' => 'Bạn không đủ tiền, nạp thêm để tiền thành mở hòm.',
                    'status' => 'error'
                ], 500);
            }
            // change status box to 2;
            $box->update(['status' => 2]);
            // add history box;
            $history = $this->historyBox->create([
                'box_id' => $box->id,
                'user_id' => Auth::id(),
                'description' => '',
            ]);
            // add value to wallet user
            $this->updateWallet($gift, $box->value);

            // update money user
            UserService::minusMoney(Auth::id(), $gift->price);

            // return response
            $gift = $box->gift;
            $typeValue = config('coin.type')[$gift->type];
            return response()->json([
                'status' => 'success',
                'message' => 'Bạn nhập được ' . $box->value . ' ' . $typeValue,
            ], 200);
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    private function updateWallet($gift, $value)
    {
        // add to wallet user
        $wallet = $this->wallet->where('user_id', Auth::id())->first();
        if ($wallet) {
            $type = $gift->type;
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
            $type = $gift->type;
            if ($type == 'kimcuong') {
                $this->wallet->create([
                    'user_id' => Auth::id(),
                    'kimcuong' => $value,
                    'quanhuy' => 0,
                ]);
            } else if ($type == 'quanhuy') {
                $this->wallet->create([
                    'user_id' => Auth::id(),
                    'quanhuy' => $value,
                    'kimcuong' => 0
                ]);
            }
        }
    }
}
