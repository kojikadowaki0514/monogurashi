<x-app-layout>
    <div class="max-w-7xl mx-auto pt-3 pb-2" style="height: calc(100vh - 132px);">
        <!-- 見出し -->
        <h1 class="text-2xl font-extrabold mb-6 text-center text-[#0098ad] tracking-wide">持ち物登録</h1>

        <!-- フォーム全体 -->
        <form action="{{ route('items.session') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-8 items-start">
            @csrf

            <!-- itemsテーブルにcategory_idを登録（送信）するため、隠しフィールドでcategory_idを保持 -->
             <!--  category-tag-create.blade.phpからリダイレクト時に渡されている -->
            <input type="hidden" name="category_id" value="{{ request('category_id') }}">

            <!-- 左カラム -->
            <div class="relative flex flex-col space-y-4 rounded-md" style="padding-right: 120px;">
                
                <!-- 縦線 -->
                <div class="absolute inset-y-0 right-0 w-px bg-[#0098ad]"></div>

                <!-- 商品名入力欄 -->
                <div>
                    <label for="product_name" class="block text-sm font-semibold text-gray-700 mb-2">持ち物名</label>
                    <input type="text" id="product_name" name="product_name" placeholder="商品名を入力してください" 
                        value="{{ session('product_name', '') }}"
                        class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]">
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
                    <input type="text" id="location" name="location" placeholder="例：階段下の収納"
                        value="{{ session('location', '') }}"
                        class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]">
                </div>

                <!-- 備考 -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">備考</label>
                    <textarea id="notes" name="notes" placeholder="例：黄色い箱の中に入っていますが、時系列に並んでいない"
                        class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]">{{ session('notes', '') }}</textarea>
                </div>

                @if ($categories->isEmpty() && $tags->isEmpty())
                    <!-- カテゴリーもタグも登録がない場合に表示 -->
                    <!-- <div class="relative group">
                        <a href="{{ route('category-tag.create') }}" class="bg-[#0098ad] text-white px-4 py-2 rounded-md hover:bg-blue-600">
                            カテゴリーとタグ登録
                        </a>
                        <div class="absolute hidden group-hover:block mt-2 w-64 bg-gray-100 text-gray-700 text-sm rounded-md shadow-lg p-2">
                            新しいカテゴリーとタグを登録する画面に移動します。
                        </div>
                    </div> -->
                @else
                    <!-- 登録済みカテゴリーとタグを表示 -->
                    <div class="mb-2">            
                        <!-- カテゴリー表示 -->
                        <!-- <div class="mb-2">
                            <h3 class="text-sm font-semibold text-gray-700">カテゴリー</h3>
                            <ul class="list-disc pl-6">
                                @forelse ($categories as $category)
                                    <li class="text-gray-700 flex items-center space-x-4 mb-2">
                                        <span>{{ $category->category_name }}</span>
                                        <a href="{{ route('category-tag.create', ['id' => $category->id]) }}" class="bg-blue-500 text-white px-4 py-1 rounded-md hover:bg-blue-600">
                                            編集
                                        </a>
                                    </li>
                                @empty
                                    <p class="text-gray-500">登録されているカテゴリーはありません。</p>
                                @endforelse
                            </ul>
                        </div> -->

                        <!-- タグ表示 -->
                        <!-- <div>
                            <h3 class="text-sm font-semibold text-gray-700">タグ</h3>
                            <ul class="list-disc pl-6">
                                @forelse ($tags as $tag)
                                    <li class="text-gray-700 flex items-center space-x-4 mb-2">
                                        <span>{{ $tag->tag_name }}</span>
                                    </li>
                                @empty
                                    <p class="text-gray-500">登録されているタグはありません。</p>
                                @endforelse
                            </ul>
                        </div> -->
                    </div>
                @endif
            </div>

            <!-- 右カラム -->
            <div class="flex flex-col items-center space-y-6">
                <!-- ファイル選択 -->
                <div class="flex flex-col items-center justify-center bg-[#ece0cf] p-6 rounded-md border-dashed border-2 border-gray-300 w-3/4 max-w-md h-auto mt-8">
                    <p class="text-gray-600 text-center mb-4">【持ち物の画像ファイル】</p>
                    <!-- プレビュー用の画像 -->
                    <img id="image-preview" 
                        src="{{ session('item_image') ? asset('storage/' . session('item_image')) : asset('images/items/no_image.jpg') }}" 
                        alt="プレビュー画像" 
                        class="w-32 h-32 object-cover rounded-md mb-4">
                    <!-- ファイル選択ボタン -->
                    <label for="file-upload" class="bg-orange-500 text-white px-6 py-2 rounded-md hover:bg-orange-600 cursor-pointer">
                        ファイル選択
                    </label>
                    <input id="file-upload" type="file" name="file" accept="image/*" class="hidden">
                </div>

                <!-- 登録ボタン -->
                <div>
                    <button type="submit" class="bg-[#0098ad] text-white px-6 py-2 rounded-md hover:bg-[#007a8b] text-center">
                        カテゴリーとタグの登録画面へ
                    </button>
                </div>
            </div>

        </form>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('file-upload');
    const dragArea = document.getElementById('drag-area');
    const previewImage = document.getElementById('image-preview');
    const defaultImage = "{{ asset('images/items/no_image.jpg') }}"; // デフォルト画像のパス

    // ファイル選択で画像を表示
    fileInput.addEventListener('change', function () {
        const file = fileInput.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            // ファイルが未選択の場合はデフォルト画像を表示
            previewImage.src = defaultImage;
        }
    });
});
</script>