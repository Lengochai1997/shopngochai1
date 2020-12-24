<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Transformer\Wallet\WalletTransformer;
use App\Wallet;
use App\WalletHistory;
use Illuminate\Http\Request;

class HistoryResourceController extends Controller
{

    private $walletHistory;
    private $wallet;

    public function __construct(WalletHistory $walletHistory, Wallet $wallet)
    {
        $this->walletHistory = $walletHistory;
        $this->wallet = $wallet;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $type = $request->has('type') ? $request->input('type') : '';
        $status = $request->has('status') ? $request->input('status') : null;
        $histories = $this->walletHistory
            ->where(function ($query) use ($status) {
                if ($status !== null) {
                    $query->where('status', $status);
                }
            })
            ->where(function ($query) use ($type) {
                if ($type != '') {
                    $query->where('coin_type', $type);
                }
            })
            ->orderBy('id', 'desc')
            ->offset($offset)->limit($limit)
            ->get();
        $count = $this->walletHistory
            ->where(function ($query) use ($status) {
                if ($status !== null) {
                    $query->where('status', $status);
                }
            })
            ->where(function ($query) use ($type) {
                if ($type != '') {
                    $query->where('coin_type', $type);
                }
            })
            ->orderBy('id', 'desc')
            ->count();
        $data = WalletTransformer::forDashboard($histories);
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
}
