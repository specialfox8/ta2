@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
    <div class="box-footer">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <p style="text-align: center; font-size: 2rem; margin-bottom: 10px;">
                        CV. Gloria Felkent Jaya
                    </p>
                    <h1
                        style="text-align: justify; font-size: 1.5rem; line-height: 1.8; margin-bottom: 10px; margin-left: 10px;margin-right: 10px;">
                        CV Gloria Felkent Jaya merupakan perusahan yang bergerak pada bidang penjualan barang-barang
                        kebersihan.
                        Perusahaan ini didirikan pada tahun 2020 yang memiliki alamat di Komplek Gempol Asri estate blok 9
                        no 6
                        Cigondewah, Cijerah, kota Bandung, Jawa Barat. Awal mulanya perusahaan ini hanya melakukan penjualan
                        dengan membeli barang-barang di pasar dan langsung menjualnya kembali ke pelanggan. Usaha ini
                        awalnya
                        dijalankan dengan lingkup usaha yang kecil dan tanpa karyawan tambahan dan gudang untuk penyimpanan
                        barang.
                        Perkembangannya dimulai oleh sang pemilik yang memutuskan mengundurkan diri dari pekerjaan
                        sebelumnya
                        agar lebih fokus pada usaha ini. Keputusan itu pun membuat dampak yang cukup besar dengan mulai
                        memiliki
                        gudang penyimpanan sendiri, sudah memiliki supplier yang langsung dari perusahaannya dan sudah mulai
                        mempekerjakan sejumlah karyawan. Akhirnya perusahaan ini berubah menjadi CV Gloria Felken Jaya pada
                        tahun 2024. Setelah menjadi CV, perusahaan ini merektrut beberapa karyawan. Tugas dari karyawan ini
                        dianataranya sebagai bagian gudang, pengiriman, penjualan, pembelian dan bagian administrasi.
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- images -->
    <div class="image-slider" style="position: relative; width: 100%; overflow: hidden;">
        <div class="slider-images" style="display: flex; transition: transform 0.5s ease; gap: 10px;">
            <div class="slider-item">

                <img src="{{ asset('image/1.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 1">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/2.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 2">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/3.jpg') }}" class="d-block w-10 "
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 3">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/4.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 4">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/5.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 1">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/6.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 2">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/7.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 3">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/8.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 4">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/9.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 1">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/10.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 2">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/11.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 3">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/12.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 4">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/13.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 1">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/14.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 2">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/15.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 3">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/16.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 4">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/17.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 1">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/18.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 2">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/19.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 3">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/20.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 4">

            </div>
            <div class="slider-item">

                <img src="{{ asset('image/21.jpg') }}" class="d-block w-10"
                    style="width: 100%; height: auto; max-width: 10cm;" alt="Image 4">

            </div>
        </div>
        <!-- Navigation Buttons -->
    </div>
@endsection
