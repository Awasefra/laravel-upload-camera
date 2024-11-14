<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gambar dengan Kamera</title>
</head>

<body>
    @if (session('success'))
        <p>{{ session('success') }}</p>
        <img src="{{ asset('storage/images/' . session('filename')) }}" alt="Uploaded Image" width="200">
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <h2>Ambil Gambar dari Kamera</h2>
    <form id="uploadForm" action="{{ route('upload.image') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" id="cameraInput" accept="image/*" capture="camera" style="display:none;" name="image" required>
        <button type="button" onclick="openCamera()">Ambil Gambar</button>
        <br>
        <img id="previewImage" src="" alt="Preview Gambar" style="display:none; width: 200px; margin-top: 10px;">
        <br>
        <button type="submit">Upload</button>
    </form>

    <script>
        function openCamera() {
            const inputFile = document.getElementById('cameraInput');
            inputFile.click();
        }

        document.getElementById('cameraInput').addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                // Menampilkan preview gambar sebelum disubmit
                reader.onload = function (e) {
                    const previewImage = document.getElementById('previewImage');
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';  // Menampilkan gambar
                };
                
                reader.readAsDataURL(file);  // Membaca file sebagai Data URL
            }
        });
    </script>
</body>

</html>
