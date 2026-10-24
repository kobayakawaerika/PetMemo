<x-layout title="編集画面">

    <div class="mx-auto max-w-md px-4 py-4">
        <div class="mt-6 max-w-md rounded-2xl bg-white p-6 shadow">
            <div class="text-center text-l">
                <h1 class="mb-3 font-midium">ペット編集</h1>
            </div>
            <form action="{{ route('pets.update', $pet) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- 写真 -->
                <div class="mb-4 flex flex-col items-center gap-3">
                    @if ($pet->photo_path)
                    <img src="{{ asset('storage/' . $pet->photo_path) }}"
                        alt="{{ $pet->name }}の写真"
                        class="h-24 w-24 rounded-full object-cover">
                    @else
                    <div class="flex h-24 w-24 items-center justify-center rounded-full bg-orange-100 text-4xl">
                        🐾
                    </div>
                    @endif

                    <input type="file" name="photo" accept="image/*"
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm">
                    @error('photo')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <!-- 名前 -->
                <label class="block text-sm font-medium text-slate-700 mb-1.5">名前</label>
                <input type="text" name="name" value="{{ $pet->name }}" class="w-full px-3 py-2 rounded-lg border border-slate-300
         focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none mb-3">

                <!-- 性別 -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">性別</label>

                    <select name="sex" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none bg-white">
                        <option value="man" {{ $pet->sex === 'man' ? 'selected' : '' }}>♂</option>
                        <option value="female" {{ $pet->sex === 'female' ? 'selected' : '' }}>♀</option>
                        <option value="unknown" {{ $pet->sex === 'unknown' ? 'selected' : '' }}>不明</option>
                    </select>
                </div>
                <!-- 誕生日 -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">誕生日</label>
                    <input type="date" name="birthday" value="{{ $pet->birthday?->format('Y-m-d') }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none">
                </div>
                <!-- 登録する -->
                <button type="submit"
                    class="resize-none w-full rounded-lg bg-orange-400 px-4 py-2 text-white">
                    編集する
                </button>
            </form>

            <!-- 戻るボタン -->
            <a href="{{ url('/index?pet=' . $pet->id) }}"
                class="mt-4 block text-center text-sm text-gray-500 hover:text-gray-700">
                戻る
            </a>

            <!-- 削除する -->
            <form action="{{ route('pets.delete', $pet) }}" method="POST" onsubmit="return confirm('本当に削除しますか？メモも一緒に消えます')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="mt-8 w-full rounded-lg border border-red-500 bg-white px-4 py-2 text-red-500 hover:bg-red-50">
                    このペットを削除する
                </button>
            </form>
        </div>
    </div>
</x-layout>