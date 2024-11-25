<x-app-layout>
    @if(session('registration_success'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const userChoice = confirm("登録が完了しました。続けて持ち物の登録を行いますか？");

                if (userChoice) {
                    // "はい"を選択した場合
                    window.location.href = "{{ route('items.create') }}";
                } else {
                    // "いいえ"を選択した場合
                    window.location.href = "{{ route('dashboard') }}";
                }
            });
        </script>
    @endif
    <div class="max-w-5xl mx-auto px-6 py-12">
        <!-- 見出し -->
        <h1 class="text-2xl font-bold text-center text-[#0098ad] mb-6">カテゴリーとタグ登録</h1>

        <!-- 前のページに戻る -->
        <div style="margin-bottom:30px;">
            <form action="{{ route('category-tag.session') }}" method="POST">
                @csrf
                <input type="hidden" name="category_name" value="{{ old('category_name', session('category_name', '')) }}">
                <input type="hidden" name="other_category_name" value="{{ old('other_category_name', session('other_category_name', '')) }}">
                <input type="hidden" name="tag_name" value="{{ old('tag_name', session('tag_name', '')) }}">
                <input type="hidden" name="category_image" value="{{ old('category_image', session('category_image', asset('images/categories/no_image.jpg'))) }}">
                <button type="submit" class="bg-[#0098ad] text-white px-4 py-2 rounded-md hover:bg-[#007a8b] text-center">
                    前のページに戻る
                </button>
            </form>
        </div>

        <!-- フォーム全体 -->
        <form action="{{ route('category-tag.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-8 items-start">
            @csrf
            
            <!-- 左カラム -->
            <div class="flex flex-col space-y-6">
                <!-- カテゴリー選択 -->
                <div>
                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">登録するカテゴリーを選択してください</label>
                <select id="category" name="category_name" class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]" onchange="updateCategoryImage()">
                    <option value="" data-image="{{ asset('images/categories/no_image.jpg') }}">カテゴリーを選択</option>
                    @foreach($categories as $category)
                        @if($category->id >= 1 && $category->id <= 6) <!-- 修正: idが1~6のみに限定 -->
                            <option 
                                value="{{ $category->category_name }}"
                                data-image="{{ asset($category->category_image) }}"
                                @if(session('category_name') == $category->category_name) selected @endif>
                                {{ $category->category_name }}
                            </option>
                        @endif
                    @endforeach
                </select>
                </div>

                <!-- その他入力ボックス -->
                <div id="other-category" class="{{ session('category_name') == 'その他' ? '' : 'hidden' }}">
                    <label for="other_category_name" class="block text-sm font-semibold text-gray-700 mb-2">新しいカテゴリー名</label>
                    <input type="text" id="other_category_name" name="other_category_name" placeholder="例: 手作り雑貨"
                        value="{{ session('other_category_name', '') }}" 
                        class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]">
                </div>

                <!-- タグ入力 -->
                <div>
                    <label for="tag_name" class="block text-sm font-semibold text-gray-700">タグ</label>
                    <input type="text" id="tag_name" name="tag_name" placeholder="例: 夏服"
                        value="{{ session('tag_name', '') }}" 
                        class="block w-full border-gray-300 rounded-md px-4 py-2 bg-[#ece0cf]">
                </div>
            </div>

            <!-- 右カラム -->
            <div class="flex flex-col items-center space-y-8">
                <!-- カテゴリー画像 -->
                <div class="flex flex-col items-center space-y-8">
                    <div class="flex flex-col items-center justify-center bg-[#ece0cf] p-10 rounded-md border-dashed border-2 border-gray-300 w-full h-64">
                        <p class="text-gray-600 text-center mb-4">【カテゴリー画像】</p>
                        <!-- プレビュー用の画像 -->
                        <img id="category-image-preview" 
                            src="{{ session('category_image', asset('images/categories/no_image.jpg')) }}" 
                            alt="カテゴリー画像" 
                            class="w-32 h-32 object-cover rounded-md mb-4">
                            <input type="hidden" id="category-image-url" name="category_image" 
                                 value="{{ session('category_image', asset('images/categories/no_image.jpg')) }}">
                        <!-- ファイル選択ボタン -->
                        <label for="category-image-upload" class="cursor-pointer bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">
                            画像を選択
                        </label>
                        <input id="category-image-upload" name="category_image" type="file" accept="image/*" class="hidden" onchange="previewCategoryImage(event)">

                    </div>
                </div>

                <!-- セレクトボックスで選択した値に対応する画像のURLを取得する -->
                <input type="hidden" id="category-image-url" name="category_image" value="{{ session('category_image', asset('images/categories/no_image.jpg')) }}">

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


<script>
// ページ読み込み時に選択されたカテゴリー画像を更新する
document.addEventListener("DOMContentLoaded", function () {
    updateCategoryImage(); // 初期画像を設定
});

// セレクトボックスで選択した値に対応する画像を取得
function updateCategoryImage() {
    // セレクトボックスのidを取得
    const selectBox = document.getElementById('category');
    // セレクトボックスの選択されたオプションを取得
    const selectedOption = selectBox.options[selectBox.selectedIndex];
    // 選択されたオプションの data-image 属性から画像URLを取得
    const imageUrl = selectedOption.getAttribute('data-image');
    // プレビュー画像を更新
    const previewImage = document.getElementById('category-image-preview');
    previewImage.src = imageUrl;
    // セレクトボックスで取得した値に対応する画像のパスを取得し、hiddenフィールドに渡す（アニメ->anime.jp）
    const hiddenInput = document.getElementById('category-image-url');
    hiddenInput.value = imageUrl;
}

// セレクトボックスで「その他」を選択した時に、任意で入力できるフィールドを出現させる
document.addEventListener("DOMContentLoaded", function () {
    // セレクトボックスのidを取得
    const selectBox = document.getElementById('category');
    // 任意入力フィールドのidを取得
    const otherCategoryField = document.getElementById('other-category');

    selectBox.addEventListener("change", function () {
        // 現在の選択された値を取得
        const selectedValue = selectBox.value;

        if (selectedValue === "その他") {
             // 「その他」の場合、フィールドを表示
            otherCategoryField.classList.remove("hidden");
        } else {
            // 「その他」でない場合、フィールドを隠す
            otherCategoryField.classList.add("hidden"); 
        }
    });
});

// ファイル選択時に画像プレビューを更新
function previewCategoryImage(event) {
    const input = event.target; // ファイル入力
    const preview = document.getElementById('category-image-preview'); // プレビュー画像の要素

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        // ファイル読み込みが完了したらプレビュー画像を更新
        reader.onload = function(e) {
            preview.src = e.target.result; // 選択した画像をプレビューに表示
        };

        reader.readAsDataURL(input.files[0]); // ファイルを読み込む
    } else {
        // ファイルが選択されていない場合、デフォルト画像を表示
        preview.src = "{{ asset('images/categories/no_image.jpg') }}";
    }
}
    
</script>
