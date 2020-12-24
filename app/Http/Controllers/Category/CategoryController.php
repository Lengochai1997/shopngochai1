<?php

namespace App\Http\Controllers\Category;

use App\Account;
use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $category;
    private $account;

    public function __construct(Category $category, Account $account)
    {
        $this->category = $category;
        $this->account = $account;
    }

    public function getAccountByCategory(Request $request, $key, $up = 0, $down = 0, $id = '')
    {
        $category = $this->category->where('key', $key)->first();
        if ($category === null) {
            return abort(404);
        }
        if ($down !== 0 && $up !== 0) {
            $accounts = $this->account
                ->where('category_id', $category->id)
                ->where('price', '>=', $up)
                ->where('price', '<=', $down)
                ->where('id', 'like', "%{$id}%")
                ->where('status', 0)
                ->paginate(12);
        } else {
            $accounts = $this->account
                ->where('category_id', $category->id)
                ->where('id', 'like', "%{$id}%")
                ->where('status', 0)
                ->paginate(12);
        }
        return view('category.list_account', compact('key', 'category', 'accounts'));
    }
}
