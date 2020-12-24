<?php

namespace App\Http\Controllers\History;

use App\FlipCardHistory;
use App\Http\Controllers\Controller;
use App\Transformer\FlipCard\FlipCardTransformer;
use App\Transformer\History\HistoryTransformer;
use Illuminate\Http\Request;
use Auth;

class FlipCardController extends Controller
{
    private $flipCardHistory;

    public function __construct(FlipCardHistory $flipCardHistory)
    {
        $this->flipCardHistory = $flipCardHistory;
    }

    public function list(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $items = $this->flipCardHistory
            ->where('user_id', Auth::id())
            ->offset($offset)->limit($limit)->get();
        $data = HistoryTransformer::FlipCard($items);
        $countTable = $this->flipCardHistory
            ->where('user_id', Auth::id())
            ->count();
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $countTable,
            'recordsFiltered' => $countTable,
            'data' => $data
        ], 200);
    }
}
