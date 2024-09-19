<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Dashboard</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<style>
    /* Mengatur header agar fixed dan tidak menutup konten */
    .appHeader {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        height: 60px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 15px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Menyesuaikan elemen lain sesuai ukuran */
    #appCapsule {
        padding-top: 1px;
    }

    /* Dinamis dengan menjaga rasio 400:771 */
    body {
        background-color: #e9ecef;
        width: 100vw;
        height: calc(100vw * 1.9275); /* Menggunakan rasio 771 / 400 = 1.9275 */
        max-width: 400px;
        max-height: 771px;
        margin: 0 auto;
    }

    /* Untuk layar yang lebih besar */
    @media screen and (min-width: 400px) {
        body {
            width: 400px;
            height: 771px;
        }
    }

</style>

<body>
    <script>
        // Memaksa skala tampilan agar sesuai dengan rasio 400px x 771px
        function setScale() {
            let viewport = document.querySelector('meta[name="viewport"]');
            let width = window.innerWidth;
            let height = window.innerHeight;

            // Cek apakah layar lebih kecil dari rasio yang diinginkan
            if (width / height > 400 / 771) {
                // Jika layar lebih lebar, sesuaikan tinggi
                viewport.setAttribute('content', 'height=' + height + ', initial-scale=1');
                document.body.style.transform = 'scale(' + (height / 771) + ')';
            } else {
                // Jika layar lebih tinggi, sesuaikan lebar
                viewport.setAttribute('content', 'width=' + width + ', initial-scale=1');
                document.body.style.transform = 'scale(' + (width / 400) + ')';
            }

            document.body.style.transformOrigin = '0 0';
        }

        // Memanggil fungsi saat halaman dimuat dan ketika ukuran layar berubah
        window.onload = setScale;
        window.onresize = setScale;
    </script>

    @yield('header')

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- Content -->
    <div id="appCapsule">
        @yield('content')
    </div>
    <!-- * Content -->

    @include('layouts.bottomNav')
    @include('layouts.script')

</body>

</html>
