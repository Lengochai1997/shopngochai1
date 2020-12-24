<?php

namespace App\Http\Controllers\History;

use App\HistoryRandom;
use App\Http\Controllers\Controller;
use App\RandomAccount;
use App\Transformer\History\HistoryTransformer;
use Illuminate\Http\Request;
use DB;
use Auth;

class BuyRandomController extends Controller
{
    private $historyRandom;

    public function __construct(HistoryRandom $historyRandom)
    {
        $this->historyRandom = $historyRandom;
    }

    public function list(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $accounts = $this->historyRandom->where('user_id', Auth::id())->offset($offset)->limit($limit)->get();
        $countTable = $this->historyRandom->where('user_id', Auth::id())->count();
        $data = HistoryTransformer::Random($accounts);
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $countTable,
            'recordsFiltered' => $countTable,
            'data' => $data
        ], 200);
    }
}
