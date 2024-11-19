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
}