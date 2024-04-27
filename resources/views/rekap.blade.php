<link rel="stylesheet" href="assets/extensions/simple-datatables/style.css">
<link rel="stylesheet" href="assets/css/pages/simple-datatables.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
<title>Menu | Laporan</title>
@include('componen/header')

<title>Menu | Scan No Otomatis</title>



<body>
    <div id="app">
        {{-- SIdebar --}}
        @include('componen/sidebar')
        <div class="layout-page">
            <div id="main">
                <meta name="csrf-token" content="{{ csrf_token() }}">

                <div class="page-content">
                    <section class="section">
                        <div class="card">
                            <div class="card-header">
                                Data Pencatatan Kupon Makanan
                            </div>
                            <div class="card-body">
                                <!-- Form untuk pencarian berdasarkan tanggal -->
                                <form action="{{ route('laporan.show') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tanggal_awal">Tanggal Awal</label>
                                                <input type="date" class="form-control" id="tanggal_awal"
                                                    name="tanggal_awal" value="{{ request()->input('tanggal_awal') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tanggal_akhir">Tanggal Akhir</label>
                                                <input type="date" class="form-control" id="tanggal_akhir"
                                                    name="tanggal_akhir"
                                                    value="{{ request()->input('tanggal_akhir') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>&nbsp;</label>
                                                <button type="submit"
                                                    class="btn btn-primary form-control">Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- Tabel untuk menampilkan data rekap -->
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>Kupon Kode</th>
                                            <th>Tanggal Penukaran</th>
                                            <th>Metode Scan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($laporanRekap as $data)
                                            <tr>
                                                <td>{{ $data->kupon_code }}</td>
                                                <td>{{ $data->scan_time }}</td>
                                                <td>
                                                    @if ($data->scan_method == 'Aktif')
                                                        <span class="badge bg-success">{{ $data->scan_method }}</span>
                                                    @elseif ($data->scan_method == 'Nonaktif')
                                                        <span class="badge bg-danger">{{ $data->scan_method }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $data->scan_method }}</span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </section>
                </div>


            </div>





        </div>
    </div>
    <script src="assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="assets/js/pages/simple-datatables.js"></script>

    @include('componen/footer')

</body>

</html>
