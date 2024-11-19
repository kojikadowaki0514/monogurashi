<header class="w-full text-white py-4" style="background-color: #0098ad;">
    <div class="max-w-8xl mx-auto flex justify-between items-center" style="padding: 0 20px;">
        <!-- 左側: ロゴ -->
        <h1 class="text-lg font-bold text-left" style="font-size: 25px;">モノ暮らし</h1>
        
        <!-- 右側: ユーザー情報とナビゲーション -->
        <div class="flex items-center space-x-4">
            <!-- ユーザー名 -->
            @auth
                <!-- ログインしている場合はユーザー名を表示 -->
                <span class="text-white font-semibold">{{ Auth::user()->name }} さん</span>
            @else
                @if(Route::currentRouteName() !== 'login')
                    <!-- ログインしていない & 現在のページがログインページでない場合のみリンクを表示 -->
                    <a href="{{ route('login') }}" class="text-white hover:underline">ログイン</a>
                @endif
            @endauth
        </div>
    </div>
</header>
