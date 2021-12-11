<html lang="fa" DIR="rtl" >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <title>Document</title>

</head>
<body>
<table>
<tr>
    <th>company</th>
    <th>seat_num</th>
    <th>price</th>
    <th>origin</th>
    <th>destination</th>
    <th>date</th>
    <th>end_date</th>
    <th>name</th>
    <th>national_code</th>
</tr>
    @foreach($tickets as $ticket)
<tr>
    @foreach($ticket as $item)
        <td>{{$item}}</td>
    @endforeach
</tr>
    @endforeach
</table>
</body>
<script>

    // $.ajax({
    //     url: "http://127.0.0.1:8000/api/reservation/ticket/3",
    //     type: "GET",
    //     dataType: "JSON",
    //
    //     success: function (data) {
    //
    //         $.each(data.response, function (key, value) {
    //             console.log()
    //             message = '' + value + '';
    //             $("#data").append("<tr>"+"<th>"+key+"</th>"+"<td>"+value+"</td>"+"</tr>");
    //         });
    //     }
    //
    // });

</script>

</html>
