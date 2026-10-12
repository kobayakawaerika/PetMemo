@props(['title' => 'ペットメモ'])

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>{{ $title }}</title>
</head>
<body class="mx-auto max-w-md bg-gray-100 px-4">
    {{ $slot }}
</body>
</html>