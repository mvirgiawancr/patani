<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .alert-custom {
        position: fixed;
        top: -100px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        width: 80%;
        max-width: 400px;
        opacity: 0;
        animation: slideIn 0.5s forwards, fadeOut 0.5s 2.5s forwards;
        text-align: center;
    }

    @keyframes slideIn {
        0% {
            top: -100px;
            opacity: 0;
        }

        100% {
            top: 20px;
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        0% {
            top: 20px;
            opacity: 1;
        }

        100% {
            top: -100px;
            opacity: 0;
        }
    }
</style>
{{-- Pesan Error --}}
@if(session('error'))
    <div class="alert alert-danger alert-custom">
        {{ session('error') }}
    </div>
@endif

{{-- Pesan Sukses --}}
@if(session('message'))
    <div class="alert alert-success alert-custom">
        {{ session('message') }}
    </div>
@endif


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('register_failed'))
    <div class="alert alert-danger">
        {{ session('register_failed') }}
    </div>
@endif

<div class="container mt-5 d-flex justify-content-center">
    <div class="card p-4 shadow" style="max-width: 700px; width: 100%;">
        <h2 class="text-center mb-4">Register</h2>
        <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Foto Profil -->
            <div class="form-group text-center">
                <div style="position: relative; display: inline-block;">
                    <img id="profilePreview" src="{{ asset('storage/produk_images/profildefault.png') }}"
                        alt="Foto Profil"
                        style="width: 150px; height: 150px; border-radius: 50%; border: 2px solid #ccc; object-fit: cover;">
                    <label for="profilePicture"
                        style="position: absolute; bottom: 0; right: 0; background-color: #f8f9fa; border-radius: 50%; padding: 8px; cursor: pointer; border: 1px solid #ccc;">
                        <i class="bi bi-camera-fill"></i>
                        <input type="file" id="profilePicture" name="profile_picture" accept="image/*"
                            style="display: none;" onchange="previewProfilePicture(event)">
                    </label>
                </div>
            </div>

            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <!-- No Telepon -->
            <div class="form-group">
                <label for="no_telepon">No Telepon</label>
                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
            </div>

            <!-- Alamat -->
            <div class="form-group">
                <label for="alamat_lengkap">Alamat Lengkap</label>
                <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" required rows="4"></textarea>
            </div>
            <!-- Tombol Set Lokasi -->
            <div class="form-group">
                <button type="button" id="setLocationButton" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#setLocationModal">
                    Set Lokasi
                </button>
            </div>
            <div>
                <input type="hidden" name="latitude" id="formLatitude">
                <input type="hidden" name="longitude" id="formLongitude">
            </div>

            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
            </div>
            <div class="form-group">
                <label for="kota">Kota</label>
                <input type="text" class="form-control" id="kota" name="kota" required>
            </div>

            <!-- Pilihan Role -->
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role">
                    <option value="petani">Petani</option>
                    <option value="pelanggan">Pelanggan</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3 w-100">Register</button>
        </form>


    </div>


</div>


<!-- Modal Set Lokasi -->
<div class="modal fade" id="setLocationModal" tabindex="-1" aria-labelledby="setLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="setLocationModalLabel">Pilih Lokasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Peta OpenStreetMap untuk Set Lokasi -->
                <div id="mapSet" style="height: 400px;"></div>
                <!-- Input Latitude dan Longitude -->
                <div class="mt-3">
                    <label for="latitude" class="form-label">Latitude</label>
                    <input type="text" id="latitude" class="form-control" readonly required>
                    <label for="longitude" class="form-label mt-2">Longitude</label>
                    <input type="text" id="longitude" class="form-control" readonly required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveLocationButton">Simpan Lokasi</button>
            </div>
        </div>
    </div>
</div>



<!-- Memastikan jQuery dipanggil terlebih dahulu -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS dan Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script>
    // Inisialisasi elemen modal dan peta
    let mapSet, marker;

    // Event listener untuk membuka modal
    document.getElementById('setLocationButton').addEventListener('click', function () {
        const modal = new bootstrap.Modal(document.getElementById('setLocationModal'));
        modal.show();
    });

    // Ketika modal ditampilkan
    $('#setLocationModal').on('shown.bs.modal', function () {
        if (!mapSet) {
            // Inisialisasi peta hanya saat pertama kali modal dibuka
            mapSet = L.map('mapSet').setView([-6.9175, 107.6191], 13); // Default ke Bandung
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(mapSet);

            // Tambahkan event click pada peta
            mapSet.on('click', function (e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                // Tambahkan atau pindahkan marker
                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(mapSet);
                }

                // Isi input latitude dan longitude
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            });
        }
    });

    // Event listener untuk menyimpan lokasi
    document.getElementById('saveLocationButton').addEventListener('click', function () {
        const latitude = document.getElementById('latitude').value;
        const longitude = document.getElementById('longitude').value;

        // Isi nilai latitude dan longitude ke form input hidden
        document.getElementById('formLatitude').value = latitude;
        document.getElementById('formLongitude').value = longitude;

        // Tutup modal menggunakan Bootstrap API
        const modal = bootstrap.Modal.getInstance(document.getElementById('setLocationModal'));
        modal.hide();
    });

    // Ketika modal ditutup
    $('#setLocationModal').on('hidden.bs.modal', function () {
        // Pastikan backdrop dihapus jika masih ada
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    });

    // Fungsi untuk preview gambar profil
    function previewProfilePicture(event) {
        const reader = new FileReader();
        reader.onload = function () {
            document.getElementById('profilePreview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Event listener untuk upload gambar profil
    document.getElementById('profilePicture').addEventListener('change', previewProfilePicture);

    // Pastikan tidak ada backdrop tertinggal saat semua modal ditutup
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.modal').forEach(function (modal) {
            modal.addEventListener('hidden.bs.modal', function () {
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
            });
        });
    });
</script>



</body>

</html>