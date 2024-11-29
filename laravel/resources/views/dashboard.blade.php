<x-app-layout>
    <div class="min-h-screen py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!$itemsExist)
                <!-- データが存在しない場合のメッセージとボタン -->
                <div class="bg-red-100 text-red-800 p-6 rounded-md text-center mb-6">
                    <p class="text-lg font-semibold mb-4">現在、カテゴリーおよび持ち物が登録されていません。</p>
                    <a href="{{ route('items.create') }}" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">
                        持ち物を登録する
                    </a>
                </div>
            @else
                <!-- 検索ボックスと検索ボタン -->
                <div class="flex items-center mb-4">
                    <form method="GET" action="{{ route('items.search') }}" class="flex items-center">
                        <input 
                            type="text" 
                            id="search-box" 
                            name="search_term" 
                            placeholder="品名を入力してください" 
                            class="border-gray-300 rounded-md w-64 px-4 py-2 text-sm"
                            value="{{ request('search_term') }}"> <!-- 検索後も入力を保持 -->
                            <button 
                                id="search-button" 
                                type="submit" 
                                class="ml-4 bg-[#0098ad] text-white px-4 py-2 rounded-md hover:bg-[#007a8b] relative">
                                検索
                                <div 
                                    id="tooltip" 
                                    class="absolute bg-red-100 text-red-800 text-xs rounded px-2 py-1 hidden"
                                    style="top: -30px; left: 50%; transform: translateX(-50%); white-space: nowrap;">
                                    品名を入力せずに押すと、すべての持ち物が表示されます
                                </div>
                            </button>
                    </form>
                </div>
                <!-- エラーメッセージの表示 -->
                @if ($errors->has('search_term'))
                    <p class="text-red-500 mt-2">{{ $errors->first('search_term') }}</p>
                @endif

                
                <!-- CATEGORY表示 -->
                <h2 class="text-3xl font-bold mb-8 text-center">CATEGORY</h2>
                <div class="grid grid-cols-3 gap-8">
                    @forelse ($categories as $category)
                        <a href="{{ route('categories.items', $category->id) }}" class="bg-[#f4ede4] p-8 rounded-xl shadow-lg hover:shadow-2xl cursor-pointer flex flex-col items-center justify-center">
                            <!-- カテゴリー画像 -->
                            <img src="{{ asset($category->category_image ?? 'images/categories/no_image.jpg') }}" 
                                alt="{{ $category->category_name }}" 
                                class="w-24 h-24 object-cover rounded-md">
                            <!-- カテゴリー名 -->
                            <p class="mt-4 text-center text-lg font-semibold">{{ $category->category_name }}</p>
                        </a>
                    @empty
                        <!-- ログインユーザーに関連するカテゴリーがない場合 -->
                        <p class="text-center col-span-3 text-red-500 text-lg font-semibold">
                            ログインユーザーに関連するカテゴリーがありません。
                        </p>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchButton = document.getElementById('search-button');
        const tooltip = document.getElementById('tooltip');

        // カーソルが乗ったときにツールチップを表示
        searchButton.addEventListener('mouseenter', () => {
            tooltip.classList.remove('hidden');
        });

        // カーソルが外れたときにツールチップを非表示
        searchButton.addEventListener('mouseleave', () => {
            tooltip.classList.add('hidden');
        });
    });
</script>
