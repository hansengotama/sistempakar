@extends('layouts.app')

@section('style')
    <style>
        .login-text {
            margin-bottom: 1em;
            font-size: 24px;
        }
        .form-container {
            margin: 0 3em;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row mt-lg-5">
        <div class="col-md-6">
            <img src="{{ url('img/benign.jpeg') }}" alt="benign" width="100%">
        </div>
        <div class="col-md-6">
            <h3><b>Benign prostatic hyperplasia (BPH)</b></h3>
            <p>
                Pembesaran prostat jinak merupakan kondisi dimana kelenjar prostat mengalami pembengkakan akan tetapi belum bersifat kanker. Kelenjar prostat merupakan sebuah kelenjar berukuran kecil yang berada pada rongga pinggul diantara kandung kemih dan penis.
                Kelenjar prostat menghasilkan cairan yang berfungsi untuk menyuburkan dan melindungi sel-sel sperma. Pada saat terjadi ejakulasi, prostat akan berkontraksi sehingga cairan tersebut akan dikeluarkan bersamaan dengan sperma, hingga menghasilkan cairan semen.
            </p>
        </div>
    </div>
    <div class="row mt-lg-5">
        <div class="col-md-6">
            <img src="{{ url('img/prostatitis.jpeg') }}" alt="prostatitis" width="100%">
        </div>
        <div class="col-md-6">
            <h3><b>Prostatitis</b></h3>
            <p>
                Prostatitis merupakan peradangan atau pembengkakan pada kelenjar prostat. Prostatitis lebih sering terjadi pada pria yang berusia lebih muda, antara 30-50 tahun. Prostatitis biasanya disebabkan oleh infeksi bakteri, yang bisa berasal dari infeksi saluran kemih atau dari penyakit menular seksual. Namun pada beberapa kasus, penyebab prostatitis tidak dapat diketahui dengan pasti.
            </p>
        </div>
    </div>
    <div class="row mt-lg-5">
        <div class="col-md-6">
            <img src="{{ url('img/kankerprostat.jpeg') }}" alt="kankerprostat" width="100%">
        </div>
        <div class="col-md-6">
            <h3><b>Kanker Prostat</b></h3>
            <p>
                Kanker Prostat merupakan suatu penyakit yang menyerang pada kelenjar prostat yang berada pada sistem reproduksi laki-laki. Penyakit ini dapat terjadi apabila sel-sel prostat tumbuh secara tidak normal dan berlebihan sehingga merusak jaringan sekitarnya. Kanker ini sering menyerang laki-laki yang berumur diatas 50 tahun, diantaranya 30% menyerang laki-laki pada usia diantara 70 sampai 90 tahun dan 75% menyerang pada usia 80 tahun keatas. Kanker ini jarang menyerang laki-laki yang masih berusia di bawah 45 tahun (Purnomo, 2011).
            </p>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>

    </script>
@endsection