<?php

namespace App\Http\Controllers\History;

use App\HistorySlotMachine;
use App\Http\Controllers\Controller;
use App\Transformer\History\HistoryTransformer;
use Illuminate\Http\Request;
use Auth;

class SlotMachineController extends Controller
{
    private $historySlotMachine;

    public function __construct(HistorySlotMachine $historySlotMachine)
    {
        $this->historySlotMachine = $historySlotMachine;
    }

    public function list(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $items = $this->historySlotMachine
            ->where('user_id', Auth::id())
            ->offset($offset)->limit($limit)->get();
        $data = HistoryTransformer::SlotMachine($items);
        $countTable = $this->historySlotMachine
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
