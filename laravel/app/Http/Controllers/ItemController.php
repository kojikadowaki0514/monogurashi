<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Item;
use App\Models\Category;


class ItemController extends Controller
{
    public function create()
    {
        return view('items.create');
    }

    public function saveToSession(Request $request)
    {   
        // ファイルを処理
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // ファイルを指定のディレクトリに保存してそのパスを取得
            $filePath = $file->store('uploads/item_images', 'public'); // 保存先: public/uploads/item_images

            // セッションに画像パスを保存
            Session::put('item_image', $filePath);
        }

        // その他のデータをセッションに保存
        Session::put('product_name', $request->input('product_name', ''));
        Session::put('location', $request->input('location', ''));
        Session::put('notes', $request->input('notes', ''));

        // カテゴリー登録画面にリダイレクト
        return redirect()->route('category-tag.create');
    }

    public function store(Request $request)
    {
        // 認証済みユーザーを取得
        $userId = Auth::id();

        // カテゴリーidを取得
        $categoryId = $request->query('category_id');
        
        // データを保存
        $item = new Item();
        $item->user_id = $userId; // ユーザーid
        $item->category_id = $categoryId; // カテゴリーid
        $item->item_name = $request->input('product_name'); // 持ち物名
        $item->location = $request->input('location'); // 保管場所
        $item->save();

        // リダイレクト
        // return redirect()->route('dashboad');
    }

    // 全ての持ち物の検索
    public function search(Request $request)
    {
        // 検索キーワードを取得
        $keyword = $request->input('search_term');
        $categoryId = $request->input('category_id');

        // 検索処理
        $items = Item::query()
        ->when($keyword, function ($query) use ($keyword) {
            $query->where('item_name', 'LIKE', "%{$keyword}%");
        })
        ->when($categoryId, function ($query) use ($categoryId) {
            $query->where('category_id', $categoryId);
        })
        ->where('user_id', auth()->id()) // ログインユーザー限定
        ->with('category') // カテゴリーも取得
        ->paginate(5); // ページネーション

        // アイテムに紐づくカテゴリを取得（重複を除く）
        $categories = Category::whereHas('items', function ($query) use ($items) {
            $query->whereIn('id', $items->pluck('id')); // 検索結果に基づくカテゴリを取得
        })->get();

        // 検索結果をビューに渡す
        return view('all_item_search', compact('items', 'categories', 'keyword', 'categoryId'));
    }
}