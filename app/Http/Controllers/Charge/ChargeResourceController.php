<?php

namespace App\Http\Controllers\Charge;

use App\Charge;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Transformer\Charge\ChargeTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChargeResourceController extends Controller
{
    private $charge;
    private $user;

    public function __construct(Charge $charge, User $user)
    {
        $this->charge = $charge;
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function list(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $status = $request->has('status') ? intval($request->input('status')) : null;
        $type_id = $request->has('type_id') ? intval($request->input('type_id')) : 1;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $charges = $this->charge
            ->join('payments', 'charges.payment_id', 'payments.id')
            ->join('users', 'charges.user_id', '=', 'users.id')
            ->select('charges.*', 'payments.type_id')
            ->where('payments.type_id', $type_id)
            ->where(function ($query) use ($status) {
                if($status != null){
                    $query->where('charges.status', $status);
                }
            })
            ->where(function ($query) use ($sSearch) {
                if ($sSearch != '') {
                    $query->where('charges.pin', 'like', "%{$sSearch}%")
                        ->orWhere('charges.serial', 'like', "%{$sSearch}%")
                        ->orWhere('users.id', 'like', "%{$sSearch}%")
                        ->orWhere('users.username', 'like', "%{$sSearch}%")
                        ->orWhere('users.name', 'like', "%{$sSearch}%");
                }
            })
            ->orderBy('charges.id', 'desc')
            ->offset($offset)->limit($limit)
            ->get();
        $data = ChargeTransformer::forDataTable($charges);
        $count = $charges = $this->charge
            ->join('payments', 'charges.payment_id', 'payments.id')
            ->select('charges.*', 'payments.type_id')
            ->where('payments.type_id', $type_id)
            ->where('charges.pin', 'like', "%{$sSearch}%")
            ->where('charges.serial', 'like', "%{$sSearch}%")
            ->where(function ($query) use ($status) {
                if($status != null){
                    $query->where('charges.status', $status);
                }
            })
            ->orderBy('charges.id', 'desc')
            ->count();
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function approved()
    {
        return view('admin.payment.approved');
    }

    public function cardTrue($id)
    {
        $charge = $this->charge->find($id);
        if (!$charge) {
            return response()->json([
                'message' => 'Thao tác không hợp lệ.',
                'status' => 'error'
            ], 500);
        }
        $charge->update([
            'status' => 2
        ]);

        $percent = $charge->payment->percent;
        $amount = $charge->amount * ($percent/100);
        UserService::plusMoney($charge->user_id, $amount);
        appendTopCharge($charge->user_id, $charge->amount);
        return response()->json([
            'message' => 'Thao tác hợp lệ.',
            'status' => 'success'
        ], 200);
    }

    public function cardFalse($id)
    {
        $charge = $this->charge->find($id);
        if (!$charge) {
            return response()->json([
                'message' => 'Thao tác không hợp lệ.',
                'status' => 'error'
            ], 500);
        }
        $charge->update([
            'status' => 3
        ]);
        return response()->json([
            'message' => 'Thao tác hợp lệ.',
            'status' => 'success'
        ], 200);
    }
}
