<?php

namespace App\Http\Controllers\History;

use App\HistorySpin;
use App\Http\Controllers\Controller;
use App\Transformer\History\HistoryTransformer;
use Illuminate\Http\Request;
use DB;
use Auth;

class BuySpinController extends Controller
{
    private $historySpin;

    public function __construct(HistorySpin $historySpin)
    {
        $this->historySpin = $historySpin;
    }

    public function list(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $countTable = DB::table('history_spins')->count();
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $accounts = $this->historySpin->where('user_id', Auth::id())->offset($offset)->limit($limit)->get();
        $data = HistoryTransformer::Spin($accounts);
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $countTable,
            'recordsFiltered' => $countTable,
            'data' => $data
        ], 200);
    }
}
