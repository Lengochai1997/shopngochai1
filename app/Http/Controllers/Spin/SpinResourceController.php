<?php

namespace App\Http\Controllers\Spin;

use App\Http\Controllers\Controller;
use App\Spin;
use App\Transformer\Spin\SpinTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpinResourceController extends Controller
{
    private $spin;
    public function __construct(Spin $spin)
    {
        $this->spin = $spin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.spin.index');
    }

    public function list(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $countTable = DB::table('spins')->count();
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $accounts = $this->spin->where('title', 'like', "%{$sSearch}%")->offset($offset)->limit($limit)->get();
        $data = SpinTransformer::forDataTables($accounts);
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $countTable,
            'recordsFiltered' => $countTable,
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
        $item = $this->spin->newInstance();
        return view('admin.spin.create', compact('item'));
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
        $result = $this->spin->create($attr);
        if ($result) {
            return redirect(asset('admin/spin/spin'));
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
        $item = $this->spin->find($id);
        $item = SpinTransformer::forForm($item);
        return view('admin.spin.edit', compact('item'));
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
        $spin = $this->spin->find($id);
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
        $spin = $this->spin->find($id);
        $spin->delete();
        return response()->json([
            'message' => trans('message.success.deleted', ['Module' => 'Vòng quay']),
            'status' => 'success'
        ], 200);
    }

    public function listAccount(Request $request, $id)
    {
        $spin = $this->spin->find($id);
        $properties = json_decode($spin->properties, true);
        return view('admin.spin.account', compact('spin', 'properties'));
    }
}
