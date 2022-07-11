<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Procesa</title>
</head>
<body>
    <h1>Tu nombre es : </h1>{{$nombre}}
    @if ($nombre=='admin')
        bienvenido : {{$nombre}}
    @else 
        bienvenido : invitado    
    @endif
    
    <h2> Ternario</h2> <br>
    bienvenido {{($nombre=='admin')? $nombre:'invitado' }}
    <br>
    @foreach ($users as $user)
        {{$user}}        
    @endforeach

</body>
</html>