<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>ペット登録</h1>
   <form action="{{ route('index') }}">
        @csrf
        名前<input type="text" name="name">
        <br>
        性別<select name="sex">
            <option value="man">♂</option>
            <option value="male">♀</option>
            <option value="unknown">不明</option>
        </select>
        <br>
        誕生日<input type="date" name="birthday">
    </form>
</body>
</html>