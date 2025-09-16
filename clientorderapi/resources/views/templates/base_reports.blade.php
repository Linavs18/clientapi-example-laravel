<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/report.css') }}" type="text/css">
</head>
<body>
    <section id="header">
        <Table width="100%" style="border-collapse: collapse; border: 1px solid">
            <tr>
                <th>
                    <div style="text-align: center">
                        <img src="{{ asset('img/logo.jpg') }}" alt="logo">
                    </div>
                </th>
                <th>
                    <p style="text-align: center; font-seze: 14px">
                        @yield('header')
                    </p>
                </th>
            </tr>
        </Table>
    </section>

    <br>

    <section id="infoReport">
        <p style="font-size: 14px">
            <strong>Fecha reporte:</strong>
            @php
                $time = time();
                echo date('Y-m-d (H:i:A)', $time);
            @endphp
        </p>
    </section>

    <br>

    @yield('content')

    <footer id="version_text">
        <p>Generado por OrderWed 1.0</p>
    </footer>
</body>
</html>