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

        <div class="mt-6 max-w-md rounded-2xl bg-white p-6 shadow">
            <h2 class="text-2xl font-bold">
                {{ $pet->name }}
                <span class="text-lg text-gray-500">{{ $pet->sexSymbol() }}</span>
            </h2>

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