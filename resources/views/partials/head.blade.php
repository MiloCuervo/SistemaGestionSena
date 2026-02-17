<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<link
    href="https://fonts.bunny.net/css?family=dm-serif-display:400,400i|instrument-sans:400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet" />


@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance