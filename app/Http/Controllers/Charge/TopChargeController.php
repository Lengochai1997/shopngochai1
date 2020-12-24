<?php

namespace App\Http\Controllers\Charge;

use App\Http\Controllers\Controller;
use App\TopCharge;
use App\User;
use Illuminate\Http\Request;
use DB;

class TopChargeController extends Controller
{
    private $topCharge;
    private $user;

    public function __construct(TopCharge $topCharge, User $user)
    {
        $this->topCharge = $topCharge;
        $this->user = $user;
    }

    public function index()
    {
        $topCharges = $this->topCharge->orderBy('total', 'desc')->offset(0)->limit(5)->get();
        $users = $this->user->where('is_supper_admin', 0)->get();
        return view('admin.top_charge.index', compact('users', 'topCharges'));
    }

    public function save(Request $request)
    {
        $topCharge = $this->topCharge->find($request->input('id'));
        $topCharge->update([
            'user_id' => $request->input('user_id'),
            'total' => $request->input('total')
        ]);
        return response()->json([
            'message' => 'Lưu thành công',
            'status' => 'success'
        ], 200);
    }

    public function reset()
    {
        $result = $this->topCharge->whereNotNull('id')->delete();
        return response()->json([
            'message' => 'Reset top thành công',
            'status' => 'success'
        ], 200);
    }
}
