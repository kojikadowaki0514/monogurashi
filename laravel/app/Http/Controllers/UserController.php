<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function deleteAccount(Request $request)
    {
        $user = Auth::user();

        // トランザクションを開始
        \DB::transaction(function () use ($user) {
            // items に関連付けられたタグを削除
            $user->items()->each(function ($item) {
                $item->tags()->detach(); // 中間テーブルの削除
            });
        
            // tags テーブルから不要なタグを削除
            $user->tags()->delete();
        
            // 他のリレーションも削除
            $user->categories()->delete();
            $user->notifications()->delete();
            $user->groups()->detach();
            $user->delete();
        });
                

        // ログアウトしてリダイレクト
        Auth::logout();

        return redirect('login')->with('success', '退会処理が完了しました。');
    }
}
