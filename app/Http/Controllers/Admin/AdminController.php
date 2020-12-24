<?php

namespace App\Http\Controllers\Admin;

use App\Account;
use App\Charge;
use App\HistoryAccount;
use App\HistoryRandom;
use App\HistorySpin;
use App\Http\Controllers\Controller;
use App\RandomAccount;
use App\Transformer\Admin\AdminTransformer;
use App\User;
use Illuminate\Http\Request;
use DB;
use App\Admin;
use Auth;

class AdminController extends Controller
{
    private $historyAccount;
    private $historyRandom;
    private $historySpin;
    private $user;
    private $charge;
    private $admin;
    private $account;
    private $randomAccount;

    public function __construct(HistoryAccount $historyAccount, HistoryRandom $historyRandom, HistorySpin $historySpin, User $user, Charge $charge, Admin $admin, Account $account, RandomAccount $randomAccount)
    {
        $this->historyAccount = $historyAccount;
        $this->historyRandom = $historyRandom;
        $this->historySpin = $historySpin;
        $this->user = $user;
        $this->charge = $charge;
        $this->admin = $admin;
        $this->account = $account;
        $this->randomAccount = $randomAccount;
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        if ($admin->is_super == 1) {
            // get total account sell
            $total_account = $this->historyAccount->count();

            // get total account random sell
            $total_random = $this->historyRandom->count();

            // get total charge day success
            $charge_day = $this->charge
                ->where('status', 2)
                ->whereDate('created_at', '=', date('Y-m-d'))
                ->get();
            $total_day = 0;
            foreach ($charge_day as $charge) {
                $total_day += $charge->amount;
            }
            // get total charge month success
            $charge_month = $this->charge
                ->where('status', 2)
                ->whereMonth('created_at', '=', date('m'))
                ->get();
            $total_month = 0;
            foreach ($charge_month as $charge) {
                $total_month += $charge->amount;
            }

            $userDay = $this->user->whereDay('created_at', '=', date('Y-m-d'))->count();
            $users_last = $this->user->orderBy('id', 'desc')->offset(0)->limit(5)->get();

            return view('admin.dashboard', compact(
                'total_account',
                'total_random','total_day', 'total_month', 'users_last', 'userDay'));
        } else {
            // get total account sell
            $total_account = $this->account->where('author_id', $admin->id)->where('status', 1)->count();

            // get total account random sell
            $total_random = $this->randomAccount->where('author_id', $admin->id)->where('status', 2)->count();

            // thu nhập
            $total_day = Auth::guard('admin')->user()->income;
            // thực nhận
            $total_month = $total_day * 0.4;

            return view('admin.dashboard', compact(
                'total_account',
                'total_random','total_day', 'total_month'));
        }
    }

    public function list(Request $request)
    {
        try {
            if ($request->has('type') && $request->type === 'json') {
                $draw = $request->has('sEcho') ? $request->input('sEcho') : 1;
                $offset = $request->has('iDisplayStart') ? $request->input('iDisplayStart') : 0;
                $limit = $request->has('iDisplayLength') ? $request->input('iDisplayLength') : 10;
                $sSearch = $request->has('sSearch') ? $request->input('sSearch') : '';
                $admins = $this->admin
                    ->where('name', 'like', "%{$sSearch}%")
                    ->orWhere('username', 'like', "%{$sSearch}%")
                    ->offset($offset)->limit($limit)
                    ->get();
                $count = $this->admin
                    ->where('username', 'like', "%{$sSearch}%")
                    ->orWhere('username', 'like', "%{$sSearch}%")
                    ->count();
                $data = AdminTransformer::forDataTable($admins);
                return response()->json([
                    'draw' => $draw,
                    'recordsTotal' => $count,
                    'recordsFiltered' => $count,
                    'data' => $data
                ], 200);
            }
            return view('admin.manager.index');
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function create(Request $request)
    {
        try {
            $item = $this->admin->newInstance();
            return view('admin.manager.create', compact('item'));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function store(Request $request)
    {
        try {
            $params = $request->all();
            $params = AdminTransformer::forInsert($params);
            $admin = $this->admin->create($params);
            return redirect(asset('admin/list'));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $admin = $this->admin->find($id);
            $item = AdminTransformer::forEdit($admin);
            return view('admin.manager.edit', compact('item'));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $params = $request->all();
            if (array_key_exists('is_super', $params) && $params['is_super'] == 1) {
                $params['is_super'] = true;
            } else {
                $params['is_super'] = false;
            }
            $item = $this->admin->find($id);
            if (!$item) return redirect(asset(''));
            $result = $item->update($params);
            return redirect(asset('admin/list'));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $item = $this->admin->find($id);
            if (!$item) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lỗi, xin thử lại',
                    'text' => 'Xin mời thử lại'
                ]);
            }
            $item->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa Cộng tác viên thành công',
            ]);
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function checkUnique(Request $request)
    {
        try {
            $username = $request->has('username') ? $request->input('username') : '';
            $count = $this->admin->where('username', $username)->count();
            if ($count > 0) {
                return 'false';
            } else {
                return 'true';
            }
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function getChangePass(Request $request, $id)
    {
        try {
            $item = $this->admin->find($id);
            if (!$item) return redirect(asset(''));
            return view('admin.manager.change_pass', compact('item'));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function postChangePass(Request $request, $id)
    {
        try {
            $params = $request->all();
            if ($request->password !== $request->passwordConfirm) {
                return redirect(asset(''));
            }
            $item = $this->admin->find($id);
            $item->update([
                'password' => bcrypt($params['password'])
            ]);
            return redirect(asset('admin/list'));
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }

    public function resetIncome(Request $request, $id)
    {
        try {
            $item = $this->admin->find($id);
            if (!$item) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lỗi, xin thử lại',
                    'text' => 'Xin mời thử lại'
                ]);
            }
            $item->update([
                'income' => 0
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Reset thu nhập cho CTV thành công.',
            ]);
        } catch (\Exception $e) {
            echo '<pre>';
            print_r($e->getMessage());
            echo '</pre>';
        }
    }
}
