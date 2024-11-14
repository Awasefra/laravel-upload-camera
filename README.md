
# Installations

## Create & Update env File

```
cp .env.example .env
```

###

## Generate project key

```
php artisan key:generate
```

## Link Storage

```
php artisan storage:link
```

### Launch Apps

```
php artisan serve
```

# Kamera dan Pengunggahan Gambar di Browser

Proyek ini menyediakan dua metode untuk mengakses dan mengunggah gambar dari kamera pada perangkat mobile atau desktop menggunakan HTML dan JavaScript:

1. **Input File Kamera (Capture dari Browser)**
2. **HTML5 Camera API (Menggunakan `getUserMedia()`)**

Dengan dua metode ini, pengguna dapat memilih cara yang paling sesuai untuk mengambil gambar, baik melalui input file yang sederhana atau dengan fitur canggih dari HTML5 Camera API untuk tampilan video langsung dan pengaturan kamera.

## Fitur Utama

### 1. Input File Kamera (Capture dari Browser)
HTML menyediakan input tipe file dengan atribut `capture="camera"` untuk membuka kamera pada perangkat mobile. Fitur ini bekerja sebagai berikut:

- **Ambil Gambar**: Ketika pengguna mengklik tombol **Ambil Gambar**, fungsi `openCamera()` akan membuka kamera atau galeri perangkat.
- **Pratinjau Gambar**: Setelah gambar diambil, event `change` pada elemen input membaca file gambar dan menggunakan `FileReader` untuk menampilkan pratinjau gambar di halaman.
- **Kelebihan**: Sederhana dan didukung secara luas di berbagai perangkat dan browser.

### 2. HTML5 Camera API (Menggunakan `getUserMedia()`)
HTML5 Camera API menggunakan `navigator.mediaDevices.getUserMedia()` untuk mengakses kamera perangkat secara langsung. Fitur ini memberikan lebih banyak fleksibilitas, termasuk:

- **Live Preview**: Stream video langsung dari kamera ditampilkan dalam elemen `<video>`.
- **Ambil Snapshot**: Fungsi `take_snapshot_getUserMedia()` memungkinkan pengguna untuk mengambil gambar dari video live.
  - Mengatur resolusi canvas dengan lebar maksimum 720 piksel.
  - Mengonversi gambar dari video menjadi data gambar berbentuk base64.
  - Menyimpan data base64 dalam elemen `<input type="hidden">` untuk keperluan pengunggahan ke server.
- **Ganti Kamera**: Fungsi `toggleCamera()` memungkinkan pengguna beralih antara kamera depan dan belakang dengan mengubah properti `facingMode`.
  
#### Cara Kerja HTML5 Camera API

1. **Mengakses Kamera**: 
   - Menggunakan `navigator.mediaDevices.getUserMedia()` untuk meminta izin akses kamera.
   - Properti `facingMode` pada opsi video digunakan untuk memilih kamera depan (`user`) atau belakang (`environment`).
2. **Pengambilan Gambar (Snapshot)**:
   - Dengan menggunakan elemen `canvas`, gambar dapat diambil dari video stream dan diubah menjadi format base64, memungkinkan untuk disimpan atau diunggah ke server.

## Cara Menggunakan

### Prasyarat
- Browser yang mendukung HTML5 dan `getUserMedia` API.
- Perangkat dengan kamera untuk mencoba fitur-fitur ini.

### Instalasi
Tidak diperlukan instalasi tambahan. Cukup buka file HTML di browser untuk mencoba fitur-fitur ini.

### Penggunaan

1. **Metode Input File Kamera**:
   - Klik tombol **Ambil Gambar** untuk membuka kamera atau galeri.
   - Pilih atau ambil gambar, dan gambar akan ditampilkan sebagai pratinjau.

2. **Metode HTML5 Camera API**:
   - Klik **Buka Kamera** untuk mengaktifkan video live dari kamera.
   - Gunakan **Ambil Snapshot** untuk mengambil gambar dari stream video.
   - Klik **Ganti Kamera** untuk beralih antara kamera depan dan belakang (hanya pada perangkat yang mendukung fitur ini).

## Catatan Tambahan

- Metode Input File Kamera mungkin lebih kompatibel di berbagai perangkat mobile, sedangkan HTML5 Camera API lebih fleksibel namun membutuhkan izin khusus dari pengguna.
- Untuk keamanan, pastikan perangkat memiliki izin akses kamera diaktifkan untuk browser.

## Dukungan Browser

HTML5 Camera API (`getUserMedia()`) didukung pada sebagian besar browser modern seperti Chrome, Firefox, dan Edge. Namun, dukungan di perangkat iOS dan Safari mungkin terbatas atau membutuhkan versi terbaru.

## Lisensi

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
