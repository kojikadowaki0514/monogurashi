<header class="w-full text-white py-1" style="background-color: #0098ad;">
    <div class="max-w-8xl mx-auto flex justify-between items-center" style="padding: 0 20px;">
        <!-- 左側: ロゴ -->
        <a href="{{ route('dashboard') }}" 
            class="text-lg font-bold text-left hover:text-orange-300 transition duration-300" 
            style="font-size: 25px; text-decoration: none;">
            モノ暮らし
        </a>
        
        <!-- 右側: ユーザー情報とナビゲーション -->
        <div class="flex items-center relative right-10">
        @auth
            <!-- ユーザーアイコンと名前 -->
            <div class="flex flex-col items-center relative">
                <!-- ユーザーアイコン -->
                <button id="user-menu-button" class="flex items-center focus:outline-none">
                    <img style="width: 2.5rem !important; height: 2.5rem !important; object-fit: cover; border-radius: 9999px;"
                        src="{{ Auth::user()->user_icon ? asset(Auth::user()->user_icon) : asset('images/users/user_icon.jpg') }}" 
                        alt="User Icon" 
                        class="w-10 h-10 object-cover rounded-full">
                </button>

                <!-- ユーザー名 -->
                <span class="mt-2 text-white font-semibold">{{ Auth::user()->name }} さん</span>

                <!-- ドロップダウンメニュー -->
                @if (Route::currentRouteName() !== 'verification.notice')
                <div id="user-menu" class="hidden absolute top-full mt-2 w-48 bg-[#ece0cf] rounded-md shadow-lg">
                    <ul class="py-2">
                        <li>
                            <a href="{{ route('items.create') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">持ち物登録</a>
                        </li>
                        <li>
                            <a href="{{ route('favorites.index') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">お気に入り</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">設定</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                                @csrf
                                <button type="submit" class="w-full text-left">ログアウト</button>
                            </form>
                        </li>
                        <a href="#" 
                            onclick="if(confirm('退会するとすべてのデータが削除されます。本当に退会しますか？')) { event.preventDefault(); document.getElementById('delete-account-form').submit(); }"
                            class="block px-4 py-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            退会
                        </a>
                        <form id="delete-account-form" method="POST" action="{{ route('user.delete') }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </ul>
                </div>
                @endif
            </div>
        @else
            @if(Route::currentRouteName() !== 'login')
                <!-- ログインしていない場合 -->
                <a href="{{ route('login') }}" class="text-white hover:underline">ログイン</a>
            @endif
        @endauth
    </div>

</header>

<!-- 退会完了メッセージを表示 -->
@if (session('success'))
    <div class="bg-red-100 text-red-800 px-4 py-3 rounded relative text-center mt-4" style="background: pink; color: red;">
        {{ session('success') }}
    </div>
@endif

@auth
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        // 要素が存在する場合のみイベントリスナーを設定
        if (userMenuButton && userMenu) {
            // メニューの表示・非表示を切り替え
            userMenuButton.addEventListener('click', () => {
                userMenu.classList.toggle('hidden');
            });

            // メニュー外をクリックした場合、非表示にする
            document.addEventListener('click', (event) => {
                if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                    userMenu.classList.add('hidden');
                }
            });
        }
    });
</script>
@endauth