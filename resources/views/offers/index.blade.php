<!DOCTYPE html>
<html lang="de">
<head>
    <title>Nachhilfe</title>
</head>
<body>
<ul>
    @foreach($offers as $offer)
        <li><a href="offers/{{$offer->id}}">{{$offer->title}}</a></li>
    @endforeach
</ul>
</body>
</html>
