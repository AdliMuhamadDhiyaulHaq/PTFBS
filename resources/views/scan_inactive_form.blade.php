<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
@include('componen/header')
<title>Menu | Scan No Otomatis</title>

<style>
    .camera-container {
        position: relative;
        width: 100%;
        max-width: 640px;
        margin: 0 auto;
    }

    #video {
        max-width: 100%;
        max-height: 100%;
    }

    .scan-box {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 200px;
        height: 200px;
        border: 2px solid #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
</style>

<body>
    <div id="app">
        {{-- SIdebar --}}
        @include('componen/sidebar')
        <div class="layout-page">
            <div id="main">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div id="app" data-store-url="{{ route('scan.inactive.store') }}">
                    <div class="page-content">
                        @csrf
                        <div class="container">
                            <div class="page-content">
                                <div class="container">
                                    <div class="camera-container">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="text-center">Scan QR Otomatis Nonaktif</h6>
                                                <video id="video" playsinline></video>
                                                <canvas id="canvas" style="display: none;"></canvas>
                                                <div class="scan-box"></div>
                                                <button id="scanButton" type="button" class="btn btn-primary mt-3">Scan
                                                    Barcode</button>
                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const video = document.getElementById('video');
                        const canvas = document.getElementById('canvas');
                        const ctx = canvas.getContext('2d');
                        let scanning = false; // Ubah const menjadi let

                        function openCamera() {
                            navigator.mediaDevices.getUserMedia({
                                    video: true
                                })
                                .then(stream => {
                                    video.srcObject = stream;
                                    video.play();
                                })
                                .catch(err => {
                                    console.error(err);
                                    alert('Tidak dapat membuka kamera');
                                });
                        }

                        function detectQRCode() {
                            if (scanning) {
                                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                                // Sisipkan logika deteksi QR code di sini
                                const code = jsQR(ctx.getImageData(0, 0, canvas.width, canvas.height).data, canvas.width, canvas
                                    .height);
                                if (code) {
                                    console.log("QR Code terdeteksi:", code.data);
                                    sendQRDataToServer(code.data);
                                    scanning = false; // Setel scanning menjadi false setelah mendeteksi QR code
                                } else {
                                    requestAnimationFrame(detectQRCode);
                                }
                            }
                        }

                        // Tambahkan event listener untuk tombol "Scan barcode"
                        document.getElementById('scanButton').addEventListener('click', function() {
                            // Mulai pemindaian saat tombol ditekan
                            if (!scanning) {
                                scanning = true; // Setel scanning menjadi true untuk memulai pemindaian
                                detectQRCode(); // Panggil fungsi untuk mendeteksi QR code
                            }
                        });

                        function sendQRDataToServer(qrData) {
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                            fetch('/save-scan-inactive', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        kupon_code: qrData
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok.');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: data.message,
                                            showConfirmButton: false,
                                            timer: 2000
                                        }).then(() => {
                                            window.location.href = 'scan-inactive';
                                        });
                                    } else {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: data.error || 'Kupon sudah digunakan sebelumnya.',
                                            showConfirmButton: false,
                                            timer: 2000
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error("Kesalahan:", error);
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Terjadi kesalahan Kupon sudah tidak terdaftar atau sudah digunakan .',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                });
                        }

                        openCamera(); // Panggil fungsi untuk membuka kamera saat halaman dimuat
                    });
                </script>
                {{-- FOOTER --}}
            </div>
        </div>






        </html>
