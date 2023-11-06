<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        body {
            font-family: "Inter", sans-serif;
            width: 100%;
            font-size: 12px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
        }

        #table td,
        #table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: grey;
            color: white;
        }
    </style>
</head>

<body>
    <center>
        <h1>{{$title}}</h1>
    </center>
    <br>
    <table id="table">
        <thead>
            <tr>
                <th scope="col" style="text-align: center;">#</th>
                @foreach($header as $th)
                <th scope="col" style="text-align: center;">{{$th}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td scope="row" style="text-align: center;">{{$loop->iteration}}</td>
                @for ($i = 0; $i < count($header); $i++) <td width="{{$width[$i]}}">{{$item[str_replace(' ', '_', strtolower($header[$i]))]}}</td>
                    @endfor
            </tr>
            @endforeach
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>