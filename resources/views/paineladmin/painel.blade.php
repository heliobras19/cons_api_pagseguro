<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
    <thead>
        <th>Inscrito</th>
        <th>Data inscricao</th>
        <th>Categoria</th>
        <th>Email</th>
        <th>total</th>
        <th>status</th>
        <th>Acoes</th>
    </thead>
    <tbody>
        @foreach ($data as $item)
         <tr>
            <td>{{$item->nome}}</td>
            <td>{{$item->created_at}}</td>
            <td>{{$item->ocupacao}}</td>
            <td>{{$item->email}}</td>
            <td>200.00 R$</td>
            <td>Pago</td>
            <td>apagar</td>
         </tr>
        @endforeach
    </tbody>
    </table>
<a href="{{route('exportar')}}">exportar XLS</a>
</body>
</html>