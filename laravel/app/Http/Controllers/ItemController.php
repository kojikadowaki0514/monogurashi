<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Item;


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
}