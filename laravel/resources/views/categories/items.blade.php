<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-12">
        <!-- カテゴリー名 -->
        <h1 class="text-2xl font-bold text-center mb-6">{{ $category->category_name }} の持ち物</h1>

        <!-- アイテム一覧 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($items as $item)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <!-- アイテム画像 -->
                    <img src="{{ asset('storage/' . $item->item_image) }}" alt="{{ $item->item_name }}" class="w-full h-48 object-cover rounded-md mb-4">

                    <!-- アイテム情報 -->
                    <h2 class="text-lg font-bold mb-2">{{ $item->item_name }}</h2>
                    <p class="text-sm text-gray-600 mb-2">保管場所: {{ $item->location }}</p>
                    <p class="text-sm text-gray-600 mb-2">備考: {{ $item->description }}</p>

                    <!-- 編集・削除ボタン -->
                    <div class="flex space-x-2">
                        <a href="{{ route('items.edit', $item->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">編集</a>
                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">削除</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- ページネーション -->
        <div class="mt-6">
            {{ $items->links() }}
        </div>
    </div>
</x-app-layout>
