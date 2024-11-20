<x-app-layout>
    <div class="max-w-7xl mx-auto pt-3 pb-2">
        <!-- 見出し -->
        <h1 class="text-2xl font-extrabold mb-6 text-center text-[#0098ad] tracking-wide">持ち物登録</h1>

        <!-- フォーム全体 -->
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-8 items-start">
            @csrf

            <!-- 左カラム -->
            <div class="relative flex flex-col space-y-4 px-6 rounded-md">
                <!-- 縦線 -->
                <div class="absolute inset-y-0 right-0 w-px bg-[#0098ad]"></div>

                <!-- カテゴリー選択 -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">登録するカテゴリーを選択してください</label>
                    <select id="category" name="category" class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]">
                        <option value="">カテゴリーを選択</option>
                        <option value="category1">カテゴリー1</option>
                        <option value="category2">カテゴリー2</option>
                    </select>
                </div>

                <!-- タグ選択 -->
                <div>
                    <label for="tag" class="block text-sm font-semibold text-gray-700 mb-2">タグを選択してください</label>
                    <select id="tag" name="tag" class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]">
                        <option value="">タグを選択</option>
                        <option value="tag1">タグ1</option>
                        <option value="tag2">タグ2</option>
                    </select>
                </div>

                <!-- ユーザー名 -->
                <div>
                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">ユーザー名</label>
                    <input type="text" id="username" name="username" 
                        value="{{ Auth::check() ? Auth::user()->name : 'ゲスト' }}" 
                        readonly class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]">
                </div>

                <!-- 保管場所 -->
                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">保管場所を入力してください</label>
                    <input type="text" id="location" name="location" placeholder="例：階段下の収納" class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]">
                </div>

                <!-- 備考 -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">備考</label>
                    <textarea id="notes" name="notes" placeholder="例：黄色い箱の中に入っていますが、時系列に並んでいない" class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]"></textarea>
                </div>
            </div>

            <!-- 右カラム -->
            <div class="flex flex-col items-center space-y-8">
                <!-- ファイル選択 -->
                <div class="flex flex-col items-center justify-center bg-[#ece0cf] p-10 rounded-md border-dashed border-2 border-gray-300 w-full h-48 mt-10">
                    <p class="text-gray-600 text-center mb-4">ここにファイルをドラッグ＆ドロップしてください<br>または</p>
                    <label class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 cursor-pointer">
                        ファイル選択
                        <input type="file" name="file" class="hidden">
                    </label>
                </div>

                <!-- 登録ボタン -->
                <div>
                    <button type="submit" class="bg-[#0098ad] text-white px-6 py-2 rounded-md hover:bg-[#007a8b] text-center">
                        登録
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
