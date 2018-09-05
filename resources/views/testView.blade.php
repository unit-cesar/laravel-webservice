<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>testView</title>
</head>
<body>
testView ok!

<h1>Recebendo arrays da função da rota</h1>

<h3>firstArray</h3>
<ol>
    @foreach($firstArray as $first)
        <li>{{ $first['name'] }} - {{ $first['email'] }}</li>
    @endforeach
</ol>

<h3>secondArray</h3>
<ul>
    @foreach($secondArray as $second)
        <li>{{ $second->name }} - {{ $second->email }}</li>
    @endforeach
</ul>

</body>
</html>