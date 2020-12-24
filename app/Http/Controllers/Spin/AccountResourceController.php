<?php

namespace App\Http\Controllers\Spin;

use App\Http\Controllers\Controller;
use App\Spin;
use App\SpinAccount;
use App\Transformer\Spin\AccountTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;

class AccountResourceController extends Controller
{
    private $spinAccount;
    private $spin;

    public function __construct(SpinAccount $spinAccount, Spin $spin)
    {
        $this->spinAccount = $spinAccount;
        $this->spin = $spin;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $countTable = DB::table('spin_accounts')->count();
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $type_id = $request->has('type_id') ? $request->input('type_id') : '';
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        if ($type_id === '') {
            $accounts = $this->spinAccount->where('username', 'like', "%{$sSearch}%")->offset($offset)->limit($limit)->get();
        } else {
            $accounts = $this->spinAccount->where('username', 'like', "%{$sSearch}%")->where('type_id', $type_id)->offset($offset)->limit($limit)->get();
        }
        $data = AccountTransformer::forDataTables($accounts);
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
        $spin_id = $request->input('spin_id');
        $type_id = $request->input('type_id');
        $accounts = $request->input('accounts');
        $accounts = preg_split('/\n|\r\n?/', $accounts);
        if (count($accounts) > 0) {
            foreach ($accounts as $account) {
                $temp = explode('|', $account);
                $attr = [
                    'spin_id' => $spin_id,
                    'type_id' => $type_id,
                    'username' => $temp[0],
                    'password' => $temp[1]
                ];
                $this->spinAccount->create($attr);
            }
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
        $account = $this->spinAccount->find($id);
        $spin = $this->spin->find($account->spin_id);
        $properties = json_decode($spin->properties, true);
        return view('admin.spin.edit_account', compact('account', 'properties'));
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
        $account = $this->spinAccount->find($id);
        $account->update($attr);
        return redirect(asset('admin/spin/list-account/'.$account->spin_id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = $this->spinAccount->find($id);
        $account->delete();
        return response()->json([
            'message' => trans('message.success.deleted', ['Module' => 'Tài khoản']),
            'status' => 'success'
        ], 200);
    }
}
