<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>メイン画面</title>
</head>
<body>
    <a href="{{ route('pets.create') }}">登録する</a>
{{-- 切り替えタブ --}}
@foreach($pets as $p)
    <a href="{{ route('index', ['pet' => $p->id]) }}"
       style="{{ $p->id === $pet->id ? 'font-weight:bold' : '' }}">
        {{ $p->name }}
    </a>
@endforeach

<body class="bg-gray-100">
    <div class="mx-auto mt-6 max-w-md rounded-2xl bg-white p-6 shadow">
        <h2 class="text-2xl font-bold">
            {{ $pet->name }}
            <span class="text-lg text-gray-500">{{ $pet->sexSymbol() }}</span>
        </h2>

        @if($pet->age())
            <p class="mt-1 text-gray-600">{{ $pet->age() }}</p>
        @endif

        <p class="mt-4 text-sm text-gray-500">誕生日</p>
        <p>{{ $pet->birthday }}</p>

        <a href="{{ route('pets.edit', $pet) }}"
           class="mt-6 inline-block rounded-lg bg-orange-400 px-4 py-2 text-white">
            編集する
        </a>
    </div>
</body>

</body>
</html>