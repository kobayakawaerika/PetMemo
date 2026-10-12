<x-layout title="編集画面">
    <h1>ペット編集</h1>
   <form action="{{ route('pets.update', $pet) }}" method="POST">
        @csrf
        名前<input type="text" name="name" value="{{ $pet->name }}">
        <br>
        性別<select name="sex">
            <option value="man" {{ $pet->sex === 'man' ? 'selected' : '' }}>♂</option>
            <option value="female" {{ $pet->sex === 'female' ? 'selected' : '' }}>♀</option>
            <option value="unknown" {{ $pet->sex === 'unknown' ? 'selected' : '' }}>不明</option>
        </select>
        <br>
        誕生日<input type="date" name="birthday" value="{{ $pet->birthday }}">
        <br>
        <button type="submit">保存</button>
    </form>
</x-layout>