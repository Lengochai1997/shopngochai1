<?php

namespace App\Http\Controllers\Category;

use App\Account;
use App\Category;
use App\HistoryAccount;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\ImgurService;
use App\Services\UploadFile;
use Illuminate\Http\Request;

class CategoryResourceController extends Controller
{
    private $category;
    private $account;
    private $historyAccount;

    public function __construct(Category $category, Account $account, HistoryAccount $historyAccount)
    {
        $this->category = $category;
        $this->account = $account;
        $this->historyAccount = $historyAccount;
    }

    public function index()
    {
        $categories = $this->category->paginate(15);
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $item = $this->category->newInstance();
        return view('admin.category.create', compact('item'));
    }

    public function store(CategoryRequest $request)
    {
        $attr = $request->all();
        $category = [
            'title' => $attr['title'],
            'key' => $attr['key'],
            'description' => $attr['description'],
        ];
        if (array_key_exists('images', $attr)) {
            $category['images'] = UploadFile::uploadFromPublic($attr['images'], 'images');
        }
        $result = $this->category->create($category);
        return response()->json([
            'message' => 'Cập nhật thành công',
            'status' => 'success'
        ], 200);

    }

    public function show()
    {

    }

    public function edit($id)
    {
        $item = $this->category->find($id);
        return view('admin.category.edit', compact('item'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $attr = $request->all();
        $newCategory = [
            'title' => $request->has('title') ? $request->input('title') : '',
            'key' => $request->has('key') ? $request->input('key') : '',
            'description' => $request->has('description') ? $request->input('description') : '',
        ];
        if (array_key_exists('images', $attr)) {
            $newCategory['images'] = UploadFile::uploadFromPublic($attr['images'], 'images');
        }
        $category = $this->category->find($id);
        $category->update($newCategory);
        return response()->json([
            'message' => 'Cập nhật thành công',
            'status' => 'success'
        ], 200);
    }

    public function destroy($id)
    {
        $category = $this->category->find($id);
        // delete category
        $category->delete();
        // get account by category
        $accounts = $this->account->where('category_id', $id)->get();
        $deletes = [];
        foreach ($accounts as $account) {
            array_push($deletes, $account->id);
            // delete account by category id
            $account->delete();
        }
        // delete account history
        $this->historyAccount->whereIn('account_id', $deletes)->delete();
        return response()->json([
            'message' => 'Xóa thành công',
            'status' => 'success'
        ], 200);
    }
}
