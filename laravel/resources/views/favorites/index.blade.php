<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-9" style="height: calc(100vh - 140px)">
        <div class="mb-6 text-left">
            <a href="{{ route('dashboard') }}" class="bg-orange-400 text-white px-4 py-2 rounded-md hover:bg-orange-500">
                前のページに戻る
            </a>
        </div>

        <!-- タイトル -->
        <h1 class="text-2xl font-bold mb-8">お気に入り一覧</h1>

        @if ($favoriteItems->isEmpty())
            <p class="text-center text-red-500 text-lg font-semibold">お気に入りに登録されたアイテムはありません。</p>
        @else
        @php
            // 最初のアイテムを取得
            $firstItem = $favoriteItems->first();
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
                            @foreach($favoriteItems as $item)
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
                                        <button 
                                            class="favorite-button focus:outline-none" 
                                            data-url="{{ route('items.toggleFavorite', ['item' => $item->id]) }}">
                                            <i class="fas fa-heart {{ auth()->user()->hasFavorited($item) ? 'text-red-500' : 'text-gray-400' }}"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- ページネーション -->
                    <div class="mt-4">
                        {{ $favoriteItems->links() }}
                    </div>
                </div>

                <!-- 右側（選択したアイテム詳細） -->
                <div id="item-details" class="bg-[#ece0cf] p-3 rounded-md border border-gray-300">
                    @if ($firstItem)
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
                            <span class="w-24 font-semibold">保管場所:</span>
                            <span id="item-location">{{ $firstItem->location ?? '' }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold">備考:</span>
                            <span id="item-description">{{ $firstItem->description ?? '' }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

<script>
  // 選択した行の詳細情報を更新する関数
  function updateDetailView(data) {
      document.getElementById('item-image').src = data.item_image;
      document.getElementById('item-name').textContent = data.item_name;
      document.getElementById('item-created-at').textContent = data.created_at;
      document.getElementById('item-location').textContent = data.location;
      document.getElementById('item-description').textContent = data.description;
  }

  // お気に入りボタンの表示
  document.addEventListener("DOMContentLoaded", () => {
      const favoriteButtons = document.querySelectorAll(".favorite-button");

      favoriteButtons.forEach((button) => {
          button.addEventListener("click", (e) => {
              e.preventDefault(); // フォーム送信を防止
              const url = button.getAttribute("data-url");
              const icon = button.querySelector("i");

              fetch(url, {
                  method: "POST",
                  headers: {
                      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                      "Content-Type": "application/json",
                  },
              })
                  .then((response) => response.json())
                  .then((data) => {
                      if (data.favorited) {
                          // お気に入りに追加された場合の処理
                          icon.classList.remove("text-gray-400");
                          icon.classList.add("text-red-500");
                      } else {
                          // お気に入りから削除された場合の処理
                          icon.classList.remove("text-red-500");
                          icon.classList.add("text-gray-400");

                          // ポップアップメッセージの表示
                          showPopup("お気に入りから削除しました");
                      }
                  })
                  .catch((error) => console.error("エラー:", error));
          });
      });

      // ポップアップを表示する関数
      function showPopup(message) {
          const popup = document.createElement("div");
          popup.textContent = message;
          popup.style.position = "fixed";
          popup.style.bottom = "20px";
          popup.style.right = "20px";
          popup.style.padding = "10px 20px";
          popup.style.backgroundColor = "rgba(0,0,0,0.8)";
          popup.style.color = "white";
          popup.style.borderRadius = "5px";
          popup.style.boxShadow = "0 2px 5px rgba(0,0,0,0.3)";
          popup.style.zIndex = "1000";
          document.body.appendChild(popup);

          // 3秒後にポップアップを削除
          setTimeout(() => {
              popup.remove();
          }, 3000);
      }
  });

</script>
