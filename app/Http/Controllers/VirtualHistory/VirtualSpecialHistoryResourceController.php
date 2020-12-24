<?php

namespace App\Http\Controllers\VirtualHistory;

use App\Http\Controllers\Controller;
use App\Spin;
use App\SpinCoin;
use App\Transformer\VirtualHistory\VirtualHistoryTransformer;
use App\VirtualSpecialHistory;
use Illuminate\Http\Request;

class VirtualSpecialHistoryResourceController extends Controller
{
    private $virtualSpecialHistory;
    private $historyTransformer;

    private $spin;
    private $spinCoin;

    public function __construct(VirtualSpecialHistory $virtualSpecialHistory,
                                VirtualHistoryTransformer $historyTransformer,
                                Spin $spin,
                                SpinCoin $spinCoin)
    {
        $this->virtualSpecialHistory = $virtualSpecialHistory;
        $this->historyTransformer = $historyTransformer;
        $this->spin = $spin;
        $this->spinCoin = $spinCoin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('type') && $request->input('type') == 'json') {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';

            $spinType = $request->has('spin_type') ? $request->input('spin_type') : '';
            $ref_id = $request->has('ref_id') ? $request->input('ref_id') : '';

            $accounts = $this->virtualSpecialHistory
                ->where('name', 'like', "%{$sSearch}%")
                ->where('result', 'like', "%{$sSearch}%")
                ->where(function ($query) use ($spinType) {
                    if ($spinType != '') {
                        $query->where('type', $spinType);
                    }
                })
                ->where(function ($query) use ($ref_id) {
                    if ($ref_id != '') {
                        $query->where('ref_id', $ref_id);
                    }
                })
                ->offset($offset)->limit($limit)
                ->get();
            $count = $this->virtualSpecialHistory
                ->where('name', 'like', "%{$sSearch}%")
                ->where('result', 'like', "%{$sSearch}%")
                ->count();
            $data = $this->historyTransformer->forDataTable($accounts);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ], 200);
        }
        $spin = $this->spin->all()->toArray();
        $spinCoin = $this->spinCoin->all()->toArray();
        $spins = array_merge($spin, $spinCoin);

        return view('admin.virtual_history.special.index', compact('spins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $item = $this->virtualSpecialHistory->newInstance();
        $type = $request->has('type') ? $request->input('type') : 'spin';
        $spins = [];
        if ($type == 'spin') {
            $spins = $this->spin->all();
        } elseif ($type == 'spin_coin') {
            $spins = $this->spinCoin->all();
        }
        return view('admin.virtual_history.special.create', compact('item', 'type', 'spins'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        $params = $this->historyTransformer->forInsert($params);
        $result = $this->virtualSpecialHistory->create($params);
        return redirect(asset('admin/virtual-history-special/virtual-history-special'))->with('message', 'Thêm mới lịch sử ảo thành công');
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
        $item = $this->virtualSpecialHistory->find($id);
        if (!$item) {
            abort(404);
        }
        $type = $item->type;
        $spins = [];
        if ($type == 'spin') {
            $spins = $this->spin->all();
        } elseif ($type == 'spin_coin') {
            $spins = $this->spinCoin->all();
        }
        return view('admin.virtual_history.special.edit', compact('item', 'type', 'spins'));
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
        $params = $request->all();
        $item = $this->virtualSpecialHistory->find($id);
        if (!$item) {
            abort(404);
        }
        $result = $item->update($params);
        if ($result) {
            return redirect(asset('admin/virtual-history-special/virtual-history-special'))->with('message', 'Sửa lịch sử ảo thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $item = $this->virtualSpecialHistory->find($id);
        if (!$item) {
            abort(404);
        }
        $item->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa lịch sử ảo thành công'
        ], 200);
    }
}
