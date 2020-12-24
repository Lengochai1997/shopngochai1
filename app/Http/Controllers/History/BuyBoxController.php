<?php

namespace App\Http\Controllers\History;

use App\HistoryBox;
use App\Http\Controllers\Controller;
use App\Transformer\History\HistoryTransformer;
use Illuminate\Http\Request;
use Auth;

class BuyBoxController extends Controller
{
    private $historyBox;

    public function __construct(HistoryBox $historyBox)
    {
        $this->historyBox = $historyBox;
    }

    /**
     * List history for admin
     */
    public function list()
    {
        try {

        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    /**
     * List history for user
     */
    public function bought(Request $request)
    {
        try {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $items = $this->historyBox->where('user_id', Auth::id())->offset($offset)->limit($limit)->get();
            $data = HistoryTransformer::Box($items);
            $countTable = $this->historyBox->where('user_id', Auth::id())->count();
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $countTable,
                'recordsFiltered' => $countTable,
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }
}
