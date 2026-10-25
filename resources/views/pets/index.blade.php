<x-layout title="メイン画面">

    <div class="mx-auto max-w-md px-4 py-4">
        <div class="mt-6 flex max-w-md gap-2 overflow-x-auto pb-2">
            @foreach($pets as $p)
            <a href="{{ route('index', ['pet' => $p->id]) }}"
                class="font-medium whitespace-nowrap rounded-full px-4 py-2 text-sm shadow
        {{ $p->id === $pet->id ? 'bg-orange-400 text-white' : 'bg-white text-gray-600' }}">
                {{ $p->name }}
            </a>
            @endforeach
            <a href="{{ route('pets.create') }}" class="rounded-full h-9 w-9 flex items-center justify-center shrink-0 bg-rose-400 shadow text-white">＋</a>
        </div>

        <div class="mt-6 max-w-md rounded-2xl bg-white p-6 shadow text-center">
            <div class="flex flex-col items-center gap-3 text-center">
                @if ($pet->photo_path)
                <img src="{{ asset('storage/' . $pet->photo_path) }}"
                    alt="{{ $pet->name }}の写真"
                    class="h-24 w-24 rounded-full object-cover">
                @else
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-orange-100 text-4xl">
                    🐾
                </div>
                @endif

                <h2 class="text-2xl font-bold">
                    {{ $pet->name }}
                    <span class="text-lg text-gray-500">{{ $pet->sexSymbol() }}</span>
                </h2>
            </div>

            @if($pet->age())
            <p class="mt-1 text-gray-600">{{ $pet->age() }}</p>
            @else
            <p>年齢：不明</p>
            @endif

            @if($pet->birthday)
            <p class="mt-4 text-sm text-gray-500">🎂誕生日🎂</p>
            <p>{{ $pet->birthday?->format('Y年n月j日') }}</p>
            @else
            <p>🎂誕生日🎂:不明</p>
            @endif

            <a href="{{ route('pets.edit', $pet) }}"
                class="mt-6 inline-block rounded-lg bg-orange-400 px-4 py-2 text-white">
                編集する
            </a>
        </div>

        <div class="mt-6 max-w-md rounded-2xl bg-white p-6 shadow">
            <h3 class="text-lg font-bold">体重の記録</h3>

            <form action="{{ route('pets.weight', $pet) }}" method="POST" class="mt-4">
                @csrf
                <label class="text-sm text-gray-500">体重(kg)</label>
                <input type="number" name="weight" step="0.01" value="{{ old('weight') }}"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('weight')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror

                <label class="mt-3 block text-sm text-gray-500">測った日時</label>
                <input type="datetime-local" name="measured_at"
                    value="{{ old('measured_at', now()->format('Y-m-d\TH:i')) }}"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                @error('measured_at')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror

                <button type="submit"
                    class="mt-4 w-full rounded-lg bg-orange-400 px-4 py-2 text-white">
                    体重を記録する
                </button>
            </form>

            <a href="{{ route('pets.weightChart', $pet) }}"
                class="mt-4 inline-block text-sm text-orange-500">
                グラフを見る 📈
            </a>
            
            @forelse($weights as $w)
            <div class="mt-4 border-b border-gray-200 pb-3 flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">{{ $w->measured_at->format('Y/n/j H:i') }}</p>
                    <p class="text-lg">{{ $w->weight }} kg</p>
                </div>
                <form action="{{ route('weights.delete', $w) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-500">削除する</button>
                </form>
            </div>
            @empty
            <p class="mt-4 text-gray-500">まだ体重の記録がありません</p>
            @endforelse
        </div>


        <div class="mt-6 max-w-md rounded-2xl bg-white p-6 shadow">
            <h3 class="text-lg font-bold">最新のメモ</h3>

            @forelse($memos as $memo)
            <div class="mt-4 border-b border-gray-200 pb-3">
                <p class="text-sm text-gray-500">{{ $memo->memo_date }}</p>
                <p>{{ $memo->content }}</p>

                <form action="{{ route('memos.delete', $memo) }}" method="POST"
                    onsubmit="return confirm('このメモを削除しますか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="mt-2 text-sm text-red-500">削除</button>
                </form>
            </div>
            @empty
            <p class="mt-4 text-gray-500">まだメモがありません</p>
            @endforelse
        </div>

        <div class="mt-6 max-w-md rounded-2xl bg-white p-6 shadow">
            <div>
                <form action="{{ route('pets.memo', $pet) }}" method="POST">
                    @csrf
                    <label class="text-sm text-gray-500">メモ</label>
                    <textarea name="content" rows="3"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2"></textarea>

                    <button type="submit"
                        class="resize-none w-full rounded-lg bg-orange-400 px-4 py-2 text-white">
                        メモを追加する
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-layout>