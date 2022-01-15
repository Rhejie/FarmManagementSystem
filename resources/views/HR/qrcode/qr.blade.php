<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token(),
            'locale' => config('app.locale'),
        ]); ?>;
    </script>

</head>
<body>
    <div style="padding:20px; justify-content: center; text-align:center">
        {!!$qrcode!!}
        <h4>{{$qr}}</h4>

        <div id="app">

        </div>
        {{-- {!! QrCodeGenerator::size(300)->generate($qr)!!}
        {!! QrCodeGenerator::format('png')->size(200)->generate($qr, storage_path('qrcode/'.$qr."png"))!!} !!} --}}
    </div>
</body>
<script src="{{ asset('js/app.js') }}" defer></script>
</html>
