@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Frequência</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        header { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f2f2f2; }
        .logo { margin-left: 14px; }
        .assinaturas { margin-top: 40px; }
        .info-table { width: 100%; margin-bottom: 10px; }
        .info-table td { padding: 2px; border: none; text-align: left; vertical-align: top; }
        h2, h3 { margin: 4px 0; }
        .title{ text-align: center; margin-top: 10px; }
    </style>
</head>
<body>
{{ $slot }}
</body>
</html>