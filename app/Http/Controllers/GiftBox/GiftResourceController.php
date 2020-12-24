<?php

namespace App\Http\Controllers\GiftBox;

use App\Box;
use App\Gift;
use App\Http\Controllers\Controller;
use App\Transformer\Gift\GiftTransformer;
use Illuminate\Http\Request;

class GiftResourceController extends Controller
{
    private $gift;
    private $box;

    public function __construct(Gift $gift, Box $box)
    {
        $this->gift = $gift;
        $this->box = $box;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('type') && $request->input('type') == 'json') {
                $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
                $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
                $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
                $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';

                $accounts = $this->gift
                    ->where('title', 'like', "%{$sSearch}%")
                    ->offset($offset)->limit($limit)
                    ->get();
                $count = $this->gift
                    ->where('title', 'like', "%{$sSearch}%")
                    ->count();
                $data = GiftTransformer::forDataTable($accounts);
                return response()->json([
                    'draw' => $draw,
                    'recordsTotal' => $count,
                    'recordsFiltered' => $count,
                    'data' => $data
                ], 200);
            }
            return view('admin.gift_box.index');
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $item = $this->gift->newInstance();
            return view('admin.gift_box.create', compact('item'));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
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
            $params = GiftTransformer::forDatabase($params);
            $item = $this->gift->create($params);
            if ($item) {
                return redirect(asset('admin/gift-box/gift'));
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
        try {
            $item = $this->gift->find($id);
            if ($item) {
                return view('admin.gift_box.edit', compact('item'));
            }
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
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
            $item = $this->gift->find($id);
            if ($item) {
                $params = GiftTransformer::forDatabase($params);
                $item->update($params);
                return redirect(asset('admin/gift-box/gift'));
            }
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
            $item = $this->gift->find($id);
            if ($item) {
                $item->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Xóa thành công danh mục'
                ], 200);
            }
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function listBoxes(Request $request, $id)
    {
        try {
            $items = $this->gift->all();
            $item = $this->gift->find($id);
            if ($item) {
                return view('admin.gift_box.boxes', compact('item', 'items'));
            }
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function gift(Request $request, $id)
    {
        try {
            $gift = $this->gift->find($id);
            if (!$gift) {
                return redirect(asset(''));
            }
            $boxes = $this->box->where('gift_id', $id)->where('status', 0)->paginate();
            return view('gift.list_box', compact('boxes', 'gift'));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }
}
