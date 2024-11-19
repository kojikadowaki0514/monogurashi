<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <h1 class="text-2xl font-bold mb-6">持ち物を登録する</h1>
        <!-- フォーム例 -->
        <form action="{{ route('items.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="item_name" class="block text-sm font-medium text-gray-700">持ち物名</label>
                <input type="text" name="item_name" id="item_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">登録</button>
        </form>
    </div>
</x-app-layout>