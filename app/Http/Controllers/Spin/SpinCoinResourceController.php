<?php

namespace App\Http\Controllers\Spin;

use App\Http\Controllers\Controller;
use App\SpinCoin;
use App\Transformer\Spin\SpinTransformer;
use Illuminate\Http\Request;

class SpinCoinResourceController extends Controller
{
    private $spinCoin;
    public function __construct(SpinCoin $spinCoin)
    {
        $this->spinCoin = $spinCoin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.spin_coin.index');
    }

    public function list(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $accounts = $this->spinCoin->where('title', 'like', "%{$sSearch}%")->offset($offset)->limit($limit)->get();
        $count = $this->spinCoin->where('title', 'like', "%{$sSearch}%")->count();
        $data = SpinTransformer::forDataTables($accounts);
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
    public function create(Request $request)
    {
        $item = $this->spinCoin->newInstance();
        $type = '';
        if ($request->has('type') && $request->input('type') == 'kimcuong') {
            $type = 'kimcuong';
        }
        if ($request->has('type') && $request->input('type') == 'quanhuy') {
            $type = 'quanhuy';
        }
        return view('admin.spin_coin.create', compact('item', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attr = $request->all();
        $attr = SpinTransformer::forDatabase($attr);
        $result = $this->spinCoin->create($attr);
        if ($result) {
            return redirect(asset('admin/spin/coin'));
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
        $item = $this->spinCoin->find($id);
        $item = SpinTransformer::forForm($item);
        return view('admin.spin_coin.edit', compact('item'));
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
        $attr = $request->all();
        $spin = $this->spinCoin->find($id);
        $attr = SpinTransformer::forDatabase($attr);
        $spin->update($attr);
        return response()->json([
            'message' => 'Cập nhật thành công',
            'status' => 'success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $spin = $this->spinCoin->find($id);
        $spin->delete();
        return response()->json([
            'message' => trans('message.success.deleted', ['Module' => 'Vòng quay']),
            'status' => 'success'
        ], 200);
    }
}
