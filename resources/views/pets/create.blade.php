<x-layout title="登録画面">
    <h1>ペット登録</h1>
   <form action="{{ route('pets.store') }}" method="POST">
        @csrf
        名前<input type="text" name="name">
        <br>
        性別<select name="sex">
            <option value="man">♂</option>
            <option value="female">♀</option>
            <option value="unknown">不明</option>
        </select>
        <br>
        誕生日<input type="date" name="birthday">
        <br>
        <button type="submit">登録する</button>
    </form>
</x-layout>