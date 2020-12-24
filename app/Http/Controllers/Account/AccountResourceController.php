<?php

namespace App\Http\Controllers\Account;

use App\Account;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Transformer\Account\AccountTransformer;
use App\Transformer\FreeFire;
use App\Transformer\Game\ArenaValor;
use App\Transformer\Select2\Select2;
use Illuminate\Http\Request;
use Auth;

class AccountResourceController extends Controller
{
    private $account;
    private $category;
    public function __construct(Account $account, Category $category)
    {
        $this->account = $account;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AccountRequest $request)
    {
        return view('admin.account.index');
    }

    public function list(AccountRequest $request)
    {
        $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
        $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
        $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
        $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
        $status = $request->has('status') ? $request->input('status') : 0;

        $accounts = $this->account
            ->where(function ($query) {
                $admin = Auth::guard('admin')->user();
                if ($admin->is_super != 1) {
                    $query->where('author_id', $admin->id);
                }
            })
            ->where(function ($query) use ($status) {
                if ($status != "") {
                    $query->where('status', $status);
                }
            })
            ->where('username', 'like', "%{$sSearch}%")
            ->offset($offset)->limit($limit)
            ->get();
        $count = $this->account
            ->where(function ($query) {
                $admin = Auth::guard('admin')->user();
                if ($admin->is_super != 1) {
                    $query->where('author_id', $admin->id);
                }
            })
            ->where(function ($query) use ($status) {
                if ($status != "") {
                    $query->where('status', $status);
                }
            })
            ->where('username', 'like', "%{$sSearch}%")
            ->count();
        $data = AccountTransformer::forDataTable($accounts);
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
    public function create(Request $request)
    {
        $type = $request->has('type') ? $request->input('type') : '1';
        $item = $this->account->newInstance();
        $categories = $this->category->all()->toArray();
        $categories = Select2::createForSelect2($categories, 'title');
        return view('admin.account.create', compact('item', 'categories', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRequest $request)
    {
        $attr = $request->all();
        if ($request->input('type_id') == '1') {
            $attr = ArenaValor::forDatabase($attr);
        } elseif ($request->input('type_id') == '2') {
            $attr = FreeFire::forDatabase($attr);
        }
        $account = $this->account->create($attr);
        plusCountAccount($attr['category_id']);
        if ($account) {
            return redirect(asset('admin/account/account'));
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
        $categories = $this->category->all()->toArray();
        $categories = Select2::createForSelect2($categories, 'title');
        $account = $this->account->find($id)->toArray();
        $admin = Auth::guard('admin')->user();
        if ($admin->is_super == 0 && $admin->id != $account['author_id']) {
            return abort(401);
        }
        $item = [];
        if ($account['type_id'] == 1) {
            $item = ArenaValor::forEdit($account);
        }
        if ($account['type_id'] == 2) {
            $item = FreeFire::forEdit($account);
        }
        $type = $account['type_id'];
        return view('admin.account.edit', compact('item', 'categories', 'type'));
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
        if ($request->input('type_id') == '1') {
            $attr = ArenaValor::forDatabase($attr);
        } elseif ($request->input('type_id') == '2') {
            $attr = FreeFire::forDatabase($attr);
        }
        $account = $this->account->find($id);
        $admin = Auth::guard('admin')->user();
        if ($admin->is_super == 0 && $admin->id != $account->author_id) {
            return abort(401);
        }
        $result = $account->update($attr);
        if ($request) {
            return redirect(asset('admin/account/account'));
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
        $account = $this->account->find($id);
        $admin = Auth::guard('admin')->user();
        if ($admin->is_super == 0 && $admin->id != $account->author_id) {
            return abort(401);
        }
        $account->delete();
        return response()->json([
            'message' => trans('message.success.deleted', ['Module' => trans('account::account.name')]),
            'status' => 'success'
        ], 200);
    }


    public function getType(Request $request, $id, $accountId = null)
    {
        try {
            if ($accountId === null) {
                $item = $this->account->newInstance();
            } else {
                $account = $this->account->find($id)->toArray();
                $item = AccountTransformer::forEdit($account);
            }
            $view = 'admin.account.types.'.$id;
            return view($view, compact('item'));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi, xin thử lại',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
