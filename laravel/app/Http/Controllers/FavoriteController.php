<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function index()
    {
      // 現在のログインユーザーのお気に入りアイテムを取得
      $favoriteItems = auth()->user()->favorites()->paginate(10);

      // ビューに渡す
      return view('favorites.index', compact('favoriteItems'));
    }
}
