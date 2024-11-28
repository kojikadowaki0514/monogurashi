<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-9" style="height: calc(100vh - 132px)">
        <div class="mb-6 text-left">
            <a href="{{ route('dashboard') }}" class="bg-orange-400 text-white px-4 py-2 rounded-md hover:bg-orange-500">
                前のページに戻る
            </a>
        </div>
        <!-- タイトル -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">{{ $category->category_name }} </h1>
            <div>
                <form method="GET" action="{{ route('categories.items.filter', ['category' => $category->id]) }}">
                    <select id="tags" name="tag_id" class="border-gray-300 rounded-md px-4 py-2 text-sm text-gray-800 w-60">
                        <option value="">タグを選択してください</option>
                        @foreach ($items as $item)
                            @foreach ($item->tags as $tag)
                            <option 
                                value="{{ $tag->id }}" 
                                class="text-gray-800" 
                                {{ request('tag_id') == $tag->id ? 'selected' : '' }}>
                                {{ $tag->tag_name }}
                            </option>
                            @endforeach
                        @endforeach
                    </select>
                    <input 
                        type="text" 
                        id="search-box" 
                        name="search_term" 
                        placeholder="品名を入力してください" 
                        class="border-gray-300 rounded-md px-4 py-2 text-sm ml-4 text-gray-800 w-60" 
                        value="{{ request('search_term') }}" 
                    >
                    <button type="submit" class="ml-4 bg-[#0098ad] text-white px-4 py-2 rounded-md hover:bg-[#007a8b]">検索</button>
                    <a href="{{ route('categories.items', ['category' => $category->id]) }}" 
                       class="ml-4 bg-orange-400 text-white px-4 py-2 rounded-md hover:bg-orange-500 h-10 inline-block">
                        リセット
                    </a>
                </form>
                
            </div>
        </div>

        @php
            // 最初のアイテムを取得
            $firstItem = $items->first();
        @endphp
        <!-- メインコンテナ -->
        <div class="grid grid-cols-3 gap-4">
            <!-- 左側（アイテムリスト） -->
            <div class="col-span-2">
                <!-- アイテムテーブル -->
                <table class="w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">品名</th>
                            <th class="border border-gray-300 px-4 py-2" style="width: 115px;">編集</th>
                            <th class="border border-gray-300 px-4 py-2" style="width: 115px;">削除</th>
                            <th class="border border-gray-300 px-4 py-2" style="width: 115px;">お気に入り</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr 
                                class="cursor-pointer hover:bg-gray-100" 
                                onmouseover="updateDetailView({{ json_encode([
                                    'item_name' => $item->item_name,
                                    'item_image' => asset($item->item_image ? 'storage/' . $item->item_image : 'images/items/no_image.jpg'),
                                    'created_at' => $item->created_at->format('Y/m/d H:i'),
                                    'location' => $item->location ?? '',
                                    'description' => $item->description ?? '',
                                ]) }})"
                            >
                                <td class="border border-gray-300 px-4 py-2">{{ $item->item_name }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <a href="{{ route('items.edit', $item->id) }}" class="text-blue-500 hover:underline">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <button class="text-red-500 hover:underline">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- ページネーション -->
                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            </div>

            <!-- 右側（選択したアイテム詳細） -->
            <div id="item-details" class="bg-[#ece0cf] p-3 rounded-md border border-gray-300">
            <h2 id="item-name" class="text-xl font-bold mb-4">{{ $firstItem->item_name ?? '' }}</h2>
            <img id="item-image" 
                src="{{ asset($firstItem->item_image ? 'storage/' . $firstItem->item_image : 'images/items/no_image.jpg') }}" 
                alt="選択された持ち物" 
                class="w-full h-40 object-cover rounded-md mb-4">
            <div class="flex mb-2">
                <span class="w-24 font-semibold">登録日時:</span>
                <span id="item-created-at">{{ $firstItem->created_at->format('Y/m/d H:i') ?? '' }}</span>
            </div>
            <div class="flex mb-2">
                <span class="w-24 font-semibold">登録者:</span>
                <span>{{ Auth::user()->name }}</span>
            </div>
            <div class="flex mb-2">
                <span class="w-24 font-semibold">保管場所:</span>
                <span id="item-location">{{ $firstItem->location ?? '' }}</span>
            </div>
            <div class="flex">
                <span class="w-24 font-semibold">備考:</span>
                <span id="item-description">{{ $firstItem->description ?? '' }}</span>
            </div>
        </div>

    </div>
</x-app-layout>

<script>
    // 選択した行の詳細情報を更新する関数
    function updateDetailView(data) {
        // 画像の更新
        document.getElementById('item-image').src = data.item_image;

        // テキスト情報の更新
        document.getElementById('item-name').textContent = data.item_name;
        document.getElementById('item-created-at').textContent = data.created_at;
        document.getElementById('item-location').textContent = data.location;
        document.getElementById('item-description').textContent = data.description;
    }
</script>

