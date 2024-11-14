<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gambar dengan Kamera</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-4xl">
        <h1 class="text-3xl font-bold text-center mb-6">Gallery Gambar</h1>

        <!-- Tampilkan gambar dari server -->
        <div class="grid grid-cols-3 gap-6 mb-12">
            @foreach ($imagePaths as $image)
            <div class="bg-white rounded-lg shadow-lg p-4">
                <img src="{{ asset($image) }}" alt="Image" class="w-full h-auto rounded-lg">
            </div>
            @endforeach
        </div>

        <!-- Form Upload -->
        <div class="bg-white shadow-lg rounded-lg p-6 w-96 mx-auto">
            <h1 class="text-2xl font-semibold text-center text-gray-800 mb-6">Upload Gambar dengan Kamera</h1>

            <!-- Menampilkan pesan sukses/error -->
            @if(session('success'))
            <div class="mb-4 text-green-500 text-center">
                {{ session('success') }}
            </div>
            @elseif(session('error'))
            <div class="mb-4 text-red-500 text-center">
                {{ session('error') }}
            </div>
            @endif

            <!-- Form Upload menggunakan Input File -->
            <form id="uploadFormInputFile" action="{{ route('upload.image') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="text-center mb-4">
                    <input type="file" id="cameraInput" accept="image/*" capture="camera" style="display:none;"
                        name="image" required>
                    <button type="button" onclick="openCamera()"
                        class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition-all duration-200">
                        Ambil Gambar
                    </button>
                </div>

                <div class="text-center">
                    <img id="previewImageInputFile" src="" alt="Preview Gambar" class="hidden rounded-md shadow-md"
                        style="max-width: 200px; margin-top: 10px;">
                </div>

                <div class="mt-6 text-center">
                    <button type="submit"
                        class="px-6 py-3 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600 transition-all duration-200">
                        Upload
                    </button>
                </div>
            </form>

            <!-- Form Upload menggunakan HTML5 getUserMedia API -->
            <form id="uploadFormGetUserMedia" action="{{ route('upload.image2') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <h2 class="text-xl text-center mb-4">HTML5 Camera API Upload</h2>
                <video id="videoElement" autoplay class="w-full rounded-md"></video>
                <button type="button" onclick="take_snapshot_getUserMedia()"
                    class="px-6 py-3 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition-all duration-200 mt-4">
                    Ambil Gambar (HTML5 Camera API)
                </button>
                <button type="button" onclick="toggleCamera()"
                    class="px-6 py-3 bg-yellow-500 text-white rounded-lg shadow-md hover:bg-yellow-600 transition-all duration-200 mt-4">
                    Ganti Kamera (Depan / Belakang)
                </button>
                <div id="getUserMediaPreview" class="mt-4"></div>
                <input type="hidden" name="image" id="base64imageGetUserMedia" />
                <div class="mt-6 text-center">
                    <button type="submit"
                        class="px-6 py-3 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600 transition-all duration-200">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Fungsi untuk membuka kamera menggunakan input file
        function openCamera() {
            const inputFile = document.getElementById('cameraInput');
            inputFile.click();
        }

        // Menampilkan preview gambar dari input file
        document.getElementById('cameraInput').addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const previewImage = document.getElementById('previewImageInputFile');
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';  // Menampilkan gambar
                };
                reader.readAsDataURL(file);
            }
        });

        // HTML5 Camera API
        const video = document.getElementById('videoElement');
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        let currentStream = null;
        let currentFacingMode = 'environment'; // Default ke kamera belakang

        // Fungsi untuk memulai video stream menggunakan kamera belakang
        function startVideo() {
            // Pastikan untuk menghentikan stream lama sebelum memulai yang baru
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());  // Stop all tracks from old stream
            }

            // Ambil video stream berdasarkan facingMode
            navigator.mediaDevices.getUserMedia({
                video: { facingMode: currentFacingMode, width: 1280, height: 720 } // Optimalkan resolusi video
            })
            .then(function(stream) {
                currentStream = stream;
                video.srcObject = stream;
            })
            .catch(function(error) {
                console.error("Akses kamera gagal:", error);
                alert('Tidak dapat mengakses kamera: ' + error);
            });
        }

        // Ambil snapshot dari HTML5 Camera API
        function take_snapshot_getUserMedia() {
        const maxWidth = 720; // Lebar maksimum

        // Menentukan rasio aspek dari video
        const aspectRatio = video.videoHeight / video.videoWidth;

        // Menyesuaikan tinggi sesuai rasio aspek
        canvas.width = maxWidth;
        canvas.height = maxWidth * aspectRatio;

        // Menggambar gambar dari video ke canvas
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Mengonversi canvas ke base64 dengan kompresi 70%
        const dataUrl = canvas.toDataURL('image/jpeg', 0.7);

        // Menampilkan preview gambar
        const preview = document.getElementById('getUserMediaPreview');
        preview.innerHTML = '<img src="' + dataUrl + '" class="rounded-md shadow-md" style="max-width: 200px;" />';
        
        // Menyimpan data gambar ke input hidden untuk dikirim ke server
        document.getElementById('base64imageGetUserMedia').value = dataUrl;
    }


        // Fungsi untuk mengganti antara kamera depan dan belakang
        function toggleCamera() {
            // Ganti facingMode antara 'user' (kamera depan) dan 'environment' (kamera belakang)
            currentFacingMode = (currentFacingMode === 'environment') ? 'user' : 'environment';
            startVideo();  // Restart video dengan facingMode yang baru
        }

        // Mulai stream video ketika halaman dimuat
        window.onload = function() {
            startVideo();  // Mulai kamera belakang secara default
        };
    </script>
</body>

</html>