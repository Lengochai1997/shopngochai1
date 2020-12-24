<?php

namespace App\Http\Controllers\Star;

use App\FlipCard;
use App\Http\Controllers\Controller;
use App\SlotMachine;
use App\Star;
use App\Transformer\Star\StarTransformer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class StarResourceController extends Controller
{

    private $star;
    private $slotMachine;
    private $flipCard;

    public function __construct(Star $star, SlotMachine $slotMachine, FlipCard $flipCard)
    {
        $this->star = $star;
        $this->slotMachine = $slotMachine;
        $this->flipCard = $flipCard;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        $type_id = $request->input('type_id');
        return view('admin.star.index', compact( 'type', 'type_id'));
    }

    public function list(Request $request)
    {
        $type = $request->input('type');
        $type_id = $request->input('type_id');

        // load list star by type_id
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $stars = $this->star
            ->where('type', $type)
            ->where('type_id', $type_id)
            ->where('user_id', 'like', "%{$sSearch}%")
            ->offset($offset)->limit($limit)
            ->get();
        $count = $this->star
            ->where('type', $type)
            ->where('type_id', $type_id)
            ->where('user_id', 'like', "%{$sSearch}%")
            ->count();
        $data = StarTransformer::forDatatable($stars);
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
     * @return Application|Factory|Response|View
     */
    public function create(Request $request)
    {
        $type = $request->type;
        $type_id = $request->type_id;

        if ($type == 'slot_machine') {
            $slot_machine = $this->slotMachine->find($type_id);
            $slots = json_decode($slot_machine->slots, true);
            return view('admin.star.create', compact('type', 'type_id', 'slots'));
        }
        if ($type == 'flip_card') {
            $flipCard = $this->flipCard->find($type_id);
            $slots = json_decode($flipCard->slots, true);
            return view('admin.star.create', compact('type', 'type_id', 'slots'));
        }
        return view('admin.star.create', compact('type', 'type_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $params = $request->all();
            $type = $params['type'];
            $type_id = $params['type_id'];
            $ids = explode('|', $params['ids']);
            // check id
            if (!$ids) {
                return redirect()->back();
            }
            $value = $params['value'];
            // value
            foreach ($ids as $id) {
                $star = $this->star
                    ->where('type', $type)
                    ->where('type_id', $type_id)
                    ->where('user_id', $id)
                    ->first();
                if ($star != null) {
                    $star->update([
                        'value' => json_encode($value)
                    ]);
                } else {
                    $tmp = [
                        'type' => $type,
                        'type_id' => $type_id,
                        'user_id' => $id,
                        'value' => json_encode($value)
                    ];
                    $this->star->create($tmp);
                }
            }
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $item = $this->star->find($id);
        if (!$item) {
            return abort(404);
        }
        $item = $item->toArray();
        $item['value'] = json_decode($item['value'], true);

        if ($item['type'] == 'slot_machine') {
            $slot_machine = $this->slotMachine->find($item['type_id']);
            $slots = json_decode($slot_machine->slots, true);
            return view('admin.star.edit', compact('item', 'slots'));
        }

        return view('admin.star.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $item = $this->star->find($id);
        if (!$item) {
            return abort(404);
        }
        $value = $request->input('value');
        $item->update([
            'value' => json_encode($value)
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $star = $this->star->find($id);
        if (!$star) {
            return response()->json([
                'status' => 'error',
                'message' => 'Có lỗi'
            ], 400);
        }
        $star->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Xóa thành công'
        ], 200);
    }

    public function addSpinStar(Request $request, $id)
    {

    }

    public function addSpinCoinStar($id)
    {
        echo $id;
    }

    public function addSlotMachineStar($id)
    {
        echo $id;
    }
}
