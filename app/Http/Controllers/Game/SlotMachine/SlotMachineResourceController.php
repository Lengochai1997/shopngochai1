<?php

namespace App\Http\Controllers\Game\SlotMachine;

use App\Http\Controllers\Controller;
use App\SlotMachine;
use App\Transformer\SlotMachine\SlotMachineTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlotMachineResourceController extends Controller
{
    private $slotMachine;

    public function __construct(SlotMachine $slotMachine)
    {
        $this->slotMachine = $slotMachine;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->has('type') && $request->input('type') == 'json') {
            $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
            $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
            $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
            $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';

            $accounts = $this->slotMachine
                ->where('title', 'like', "%{$sSearch}%")
                ->offset($offset)->limit($limit)
                ->get();
            $count = $this->slotMachine
                ->where('title', 'like', "%{$sSearch}%")
                ->count();
            $data = SlotMachineTransformer::forDataTable($accounts);
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $count,
                'recordsFiltered' => $count,
                'data' => $data
            ], 200);
        }
        return view('admin.game.slot_machine.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $view = 'admin.game.slot_machine.create';
        $model = $request->has('model') ? $request->input('model') : 'normal';
        $item = $this->slotMachine->newInstance();
        return view($view, compact('item', 'model'));
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
            $item = SlotMachineTransformer::forInsert($params);
            $result = $this->slotMachine->create($item);
            if ($result) {
                return redirect(asset('admin/slot-machine/slot-machine'));
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
        try {
            $item = $this->slotMachine->find($id);
            $model = $item->model;
            if ($item) {
                $item = SlotMachineTransformer::forEdit($item);
                return view('admin.game.slot_machine.edit', compact('item', 'model'));
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $params = $request->all();
            $params = SlotMachineTransformer::forInsert($params);
            $item = $this->slotMachine->find($id);
            if (!$item) {
                return false;
            }
            $item->update($params);
            return redirect(asset('admin/slot-machine/slot-machine'));
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
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $item = $this->slotMachine->find($id);
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
