<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function create()
    {
        // 持ち物登録画面を返す
        return view('items.create');
    }

    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // 新しい持ち物を作成
        Item::create([
            'name' => $request->name,
        ]);

        // リダイレクト
        return redirect()->route('dashboad');
    }
}