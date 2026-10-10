<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メイン画面</title>
</head>
<body>
   @foreach($pets as $pet)
    <p>名前{{ $pet->name }}</p>
    <p>誕生日{{ $pet->birthday }}</p>
    <p>性別{{ $pet->sex }}</p>
@endforeach

</body>
</html>