<x-layout title="登録画面">

    <div class="mx-auto max-w-md px-4 py-4">
        <div class="mt-6 max-w-md rounded-2xl bg-white p-6 shadow">
            <div class="text-center text-l">
        <h1 class="mb-3 font-midium">ペット登録</h1>
        </div>
            <form action="{{ route('pets.store') }}" method="POST">
                @csrf
                <!-- 名前 -->
                <label class="block text-sm font-medium text-slate-700 mb-1.5">名前</label>
                <input type="text" name="name" placeholder="名前を入力してください" class="w-full px-3 py-2 rounded-lg border border-slate-300
         focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none">
                
         <!-- 性別 -->
<div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">性別</label>
                    <select name="sex" 
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none bg-white">
                        <option value="man">♂(男の子)</option>
                        <option value="female">♀(女の子)</option>
                        <option value="unknown">不明</option>
                    </select>
                </div>

               <!-- 誕生日 -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">誕生日</label>
                    <input type="date" name="birthday" 
                        class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none">
                </div>

                <!-- 登録する -->
                <button type="submit"
                    class="resize-none w-full rounded-lg bg-orange-400 px-4 py-2 text-white">
                    登録する
                </button>
            </form>
        </div>
    </div>
</x-layout>