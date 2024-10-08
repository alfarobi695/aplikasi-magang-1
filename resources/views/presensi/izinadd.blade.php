@extends('layouts.presensi')

@section('header')
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<style>
    .datepicker-modal {

        max-height: 330px !important;
    }

    .datepicker-date-display {
        background-color: #0f3a7e !important;
    }
</style>

<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle" style="margin-left:35%">Form Izin</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection

@section('content')

<div class="row" style="margin-top: 4rem">
    <div class="col">
        <form action="/presensi/storeizin" method="POST" id="fmizin">
            @csrf
            <div class="form-group">
                <input type="text" id="tgl_izin" name="tgl_izin" class="form-control datepicker" placeholder="Tanggal">
            </div>
            <div class="form-group">
                <select name="status" id="status" class="form-control">
                    <option value="">Izin/Sakit</option>
                    <option value="i">Izin</option>
                    <option value="s">Sakit</option>
                </select>
            </div>
            <div class="form-group">
                <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control"
                    placeholder="keterangan"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function () {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd",
                startDate: new Date(), // Tanggal minimum 26 tahun yang lalu
                autoclose: true // Menutup datepicker setelah memilih tanggal
            });

            $('#tgl_izin').change(function (e) {
                e.preventDefault();
                let tgl_izin = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "/presensi/cekpengajuanizin",
                    data: {
                        _token: "{{ csrf_token() }}",
                        tgl_izin: tgl_izin
                    },
                    cache: false,
                    success: function (response) {
                        if (response > 0) {
                            Swal.fire({
                                title: 'Oops!',
                                text: 'Anda sudah melakukan input pengajuan izin pada tanggal tersebut',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                $('#tgl_izin').val('')
                            });
                        }
                    }
                });
            });

            $('#fmizin').submit(function () {
                let tgl_izin = $('#tgl_izin').val();
                let status = $('#status').val();
                let keterangan = $('#keterangan').val();
                if (tgl_izin == '') {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Tanggal harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return false;
                } else if (status == '') {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Status harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return false;
                } else if (keterangan == '') {
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Keterangan harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return false;
                }
            })
        });
    </script>

@endpush