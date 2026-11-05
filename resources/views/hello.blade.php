<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>alsjdi</h2>
    <h1>hello   {{ $name }}</h1>
    @foreach ($stud as $student)
        <p>{{ $student }}</p>
    @endforeach
</body>
</html>