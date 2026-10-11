<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メイン画面</title>
</head>
<body>
    <a href="{{ route('pets.create') }}">登録する</a>
   @foreach($pets as $pet)
    <p>名前:{{ $pet->name }}</p>
    <p>誕生日:{{ $pet->birthday }}</p>
    <p>性別:{{ $pet->sex }}</p>
    <a href="{{ route('pets.edit', $pet)  }}">編集する</a>
@endforeach

</body>
</html>