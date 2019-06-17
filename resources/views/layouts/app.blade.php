<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('img/logo.png') }}">
    <title>Sistem Pakar</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <!-- Font google -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,400i,600,600i,700,700i,900,900i" rel="stylesheet">
    <!--  Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .heading-container {
            padding: 1em 0;
            text-align: center;
            font-size: 28px;
        }
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #343a40;
            color: white;
            text-align: center;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    @yield('style')
</head>
<body>
    <div id="app">
        <div class="heading-container">
            <div>SISTEM PAKAR DIAGNOSA PENYAKIT KANKER PROSTAT</div>
        </div>

        @if(Auth::user())
            <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

                <ul class="navbar-nav">
                @if(Auth::user()->role == 'admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Data
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/question-view">Question</a>
                            <a class="dropdown-item" href="/disease-view">Disease</a>
                            <a class="dropdown-item" href="/solution-view">Solution</a>
                            <a class="dropdown-item" href="/disease-solution-view">Disease Solution</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                            Laporan
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/patient list-view">Patient List</a>
                            <a class="dropdown-item" href="/laporan-konsultasi">Laporan Konsultasi</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Keluar</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/home-patient">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/consultation-view">Consultation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Keluar</a>
                    </li>
                @endif
                </ul>
            </nav>
        @endif

        @yield('content')
        <div class="footer">
            <span>© Sistem Pakar Diagnosa Penyakit Kanker Prostat</span>
        </div>
    </div>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <!-- DataTable -->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!-- Sweet Alert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.11/dist/sweetalert2.all.min.js"></script>
    <!-- Axios -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- Vue -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>

    @yield('script')
</body>
</html>
