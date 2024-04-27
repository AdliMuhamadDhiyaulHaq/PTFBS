<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
@include('componen/header')
<title>Menu | Scan Otomatis</title>

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
                <div id="app" data-store-url="{{ route('scan.active.store') }}">
                    <div class="page-content">
                        @csrf
                        <div class="container">
                            <div class="page-content">
                                <div class="container">
                                    <div class="camera-container">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="camera-container">
                                                    <h6 class="text-center">Scan QR Otomatis Aktif</h6>
                                                    <video id="video" playsinline></video>
                                                    <canvas id="canvas" style="display: none;"></canvas>
                                                    <div class="scan-box"></div>
                                                </div>
                                            </div>

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
                                requestAnimationFrame(detectQRCode);
                            })
                            .catch(err => {
                                console.error(err);
                                alert('Tidak dapat membuka kamera');
                            });
                    }

                    function detectQRCode() {
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                        // Hitung titik tengah layar
                        const centerX = canvas.width / 2;
                        const centerY = canvas.height / 2;

                        // Tentukan ukuran area pencarian QR code
                        const boxSize = 200;

                        // Dapatkan data citra dari area di sekitar titik tengah
                        const qrImageData = ctx.getImageData(centerX - boxSize / 2, centerY - boxSize / 2, boxSize,
                            boxSize);

                        // Lakukan proses citra sederhana (opsional)

                        // Lakukan deteksi tepi (opsional)

                        // Gunakan library deteksi QR code untuk menemukan QR code dalam qrImageData
                        const code = jsQR(qrImageData.data, qrImageData.width, qrImageData.height);

                        // Jika QR code terdeteksi, lakukan sesuatu dengan data QR code
                        if (code) {
                            console.log("QR Code terdeteksi:", code.data);
                            // Lakukan sesuatu dengan data QR code, misalnya kirim ke server
                            sendQRDataToServer(code.data);
                        } else {
                            // Jika tidak, lanjutkan pemindaian dengan memanggil requestAnimationFrame(detectQRCode)
                            requestAnimationFrame(detectQRCode);
                        }
                    }


                    function sendQRDataToServer(qrData) {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        fetch('/save-scan-active', {
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
                                    throw new Error('Network response was not ok.'); // Tangani kesalahan jaringan
                                }
                                return response.json(); // Ambil respons JSON jika respons OK
                            })
                            .then(data => {
                                if (data.success) {
                                    // Jika respons sukses, tampilkan pesan sukses
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: data.message,
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then(() => {
                                        window.location.href = 'scan-active';
                                    });
                                } else {
                                    // Jika respons gagal, tampilkan pesan kesalahan
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
                                // Tangani kesalahan umum
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






                    openCamera();
                });
            </script>
            {{-- FOOTER --}}
        </div>
    </div>






    </html>
