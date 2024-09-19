@extends('layouts.presensi')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle" style="margin-left:35%">E-Presensi</div>
        <div class="right"></div> 
    </div>
    <!-- * App Header -->
@endsection

<style>
    .webcam-capture,
    .webcam-capture Video {
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }

    #map {
        height: 200px;
    }
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture">
            </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col">
            @if ($cek > 0)
            <div class="mb-3">                
                <label class="form-label">Kegiatan:</label>
                <textarea name="kegiatan" class="form-control cursor-pointer" required rows="5"
                placeholder="Masukan kegiatan hari ini dalam 1 paragraf"></textarea>
            </div>
                <button id="takeabsen" class="btn btn-danger btn-block"><ion-icon name="camera-outline">
                    </ion-icon> Absen Pulang
                </button>
            @else
                <button id="takeabsen" class="btn btn-primary btn-block"><ion-icon name="camera-outline">
                    </ion-icon> Absen Masuk
                </button>
            @endif

        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>

    <audio id="notifikasi_in">
        <source src="{{ asset('assets/sound/notifikasi_in.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_out">
        <source src="{{ asset('assets/sound/notifikasi_out.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_radius">
        <source src="{{ asset('assets/sound/notifikasi_radius.mp3') }}" type="audio/mpeg">
    </audio>
@endsection

@push('myscript')
    <script>
        const notifikasi_in = document.getElementById('notifikasi_in');
        const notifikasi_out = document.getElementById('notifikasi_out');
        const notifikasi_radius = document.getElementById('notifikasi_radius');

        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80
        })

        Webcam.attach('.webcam-capture');

        let lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback)
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;

            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            var circle = L.circle([-7.929872548857881, 112.64928946236074], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 55
            }).addTo(map);
        }

        function errorCallback(position) {

        }

        $('#takeabsen').click(function(e) {
            Webcam.snap(function(uri) {
                image = uri;
            })
            var kegiatan = $('textarea[name="kegiatan"]').val();
            var lokasi = $('#lokasi').val()
            $.ajax({
                type: "POST",
                url: "/presensi/store",
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi,
                    kegiatan: kegiatan
                },
                cache: false,
                success: function(response) {
                    const status = response.split('|');
                    if (status[0] == 'success') {
                        if (status[2] == 'in') {
                            notifikasi_in.play();
                        } else {
                            notifikasi_out.play();
                        }
                        Swal.fire({
                            title: 'Berhasil!',
                            text: status[1],
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        setTimeout(() => {
                            location.href = "/dashboard";
                        }, 3000);
                    } else {
                        if (status[2] == 'radius') {
                            notifikasi_radius.play();
                        }
                        Swal.fire({
                            title: 'Error!',
                            text: status[1],
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        })
    </script>
@endpush
