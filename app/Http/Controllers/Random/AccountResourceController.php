<?php

namespace App\Http\Controllers\Random;

use App\Http\Controllers\Controller;
use App\RandomAccount;
use App\Transformer\Random\AccountTransformer;
use Illuminate\Http\Request;
use Auth;

class AccountResourceController extends Controller
{
    private $randomAccount;

    public function __construct(RandomAccount $randomAccount)
    {
        $this->randomAccount = $randomAccount;
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
        $status = $request->has('status') ? $request->input('status') : null;
        $random_id = $request->has('random_id') ? $request->input('random_id') : null;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $accounts = $this->randomAccount
            ->where(function ($query) {
                $admin = Auth::guard('admin')->user();
                if ($admin->is_super != 1) {
                    $query->where('author_id', $admin->id);
                }
            })
            ->where(function ($query) use ($random_id) {
                if ($random_id !== null && $random_id !== '') {
                    $query->where('random_id', $random_id);
                }
            })
            ->where(function ($query) use ($status) {
                if ($status !== null && $status !== '') {
                    $query->where('status', $status);
                }
            })
            ->where('username', 'like', "%{$sSearch}%")
            ->offset($offset)->limit($limit)
            ->get();
        $data = AccountTransformer::forDataTables($accounts);
        $count = $this->randomAccount
            ->where(function ($query) {
                $admin = Auth::guard('admin')->user();
                if ($admin->is_super != 1) {
                    $query->where('author_id', $admin->id);
                }
            })
            ->where(function ($query) use ($random_id) {
                if ($random_id !== null && $random_id !== '') {
                    $query->where('random_id', $random_id);
                }
            })
            ->where(function ($query) use ($status) {
                if ($status !== null && $status !== '') {
                    $query->where('status', $status);
                }
            })
            ->where('username', 'like', "%{$sSearch}%")
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
        $random_id = $request->input('random_id');
        $accounts = $request->input('accounts');
        $accounts = preg_split('/\n|\r\n?/', $accounts);
        if (count($accounts) > 0) {
            $admin = Auth::guard('admin')->user();
            $author_id = $admin->is_super == 0 ? $admin->id : 0;
            $countAccount = 0;
            foreach ($accounts as $account) {
                $temp = explode('|', $account);
                $attr = [
                    'random_id' => $random_id,
                    'username' => $temp[0],
                    'password' => isset($temp[1]) ? $temp[1] : '',
                    'author_id' => $author_id,
                    'code' => isset($temp[2]) ? $temp[2] : '',
                ];
                $this->randomAccount->create($attr);
                $countAccount++;
            }
            // plus count account in randoms
            plusRandomAccount($random_id, $countAccount);
        }
        return response()->json([
            'message' => 'Thêm tài khoản thành công',
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
        $account = $this->randomAccount->find($id);
        $admin = Auth::guard('admin')->user();
        if ($admin->is_super == 0 && $admin->id != $account->author_id) {
            return abort(401);
        }
        return view('admin.random.edit_account', compact('account'));
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
        $account = $this->randomAccount->find($id);
        $admin = Auth::guard('admin')->user();
        if ($admin->is_super == 0 && $admin->id != $account->author_id) {
            return abort(401);
        }
        $account->update($attr);
        return redirect(asset('admin/random/list-account/'.$account->random_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = $this->randomAccount->find($id);
        $admin = Auth::guard('admin')->user();
        if ($admin->is_super == 0 && $admin->id != $account->author_id) {
            return abort(401);
        }
        $account->delete();
        return response()->json([
            'message' => trans('message.success.deleted', ['Module' => 'Tài khoản']),
            'status' => 'success'
        ], 200);
    }

}
