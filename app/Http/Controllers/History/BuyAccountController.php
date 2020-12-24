<?php

namespace App\Http\Controllers\History;

use App\HistoryAccount;
use App\Http\Controllers\Controller;
use App\Transformer\History\HistoryTransformer;
use Illuminate\Http\Request;
use DB;
use Auth;

class BuyAccountController extends Controller
{
    private $historyAccount;

    public function __construct(HistoryAccount $historyAccount)
    {
        $this->historyAccount = $historyAccount;
    }

    public function list(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $accounts = $this->historyAccount->where('user_id', Auth::id())->offset($offset)->limit($limit)->get();
        $data = HistoryTransformer::Account($accounts);
        $countTable = $this->historyAccount->where('user_id', Auth::id())->count();
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $countTable,
            'recordsFiltered' => $countTable,
            'data' => $data
        ], 200);
    }

    public function listAll(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $accounts = $this->historyAccount->offset($offset)->limit($limit)->get();
        $data = HistoryTransformer::forAdmin($accounts);
        $countTable = $this->historyAccount->offset($offset)->get();
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $countTable,
            'recordsFiltered' => $countTable,
            'data' => $data
        ], 200);
    }
}
