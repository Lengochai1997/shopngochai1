<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Transformer\User\UserTransformer;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserResourceController extends Controller
{
    private $user;
    private $wallet;

    public function __construct(User $user, Wallet $wallet)
    {
        $this->user = $user;
        $this->wallet = $wallet;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->paginate(15);
        return view('admin.user.index', compact('users'));
    }

    public function list(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $countTable = DB::table('users')->count();
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $accounts = $this->user
            ->where('is_supper_admin', 0)
            ->where('username', 'like', "%{$sSearch}%")
            ->orWhere('name', 'like', "%{$sSearch}%")
            ->offset($offset)->limit($limit)->get();
        $data = UserTransformer::forDataTable($accounts);
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
        $item = $this->user->find($id);
        $wallet = $this->wallet->where('user_id', $id)->first();
        return view('admin.user.edit', compact('item', 'wallet'));
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
        // update user
        $user = $this->user->find($id);
        $user->update($attr);
        // update wallet
        $kimcuong = $request->has('kimcuong') && $request->input('kimcuong') !== '' ? $request->input('kimcuong') : 0;
        $quanhuy = $request->has('quanhuy') && $request->input('quanhuy') !== '' ? $request->input('quanhuy') : 0;
        $wallet = $this->wallet->where('user_id', $id)->first();
        if ($wallet === null) {
            // create wallet
            $this->wallet->create([
                'user_id' => $id,
                'kimcuong' => $kimcuong,
                'quenhuy' => $quanhuy
            ]);
        } else {
            $wallet->update([
                'kimcuong' => $kimcuong,
                'quanhuy' => $quanhuy
            ]);
        }
        return redirect(asset('admin/user/user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->user->find($id);
        $user->delete();
        return response()->json([
            'message' => trans('message.success.deleted', ['Module' => 'Người dùng']),
            'status' => 'success'
        ], 200);
    }

    public function changePassword($id)
    {
        return view('admin.user.password', compact('id'));
    }

    public function doChangePassword(Request $request, $id)
    {
        $password = $request->input('password');
        $user = $this->user->find($id);
        $user->update([
            'password' => bcrypt($password)
        ]);
        return redirect(asset('admin/user/user'));
    }
}
