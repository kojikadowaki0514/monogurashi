<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- タグ選択 -->
        <div class="flex items-center">
            <select id="tags" class="border-gray-300 rounded-md px-4 py-2 w-64">
                <option value="">タグを選択してください</option>
                <!-- 動的にタグを追加 -->
                <option value="tag1">タグ1</option>
                <option value="tag2">タグ2</option>
            </select>
        </div>

        <!-- 検索ボックスと検索ボタン -->
        <div class="flex items-center">
            <input type="text" id="search-box" placeholder="検索キーワードを入力してください" class="border-gray-300 rounded-md w-64 px-4 py-2 my-4">
            <button class="ml-4 bg-[#0098ad] text-white px-4 py-2 rounded-md hover:bg-[#007a8b]">検索</button>
        </div>
        
            <!-- CATEGORY表示 -->
                <h2 class="text-3xl font-bold mb-8 text-center">CATEGORY</h2>
                <div class="grid grid-cols-3 gap-8">
                    <!-- カテゴリーをループで表示 -->
                    @foreach ($categories as $category)
                        <div class="bg-[#f4ede4] p-8 rounded-xl shadow-lg hover:shadow-2xl cursor-pointer flex flex-col items-center justify-center">
                            <!-- 画像 -->
                            @if ($category->category_image) <!-- 画像が登録されている場合 -->
                                <img src="{{ asset($category->category_image) }}" alt="{{ $category->category_name }}" class="w-24 h-24 object-cover rounded-md">
                            @else <!-- 画像が登録されていない場合 -->
                                <img src="{{ asset('images/no_image.jpg') }}" alt="No Picture" class="w-24 h-24 object-cover rounded-md">
                            @endif
                            <!-- 名前 -->
                            <p class="mt-4 text-center text-lg font-semibold">{{ $category->category_name }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>