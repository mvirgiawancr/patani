<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Icon Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="css/vendor.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/vendor.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
    rel="stylesheet">
    <style>
        /* Mengatur foto agar tidak terlalu besar dan responsif */
        .product-img img {
            width: 100%;
            max-width: 300px;
            height: auto;
            border: 1px solid #ddd;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        /* Tombol Kembali berada di atas kanan */
        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 999;
            align-items: center;
            font-size: 30px;
        }


        .product-details {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 20px;
        }

        /* Deskripsi penuh */
        .product-description {
            margin-top: 20px;
        }

        #mapSet {
            height: 400px;
        }
    </style>
</head>

<body class="bg-light">
    <!-- Tombol Kembali -->
    <a href="{{ route('home') }}" class="btn back-btn"><i class="bi bi-x"></i></a>

    <form action="/keranjang/tambah-db/{{ $produk->id_produk }}" method="POST">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- Konten Produk -->
            <div class="card col-12 col-md-8">
                <div class="card-body">
                   
                        <div class="product-details">
                        <!-- Foto Produk -->
                        <div class="product-img mb-3">
                            <img src="{{ asset('storage/' . $produk->foto) }}" alt="{{ $produk->nama_produk }}">
                        </div>

                        <!-- Nama Produk, Harga, dan Stok -->
                        <div class="product-info">
                            <h1>{{ $produk->nama_produk }}</h1>
                            <h5 class="font-weight-bold">RP. {{ number_format($produk->harga_produk, 0, ',', '.') }}</h5>
                            <p class="text"><strong>Stok:</strong> {{ $produk->stok }}</p>
                            <H5><i class="bi bi-person-fill"></i>
                                {{ $produk->user->username ?? 'Tidak diketahui'}}
                               
                            </H5>
                            <button type="button" class="btn btn-success" id="searchLocationBtn">
                                    Lihat Lokasi Penjual
                                    <I class="bi bi-geo-alt-fill"></I>
                                </button>
                            <input type="hidden" name="id_produk" value="${product.id_produk}">
                           

                          @csrf
                        </div>
                    
                    </div>

                    <!-- Deskripsi Penuh -->
                    <div class="product-description">
                        <p><strong>Deskripsi:</strong> {{ $produk->deskripsi }}</p>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary text-center mb-2">
                    <span>+ Keranjang</span>
                </button>
            </div>
        </div>
    </div>
    </form>

    <!-- Modal untuk Set Lokasi -->
    <div class="modal fade" id="setLocationModal" tabindex="-1" aria-labelledby="setLocationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setLocationModalLabel">Lokasi Penjual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @csrf
                <div class="modal-body">
                    <!-- Peta OpenStreetMap untuk Set Lokasi -->
                    <div id="mapSet"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Leaflet.js JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
document.getElementById('searchLocationBtn').addEventListener('click', function () {
    var latitude = {{ $produk->user->alamat->latitude ?? 'null' }};
    var longitude = {{ $produk->user->alamat->longitude ?? 'null' }};
    
    if (latitude !== null && longitude !== null) {
        // Menampilkan modal
        var myModal = new bootstrap.Modal(document.getElementById('setLocationModal'), {
            keyboard: false
        });
        myModal.show();

        // Inisialisasi peta dan marker
        var map = L.map('mapSet', {
            center: [latitude, longitude],  // Pusatkan peta pada lokasi penjual
            zoom: 13  // Level zoom awal
        });

        // Menambahkan layer peta OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Menambahkan marker di lokasi penjual
        L.marker([latitude, longitude]).addTo(map);

        // Update peta setelah modal terbuka untuk memastikan ukuran peta benar
        myModal._element.addEventListener('shown.bs.modal', function () {
            map.invalidateSize();  // Memperbaiki ukuran peta setelah modal dibuka
            map.setView([latitude, longitude], 13); // Memastikan peta terfokus pada lokasi penjual
        });

    } else {
        alert("Lokasi penjual tidak tersedia.");
    }
});

    </script>
</body>

</html>
