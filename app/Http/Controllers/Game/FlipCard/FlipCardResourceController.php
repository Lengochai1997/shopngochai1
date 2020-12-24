<?php

namespace App\Http\Controllers\Game\FlipCard;

use App\FlipCard;
use App\Http\Controllers\Controller;
use App\Transformer\FlipCard\FlipCardTransformer;
use Illuminate\Http\Request;

class FlipCardResourceController extends Controller
{
    private $flipCard;
    private $flipCardTransformer;

    public function __construct(FlipCard $flipCard, FlipCardTransformer $flipCardTransformer)
    {
        $this->flipCard = $flipCard;
        $this->flipCardTransformer = $flipCardTransformer;
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

            $items = $this->flipCard
                ->where('title', 'like', "%{$sSearch}%")
                ->offset($offset)->limit($limit)
                ->get();
            $count = $this->flipCard
                ->where('title', 'like', "%{$sSearch}%")
                ->count();
            $data = $this->flipCardTransformer->forDataTable($items);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ], 200);
        }
        return view('admin.game.flip_card.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = $this->flipCard->newInstance();
        return view('admin.game.flip_card.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $params = $request->all();
            $params = $this->flipCardTransformer->forInsert($params);
            $result = $this->flipCard->create($params);
            if ($result) {
                return redirect(asset('admin/flip-card/flip-card'));
            }
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
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
        $item = $this->flipCard->find($id);
        if (!$item) return abort(404);
        $item = $this->flipCardTransformer->forEdit($item);
        return view('admin.game.flip_card.edit', compact('item'));
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
        try {
            $params = $request->all();
            $params = $this->flipCardTransformer->forInsert($params);
            $item = $this->flipCard->find($id);
            if (!$item) {
                return abort(404);
            }
            $item->update($params);
            return redirect(asset('admin/flip-card/flip-card'));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->flipCard->find($id);
            if (!$item) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error'
                ], 404);
            }
            $item->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công'
            ], 200);
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }
}
