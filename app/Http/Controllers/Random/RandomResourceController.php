<?php

namespace App\Http\Controllers\Random;

use App\Http\Controllers\Controller;
use App\Random;
use App\Transformer\Random\RandomTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RandomResourceController extends Controller
{
    private $random;

    public function __construct(Random $random)
    {
        $this->random = $random;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.random.index');
    }

    public function list(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $countTable = DB::table('randoms')->count();
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $randoms = $this->random->where('title', 'like', "%{$sSearch}%")->offset($offset)->limit($limit)->get();
        $data = RandomTransformer::forDataTables($randoms);
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
        $item = $this->random->newInstance();
        return view('admin.random.create', compact('item'));
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
        $attr = RandomTransformer::forDatabase($attr);
        $result = $this->random->create($attr);
        return response()->json([
            'message' => 'Thêm mới thành công',
            'status' => 'success'
        ], 200);
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
        $item = $this->random->find($id);
        return view('admin.random.edit', compact('item'));
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
        $attr = RandomTransformer::forDatabase($attr);
        $item = $this->random->find($id);
        $result = $item->update($attr);
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
        $item = $this->random->find($id);
        $item->delete();
        return response()->json([
            'message' => trans('message.success.deleted', ['Module' => 'Random']),
            'status' => 'success'
        ], 200);
    }

    public function listAccount($id = '')
    {
        $randoms = $this->random->all();
        if (count($randoms) > 0) {
            $random = $id != '' ? $this->random->find($id) : $randoms[0];
            return view('admin.random.account', compact('random', 'randoms'));
        }
        return abort(404);
    }
}
