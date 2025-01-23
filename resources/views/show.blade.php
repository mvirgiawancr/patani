<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        .product-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .product-details .product-img {
            max-width: 500px;
            width: 100%;
            border: 1px solid #ddd;
        }
        .product-details .product-info {
            max-width: 600px;
            margin-left: 30px;
        }
        .back-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 999;
        }
    </style>
</head>
<body>
    <!-- Tombol Kembali -->
    <a href="{{ route('home') }}" class="btn btn-primary back-btn">Kembali</a>

    <div class="container mt-5">
        <div class="product-details">
            <!-- Foto Produk -->
            <div class="product-img">
                <img src="{{ asset('storage/' . $produk->foto) }}" class="img-fluid" alt="{{ $produk->nama_produk }}">
            </div>

            <!-- Deskripsi dan Detail Produk -->
            <div class="product-info">
                <h2>{{ $produk->nama_produk }}</h2>
                <p><strong>Deskripsi:</strong> {{ $produk->deskripsi }}</p>
                <p><strong>Harga:</strong> RP. {{ number_format($produk->harga_produk, 0, ',', '.') }} /KG</p>
                <p><strong>Stok:</strong> {{ $produk->stok }} Unit</p>
                <a href="{{ route('home') }}" class="btn btn-success mt-3">Kembali ke Home</a>
            </div>
        </div>
    </div>

</body>
</html>
