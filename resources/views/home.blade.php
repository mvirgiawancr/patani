<!DOCTYPE html>
<html lang="en">

<head>
  <title>Patani</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="author" content="">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="csrf-token">

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
</head>
<style>
  .form-check-input {
    border: .5px solid black;
    /* Warna border biru */
    border-radius: 4px;
    /* Membuat sudut checkbox lebih melengkung */
    padding: 8px;
    /* Memberi ruang di dalam checkbox */
  }

  .form-check-input:checked {
    background-color: #000;
    /* Warna latar belakang saat dicentang */
    border-color: #000;
    /* Warna border saat dicentang */
  }

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

  input.form-control.form-control-sm.input-number {
    max-width: 50px !important;
  }

  .product-item:hover {
    box-shadow: none;
    /* Menghilangkan shadow ketika di-hover */
  }
</style>

<body>
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

  {{-- Pesan sukses --}}
  @if(session('success'))
    <div class="alert alert-success alert-custom">
    {{ session('success') }}
    </div>
  @endif


  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <defs>
      <symbol xmlns="http://www.w3.org/2000/svg" id="link" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M12 19a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0-4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm-5 0a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm7-12h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v14a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3Zm1 17a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-9h16Zm0-11H4V6a1 1 0 0 1 1-1h1v1a1 1 0 0 0 2 0V5h8v1a1 1 0 0 0 2 0V5h1a1 1 0 0 1 1 1ZM7 15a1 1 0 1 0-1-1a1 1 0 0 0 1 1Zm0 4a1 1 0 1 0-1-1a1 1 0 0 0 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="arrow-right" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M17.92 11.62a1 1 0 0 0-.21-.33l-5-5a1 1 0 0 0-1.42 1.42l3.3 3.29H7a1 1 0 0 0 0 2h7.59l-3.3 3.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l5-5a1 1 0 0 0 .21-.33a1 1 0 0 0 0-.76Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="category" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M19 5.5h-6.28l-.32-1a3 3 0 0 0-2.84-2H5a3 3 0 0 0-3 3v13a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-10a3 3 0 0 0-3-3Zm1 13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-13a1 1 0 0 1 1-1h4.56a1 1 0 0 1 .95.68l.54 1.64a1 1 0 0 0 .95.68h7a1 1 0 0 1 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="calendar" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M19 4h-2V3a1 1 0 0 0-2 0v1H9V3a1 1 0 0 0-2 0v1H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3Zm1 15a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-7h16Zm0-9H4V7a1 1 0 0 1 1-1h2v1a1 1 0 0 0 2 0V6h6v1a1 1 0 0 0 2 0V6h2a1 1 0 0 1 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="heart" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M20.16 4.61A6.27 6.27 0 0 0 12 4a6.27 6.27 0 0 0-8.16 9.48l7.45 7.45a1 1 0 0 0 1.42 0l7.45-7.45a6.27 6.27 0 0 0 0-8.87Zm-1.41 7.46L12 18.81l-6.75-6.74a4.28 4.28 0 0 1 3-7.3a4.25 4.25 0 0 1 3 1.25a1 1 0 0 0 1.42 0a4.27 4.27 0 0 1 6 6.05Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="plus" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M19 11h-6V5a1 1 0 0 0-2 0v6H5a1 1 0 0 0 0 2h6v6a1 1 0 0 0 2 0v-6h6a1 1 0 0 0 0-2Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="minus" viewBox="0 0 24 24">
        <path fill="currentColor" d="M19 11H5a1 1 0 0 0 0 2h14a1 1 0 0 0 0-2Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="cart" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M8.5 19a1.5 1.5 0 1 0 1.5 1.5A1.5 1.5 0 0 0 8.5 19ZM19 16H7a1 1 0 0 1 0-2h8.491a3.013 3.013 0 0 0 2.885-2.176l1.585-5.55A1 1 0 0 0 19 5H6.74a3.007 3.007 0 0 0-2.82-2H3a1 1 0 0 0 0 2h.921a1.005 1.005 0 0 1 .962.725l.155.545v.005l1.641 5.742A3 3 0 0 0 7 18h12a1 1 0 0 0 0-2Zm-1.326-9l-1.22 4.274a1.005 1.005 0 0 1-.963.726H8.754l-.255-.892L7.326 7ZM16.5 19a1.5 1.5 0 1 0 1.5 1.5a1.5 1.5 0 0 0-1.5-1.5Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="check" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M18.71 7.21a1 1 0 0 0-1.42 0l-7.45 7.46l-3.13-3.14A1 1 0 1 0 5.29 13l3.84 3.84a1 1 0 0 0 1.42 0l8.16-8.16a1 1 0 0 0 0-1.47Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="trash" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M10 18a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1ZM20 6h-4V5a3 3 0 0 0-3-3h-2a3 3 0 0 0-3 3v1H4a1 1 0 0 0 0 2h1v11a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8h1a1 1 0 0 0 0-2ZM10 5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h-4Zm7 14a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1V8h10Zm-3-1a1 1 0 0 0 1-1v-6a1 1 0 0 0-2 0v6a1 1 0 0 0 1 1Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="star-outline" viewBox="0 0 15 15">
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
          d="M7.5 9.804L5.337 11l.413-2.533L4 6.674l2.418-.37L7.5 4l1.082 2.304l2.418.37l-1.75 1.793L9.663 11L7.5 9.804Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="star-solid" viewBox="0 0 15 15">
        <path fill="currentColor"
          d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="user" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19ZM12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4Z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 15 15">
        <path fill="currentColor"
          d="M7.953 3.788a.5.5 0 0 0-.906 0L6.08 5.85l-2.154.33a.5.5 0 0 0-.283.843l1.574 1.613l-.373 2.284a.5.5 0 0 0 .736.518l1.92-1.063l1.921 1.063a.5.5 0 0 0 .736-.519l-.373-2.283l1.574-1.613a.5.5 0 0 0-.283-.844L8.921 5.85l-.968-2.062Z" />
      </symbol>
    </defs>
  </svg>


  <!-- --------------------------------------------Modal Notifikasi Pesanan------------------------------------------- -->

  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="orderNotificationModal"
    aria-labelledby="orderNotificationModalLabel" style="width: 35%; max-width: none;">
    <div class="offcanvas-header justify-content-center">
      <button type="button" class="btn-close ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="mb-3">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Pesanan Anda</span>
        </h4>
        <hr>
        @if($orders && $orders->count() > 0)
      @foreach ($orders as $order)
      <div class="card">
      <div class="card-body">
      <!-- Nama Toko (Petani) dan ID Transaksi -->
      <div class="d-flex justify-content-between">
        <div>
        <h6><strong>Nama Toko:</strong> {{ $order->penjual->username }}</h6>
        <p><strong>ID Transaksi:</strong> {{ $order->id_pesanan }}</p>
        @if($order->status == "dikirim")
      <p><strong>Resi : </strong> {{ $order->resi }}</p>
    @endif
        </div>
        <div>
        <!--Keterangan Status -->
        <div class="btn" @if($order->status == 'menunggu pembayaran') style="background-color: red; color: white;"
    @elseif($order->status == 'dikirim' || $order->status == 'diproses')
  style="background-color: green; color: white;" @elseif($order->status == 'selesai')
style="background-color: grey; color: white;" @endif>
        {{ $order->status }}
        </div>
        </div>
      </div>

      <!-- Daftar Produk yang Dibeli -->
      <h6><strong>Produk yang Dibeli:</strong></h6>
      <ul class="list-group mb-3 productList">
        @foreach ($order->detailPesanan as $key => $item)
      <li
      class="list-group-item d-flex justify-content-between product-item produk-notif {{ $key >= 3 ? 'd-none' : '' }}"
      style="background-color:#F5F5F5;">
      <div class="row align-items-center">
      <div class="col">
      <h6 class="my-0">{{ $item->produk->nama_produk }}</h6>
      <p class="mb-1">{{ $item->produk->user->username }}</p>
      <p><strong>Jumlah:</strong> {{ $item->jumlah }}</p>
      </div>
      <div class="text-end">
      <span class="text-end">RP. {{ number_format($item->produk->harga_produk, 2) }}</span>
      </div>
      </div>
      </li>
    @endforeach
      </ul>

      <!-- Tombol Show More / Show Less -->
      <div class="text-center">
        <button class="toggle-button" style="background-color:white; border:none;">
        <i class="bi bi-chevron-down"></i>
        </button>
      </div>

      <!-- Total Harga -->
      <div class="d-flex justify-content-between text-end mt-3">
        <span><strong>Total Harga: RP. {{ number_format($order->total_harga, 2) }}</strong></span>
        @if ($order->status === 'dikirim')
      <button class="btn btn-success" onclick="confirmSelesaikanPesanan({{ $item->id_pesanan }})">
      Selesaikan Pesanan
      </button>
    @endif
      </div>

      <!-- Tombol Unggah Bukti Pembayaran hanya jika status 'menunggu pembayaran' -->
      @if ($order->status === 'menunggu pembayaran')
      <button class="btn btn-success" data-bs-toggle="modal"
      data-bs-target="#modalPembayaran{{ $order->id_pesanan }}">
      Unggah Bukti Pembayaran
      </button>
    @endif
      </div>
      </div>
    @endforeach
    @else
    <p>Belum ada transaksi.</p>
  @endif
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const produkGroups = document.querySelectorAll('.card');

      produkGroups.forEach(group => {
        const toggleButton = group.querySelector('.toggle-button');
        const productItems = group.querySelectorAll('.produk-notif');
        let isExpanded = false; // Default: tertutup

        // Pastikan produk di minimize saat halaman pertama kali dimuat
        productItems.forEach((item, index) => {
          if (index >= 1) {
            item.classList.add('d-none'); // Sembunyikan produk selain yang pertama
          }
        });

        toggleButton.addEventListener('click', () => {
          isExpanded = !isExpanded;

          productItems.forEach((item, index) => {
            if (index >= 1) {
              item.classList.toggle('d-none', !isExpanded); // Tampilkan/sembunyikan produk
            }
          });

          toggleButton.innerHTML = isExpanded ? '<i class="bi bi-chevron-up"></i>' : '<i class="bi bi-chevron-down"></i>';
        });
      });
    });
  </script>



  <!---------------------------------- modal keranjang---------------------------------------------------------------------------------------------- -->

  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasCart" aria-labelledby="My Cart">
    <div class="offcanvas-header justify-content-center">
      <button type="button" class="btn-close ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Keranjang</span>
        </h4>
        <hr>
        <!-- Checkbox "Semua" untuk memilih semua produk -->
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleDeleteButton()"
              style="margin-right:10px;">
            <label class="form-check-label" for="selectAll">Pilih Semua</label>
          </div>
          <div class="ms-auto">
            <button id="deleteSelectedButton" class="btn btn-danger btn-sm d-none ms-auto" onclick="deleteSelected()">
              <i class="bi bi-trash"></i> <!-- Ikon hapus -->
            </button>
          </div>

        </div>






        @if (empty($keranjangItems))
      <p>Keranjang Kamu Kosong</p>
    @else
    <ul class="list-group mb-3">
      @foreach ($keranjangItems as $item)
      <li class="list-group-item">
      <div class="row align-items-center">
      <!-- Checkbox and product details -->
      <div class="col-auto">
      <input type="checkbox" class="form-check-input select-item" data-id="{{ $item->id_keranjang }}"
        data-id_produk="{{ $item->produk->id_produk }}" data-harga="{{ $item->produk->harga_produk}}"
        data-jumlah="{{ $item->jumlah }}" id_penjual="{{ $item->produk->id_user }}" onchange="updateTotal()">
      </div>

      <!-- Product name and seller -->
      <div class="col">
      <h6 class="my-0">{{ $item->produk->nama_produk }}</h6>
      <p class="mb-1">{{ $item->produk->user->username }}</p>
      </div>

      <!-- Price -->
      <div class="col-md-3 text-end">
      <span class="text-body-secondary">
        {{ number_format($item->produk->harga_produk, 2) }}
      </span>
      </div>
      </div>
      <!-- Quantity control (under price) -->
      <div class="row">
      <div class="col-md-12 text-end">
      <div class="input-group justify-content-end">
        <button type="button" class="quantity-left-minus btn btn-danger btn-sm btn-number"
        data-id="{{ $item->id_keranjang }}"
        onclick="updateQuantity(event, '{{ $item->id_keranjang }}', -1)">
        <svg width="14" height="14">
        <use xlink:href="#minus"></use>
        </svg>
        </button>
        <input type="text" id="quantity-{{ $item->id_keranjang }}" name="quantity[{{ $item->id_keranjang }}]"
        class="form-control form-control-sm input-number text-center mx-1" value="{{ $item->jumlah }}"
        min="1" onchange="updateQuantityInput('{{ $item->id_keranjang }}')" style="width: 50px !important;">


        <button type="button" class="quantity-right-plus btn btn-success btn-sm btn-number"
        data-id="{{ $item->id_keranjang }}" onclick="updateQuantity(event, '{{ $item->id_keranjang }}', 1)">
        <svg width="14" height="14">
        <use xlink:href="#plus"></use>
        </svg>
        </button>
      </div>
      </div>
      </div>
      </li>
    @endforeach

      <li class="list-group-item d-flex justify-content-between">
      <span>Total (IDR)</span>
      <strong>
        <span id="total">RP. 0</span>
      </strong>
      </li>
    </ul>
  @endif
        <!-- Tombol Checkout -->
        <!-- <button class="w-100 btn btn-primary btn-lg" type="button" id="checkoutButton">Continue to checkout</button>
  -->
        <form id="checkoutForm" action="{{ route('checkout') }}" method="POST">
          @csrf
          <input type="hidden" name="keranjang_items" id="keranjangItemsInput" class="w-100 btn btn-primary btn-lg">
          <button class="w-100 btn btn-primary btn-lg" type="submit" id="checkoutButton">Continue to checkout</button>
        </form>

      </div>
    </div>
  </div>
  <!-- AKHIR MODAL KERANJANG------------------------------------------------------------------ -->


  <!---------------------------------- modal pengaturan user---------------------------------------------------------------------------------------------- -->
  <div class="modal fade" id="settingModal1" tabindex="-1" aria-labelledby="settingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="settingModalLabel">Pengaturan Akun</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('user.updateSettings') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Menggunakan PUT untuk update data -->

            <!-- Username -->
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" value="{{ session('username') }}"
                required>
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password"
                placeholder="Masukkan password baru (opsional)">
            </div>

            <!-- No Telepon -->
            <div class="mb-3">
              <label for="no_telepon" class="form-label">No Telepon</label>
              <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                value="{{ session('no_telepon') }}" required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
              <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
              <textarea class="form-control" id="alamat_lengkap" name="alamat_lengkap" rows="3"
                required>{{ session('alamat_lengkap') }}</textarea>
            </div>


            <!-- Tombol Set Lokasi -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#setLocationModal">
              Set Lokasi fas
            </button>

            <!-- Modal Set Lokasi -->
            <!-- Modal Set Lokasi -->



            <!-- Kecamatan -->
            <div class="mb-3">
              <label for="kecamatan" class="form-label">Kecamatan</label>
              <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ session('kecamatan') }}"
                required>
            </div>

            <!-- Kota -->
            <div class="mb-3">
              <label for="kota" class="form-label">Kota</label>
              <input type="text" class="form-control" id="kota" name="kota" value="{{ session('kota') }}" required>
            </div>

            <!-- Submit Button -->
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>






      </div>
    </div>
  </div>

  <!-- modal edit lokasi user -->
  <div class="modal fade" id="setLocationModal" tabindex="-1" aria-labelledby="setLocationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="setLocationModalLabel">Pilih Lokasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('save-location') }}" method="POST">
          @csrf
          <div class="modal-body">
            <!-- Peta OpenStreetMap untuk Set Lokasi -->
            <div id="mapSet" style="height: 400px;"></div>
            <!-- Input Latitude dan Longitude -->
            <div class="mt-3">
              <label for="latitude" class="form-label">Latitude</label>
              <input type="text" name="latitude" id="latitude" class="form-control" readonly required>
              <label for="longitude" class="form-label mt-2">Longitude</label>
              <input type="text" name="longitude" id="longitude" class="form-control" readonly required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan Lokasi</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!------------------------------------- Modal Pembayaran --------------------------------------------------------------------------------------------- -->
  @foreach ($orders as $order)
    <!-- Modal untuk setiap pesanan -->
    <div class="modal fade" id="modalPembayaran{{ $order->id_pesanan }}" tabindex="-1"
    aria-labelledby="modalPembayaranLabel{{ $order->id_pesanan }}" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      <!-- Header Modal -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalPembayaranLabel{{ $order->id_pesanan }}">Unggah Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Body Modal -->
      <div class="modal-body">
        <form id="paymentForm{{ $order->id_pesanan }}" method="POST"
        action="{{ route('uploadPayment', ['id' => $order->id_pesanan]) }}" enctype="multipart/form-data">
        @csrf
        <!-- File Upload -->
        <div class="mb-3">
          <label for="paymentProof{{ $order->id_pesanan }}" class="form-label">Bukti Pembayaran</label>
          <input type="file" class="form-control" id="paymentProof{{ $order->id_pesanan }}" name="paymentProof"
          accept="image/*" required>
        </div>
        </form>
      </div>

      <!-- Footer Modal -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary" form="paymentForm{{ $order->id_pesanan }}">Unggah</button>
      </div>
      </div>
    </div>
    </div>
  @endforeach
  <!-- akhir Modal Pembayaran -->

  <!-- Modal Cari Berdasarkan Lokasi -->
  <div class="modal fade" id="searchLocationModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="mapModalLabel">Pilih Lokasi ini yang jalan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="radiusSlider" class="form-label">Radius: <span id="radiusValue">1 km</span></label>
            <input type="range" class="form-range" id="radiusSlider" min="1" max="50" step="1" value="1">
          </div>
          <!-- Div untuk menampilkan peta -->
          <div id="map" style="height: 450px;"></div>
        </div>
        <div class="modal-footer">

          <button id="searchLocationBtn" class="btn btn-primary">Cari Berdasarkan Lokasi</button>

        </div>
      </div>
    </div>
  </div>


  <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasSearch"
    aria-labelledby="Search">
    <div class="offcanvas-header justify-content-center">
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Search</span>
        </h4>
        <form role="search" action="{{ route('home') }}" method="get" class="d-flex mt-3 gap-0">
          <input class="form-control rounded-start rounded-0 bg-light" type="text" name="query"
            placeholder="What are you looking for?" aria-label="What are you looking for?">
          <button class="btn btn-dark rounded-end rounded-0" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>

  <header>
    <div class="container-fluid">
      <div class="row py-3 border-bottom">

        <div class="col-sm-4 col-lg-3 text-center text-sm-start">
          <div class="main-logo">
            <a href="index.html">
              <img src="{{ asset('images/logo.png') }}" alt="logo" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="col-sm-6 offset-sm-2 offset-md-0 col-lg-5 d-none d-lg-block">
          <div class="search-bar row bg-light p-2 my-2 rounded-4">
            <div class="col-10 col-md-12">
              <form id="search-form" method="GET" action="{{ route('produk.cari') }}" class="text-center">
                @csrf
                <div class="input-group">
                  <input type="text" name="query" id="search-query" class="form-control border-0 bg-transparent"
                    placeholder="Cari Produk" required />
                  <button type="submit" class="btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                      <path fill="currentColor"
                        d="M21.71 20.29L18 16.61A9 9 0 1 0 16.61 18l3.68 3.68a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.39ZM11 18a7 7 0 1 1 7-7a7 7 0 0 1-7 7Z" />
                    </svg>
                  </button>
                  <!-- Tombol X untuk refresh halaman -->
                  <button type="button" id="refresh-btn" class="btn">
                    <i class="bi bi-x-lg"></i>
                  </button>
                  <script>document.getElementById('refresh-btn').addEventListener('click', function () { location.reload(); });</script>
                </div>
              </form>
            </div>
          </div>
        </div>




        <div
          class="col-sm-8 col-lg-4 d-flex justify-content-end gap-5 align-items-center mt-4 mt-sm-0 justify-content-center justify-content-sm-end">
          <div class="support-box text-end d-none d-xl-block">
            <!-- Tombol Cari Berdasarkan Lokasi -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#searchLocationModal">
              Cari Berdasarkan Lokasi
            </button>
          </div>

          <ul class="d-flex justify-content-end list-unstyled m-0">
            <!-- Kondisi untuk user yang belum login -->
            @guest
        <li>
          <button class="btn btn-success r-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal"
          style="width:100px;">Login</button>
        </li>
        <!-- Tombol Register -->
        <li>
          <a href="{{ route('register') }}" class="btn btn-outline-success" style="width:100px;">Register</a>
        </li>
      @endguest

            <!-- Kondisi untuk user yang sudah login -->
            @auth
          <li>
            <div class="dropdown">
            <!-- Tombol untuk membuka dropdown menu, dengan tampilan seperti yang diinginkan -->
            <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <a href="#" class="rounded-circle bg-light p-2 mx-1">
              <i class="bi bi-person-fill" style="font-size: 30px;"></i>
              </a>
            </button>

            <!-- Dropdown menu -->
            <ul class="dropdown-menu">
              <li class="dropdown-item text-center" style="margin-bottom:-10px;">
              <strong>{{ session('username') }}</strong> <!-- Nama pengguna yang sedang login -->
              </li>
              <li>
              <hr>
              <button class="dropdown-item w-100 text-start mb-2" type="button" data-bs-toggle="modal"
                data-bs-target="#settingModal1">
                <i class="bi bi-person-fill-gear me-2"></i>Pengaturan</button>
              </li>
              <li>
              <li>
              <!-- Tombol Logout dengan margin kiri dan kanan yang proporsional -->
              <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger text-start mx-auto d-block r-1"
                style="width:145px; margin-bottom:0px;">
                <i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                <!-- mx-auto untuk menyejajarkan tombol di tengah -->
              </form>
              </li>
            </ul>


            </div>

          </li>
          <!-- tombol notif -->
          <li>
            <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#orderNotificationModal"
            aria-controls="orderNotificationModal">
            <a href="#" class="rounded-circle bg-light p-2 mx-1">
              <i class="bi bi-bell-fill" style="font-size: 30px;"></i>
            </a>
            </button>
          </li>

          <li class="d-lg-none">
            <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
            <a href="#" class="rounded-circle bg-light p-2 mx-1" data-bs-toggle="offcanvas"
              data-bs-target="#offcanvasSearch" aria-controls="offcanvasSearch">
              <i class="bi bi-search" style="font-size: 30px;"></i>
            </a>
            </button>
          </li>
          <li>
            <button class="border-0 bg-transparent d-flex flex-column gap-2 lh-1" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
            <a href="#" class="rounded-circle bg-light p-2 mx-1">
              <i class="bi bi-cart-fill" style="font-size: 30px; position: relative; tex">
              <!-- Badge untuk jumlah item di keranjang -->
              @if(count($keranjangItems) > 0)
          <span class="position-absolute top-0 start-100 translate-middle badge text-light"
          style="background-color: rgb(255, 0, 0); font-size: 12px; padding: 0.2rem 0.4rem; border-radius: 50%; font-style: normal;">
          {{ count($keranjangItems) }}
          </span>
        @endif
              </i>
            </a>
            </button>
          </li>
        </div>
      @endauth
        </ul>


        <!---------------------------------------------------------- Modal Login --------------------------------------------------------------------------->
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="loginForm" method="POST" action="{{ route('login') }}">
                  @csrf
                  <!-- Username -->
                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>

                  <!-- Password -->
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="loginForm">Login</button>
              </div>
            </div>
          </div>
        </div>
        <!-- ----------------------------------------------------------AKHIR MODAL LOGIN--------------------------------------------------------------  -->


      </div>
    </div>
    <div class="container-fluid">
      <div class="">
        <div class="d-flex  justify-content-center justify-content-sm-between align-items-center">
          <nav class="main-menu d-flex navbar navbar-expand-lg">

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
              aria-controls="offcanvasNavbar">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
              aria-labelledby="offcanvasNavbarLabel">
              <div class="offcanvas-header justify-content-center">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
            </div>
        </div>
      </div>
    </div>
  </header>
  <div id="banner-section">
    <section class="py-3"
      style="background-image: url('images/background-pattern.jpg');background-repeat: no-repeat;background-size: cover;">
      <div class="container-fluid">
        @if(empty($query))
        <div class="row">
          <div class="col-md-12">

          <div class="banner-blocks">
            <div class="banner-ad large bg-info block-1">
            <div class="swiper main-swiper">
              <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="row banner-content p-5">
                <div class="content-wrapper col-md-7">
                  <div class="categories my-3">100% natural</div>
                  <h3 class="display-4">Strawberry</h3>
                  <p>Rasakan kesegaran alami dengan stroberi pilihan yang manis dan kaya akan vitamin. Cocok untuk camilan sehat setiap hari.
                  </p>
                </div>
                <div class="img-wrapper col-md-5">
                  <img src="images/strawberry.png" class="img-fluid">
                </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="row banner-content p-5">
                <div class="content-wrapper col-md-7">
                  <div class="categories mb-3 pb-3">100% natural</div>
                  <h3 class="banner-title">Fresh Carrots</h3>
                  <p>Nikmati kesegaran dan wortel segar yang kaya akan serat dan nutrisi. Cocok untuk salad sehat setiap hari!</p>
                  
                </div>
                <div class="img-wrapper col-md-5">
                  <img src="images/carrot.png" class="img-fluid">
                </div>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="row banner-content p-5">
                <div class="content-wrapper col-md-7">
                  <div class="categories mb-3 pb-3">100% natural</div>
                  <h3 class="banner-title">Fresh Organic Tomatoes</h3>
                  <p>Tomat segar organik yang kaya akan vitamin C dan antioksidan. Cocok untuk salad, masakan, atau dikonsumsi langsung untuk gaya hidup sehat.</p>
                  
                </div>
                <div class="img-wrapper col-md-5">
                  <img src="images/tomato.png" class="img-fluid">
                </div>
                </div>
              </div>
              </div>

              <div class="swiper-pagination"></div>

            </div>
            </div>

            <div class="banner-ad bg-success-subtle block-2"
            style="background:url('images/ad-image-1.png') no-repeat;background-position: right bottom">
            <div class="row banner-content p-5">

              <div class="content-wrapper col-md-7">
              <div class="categories sale mb-3 pb-3">20% off</div>
              <h3 class="banner-title">Fruits & Vegetables</h3>
                <use xlink:href="#arrow-right"></use>
                </svg></a>
              </div>

            </div>
            </div>

            <div class="banner-ad bg-warning block-3"
            style="background:url('images/fresh.png') no-repeat;background-position: right bottom">
            <div class="row banner-content p-5">

              <div class="content-wrapper col-md-7">
                <div class="categories sale mb-3 pb-3">15% off</div>
                <h3 class="item-title">Fresh Farm Produce</h3>
              </div>
              

            </div>
            </div>

          </div>
          <!-- / Banner Blocks -->

          </div>
        </div>
        </div>
      </section>


      <!-- ---------------------------------------------------------PRODUK TERBARU-------------------------------------------------------------------- -->
      <!-- <section class="py-5 overflow-hidden">
          <div class="container-fluid">
          <div class="row">
          <div class="col-md-12">

          <div class="section-header d-flex justify-content-between">

          <h2 class="section-title">Just arrived</h2>

          <div class="d-flex align-items-center">
          <a href="#" class="btn-link text-decoration-none">View All Categories →</a>
          <div class="swiper-buttons">
            <button class="swiper-prev products-carousel-prev btn btn-primary">❮</button>
            <button class="swiper-next products-carousel-next btn btn-primary">❯</button>
          </div>
          </div>
          </div>

          </div>
          </div>
          <div class="row">
          <div class="col-md-12">

          <div class="products-carousel swiper">
          <div class="swiper-wrapper">

          Tandai boss
          @if(isset($produkAll) && count($produkAll) > 0)
          @foreach($produkAll as $item)
          <div class="product-item swiper-slide">
          <a href="{{ route('produk.show', $item->id_produk) }}" title="{{ $item->nama_produk }}"
          class="product-link">
          <figure>
          <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}" class="tab-image">
          </figure>
          <h3>{{ $item->nama_produk }}</h3>
          <span class="qty">stok : {{ $item->stok }}</span>
          <span class="price">RP. {{ number_format($item->harga_produk, 0, ',', '.') }}</span>
          </a>
          </div>
        @endforeach
          @else
        <p class="text-center">Belum ada produk terbaru.</p>
        @endif

          </div>
          </div>
          / products-carousel

          </div>
          </div>
          </div>
          </section> -->
    @endif

  </div>
  <!-- -----------------------------------------------AKHIR PRODUK TERBARU------------------------ -->




  <!-- ------------------------------------------------------------------------------------------------------------------------------------- -->
  <section id="search-results" class="py-5">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="bootstrap-tabs product-tabs">
            <div class="tabs-header d-flex justify-content-between border-bottom my-5">
              <h3>Daftar Semua Produk</h3>
            </div>
            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">


                  <!--------------------------------------------------------------- CARD PRODUK-------------------------------------------------------------- -->

                  @foreach($produkAll as $item)
            <div class="col mb-4">
            <div class="product-item card shadow-sm produk-item">
              <!-- Link seluruh card (kecuali tombol tambah) -->
              <a href="{{ route('produk.show', $item->id_produk) }}" title="{{ $item->nama_produk }}"
              class="product-link" style="text-decoration: none;">
              <figure style="width: 100%; overflow: hidden;">
                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_produk }}"
                class="tab-image" style="width: 100%; height: 100%; object-fit: cover;">
              </figure>

              <div class="product-details p-3">
                <h3>{{ $item->nama_produk }}</h3>
                <span class="qty">stok : {{ $item->stok }}</span>
                <span class="rating">
                <svg width="24" height="24" class="text-primary">
                </svg>
                </span>
                <span class="price">RP. {{ number_format($item->harga_produk, 0, ',', '.') }}</span>
                <span><i class="bi bi-person-fill"></i>
                {{ $item->user->username ?? 'Tidak diketahui' }}</span>
              </div>
              </a>
              <div class="d-flex mt-2">
              <!-- Tombol tambah, tetap di luar link -->
              <form action="{{ route('keranjang.tambahDB', $item->id_produk) }}" method="POST" class="w-100">
                @csrf
                <button type="submit" class="btn btn-primary w-100 text-center">
                <span>+ Keranjang</span>
                </button>
              </form>
              </div>

            </div>
            </div>
          @endforeach


                  <!-- AKHIR CARD PRODUK -->
                </div>
                <div class="col">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- ------------------------------------------------------------------------------------------------- -->




  <!-- -------------------------------------GAMBAR HP----------------------------------------------------- -->
  <section class="py-5 my-5">
    <div class="container-fluid">

      <div class="bg-warning py-5 rounded-5" style="background-image: url('images/bg-pattern-2.png') no-repeat;">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <h2 class="my-5">Belanja Hasil tani lebih cepat di web PATANI</h2>
              <p>PATANI adalah aplikasi web inovatif yang dirancang untuk mempermudah
                masyarakat dalam membeli hasil tani langsung dari petani lokal.
                Dilengkapi dengan Fitur Lokasi yang dapat mempermudah mencari Petani
                di sekitar Anda!. Dengan antarmuka yang ramah pengguna, PATANI
                menawarkan pengalaman belanja online yang cepat, aman, dan efisien.</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>


  <!-- ------------------------------KETERANGAN DIATAS FOOTER---------------------------------------------- -->
  <section class="py-5">
    <div class="container-fluid">
      <div class="row justify-content-center row-cols-1 row-cols-sm-3 row-cols-lg-5">
        <div class="col">
          <div class="card mb-3 border-0">
            <div class="row">
              <div class="col-md-2 text-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <path fill="currentColor"
                    d="M22 5H2a1 1 0 0 0-1 1v4a3 3 0 0 0 2 2.82V22a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-9.18A3 3 0 0 0 23 10V6a1 1 0 0 0-1-1Zm-7 2h2v3a1 1 0 0 1-2 0Zm-4 0h2v3a1 1 0 0 1-2 0ZM7 7h2v3a1 1 0 0 1-2 0Zm-3 4a1 1 0 0 1-1-1V7h2v3a1 1 0 0 1-1 1Zm10 10h-4v-2a2 2 0 0 1 4 0Zm5 0h-3v-2a4 4 0 0 0-8 0v2H5v-8.18a3.17 3.17 0 0 0 1-.6a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3 3 0 0 0 4 0a3.17 3.17 0 0 0 1 .6Zm2-11a1 1 0 0 1-2 0V7h2ZM4.3 3H20a1 1 0 0 0 0-2H4.3a1 1 0 0 0 0 2Z" />
                </svg>
              </div>
              <div class="col-md-10 mx-auto">
                <div class="card-body p-0">
                  <h5>Quality Guarantee</h5>
                  <p class="card-text">Kami menyediakan produk segar dengan kualitas terbaik langsung dari petani terpercaya.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col">
          <div class="card mb-3 border-0">
            <div class="row">
              <div class="col-md-2 text-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <path fill="currentColor"
                    d="M12 8.35a3.07 3.07 0 0 0-3.54.53a3 3 0 0 0 0 4.24L11.29 16a1 1 0 0 0 1.42 0l2.83-2.83a3 3 0 0 0 0-4.24A3.07 3.07 0 0 0 12 8.35Zm2.12 3.36L12 13.83l-2.12-2.12a1 1 0 0 1 0-1.42a1 1 0 0 1 1.41 0a1 1 0 0 0 1.42 0a1 1 0 0 1 1.41 0a1 1 0 0 1 0 1.42ZM12 2A10 10 0 0 0 2 12a9.89 9.89 0 0 0 2.26 6.33l-2 2a1 1 0 0 0-.21 1.09A1 1 0 0 0 3 22h9a10 10 0 0 0 0-20Zm0 18H5.41l.93-.93a1 1 0 0 0 0-1.41A8 8 0 1 1 12 20Z" />
                </svg>
              </div>
              <div class="col-md-10 mx-auto">
                <div class="card-body p-0">
                  <h5>Guaranteed Savings</h5>
                  <p class="card-text">Dapatkan harga terbaik dengan diskon menarik untuk produk pertanian segar setiap hari.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col">
          <div class="card mb-3 border-0">
            <div class="row">
              <div class="col-md-2 text-dark">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                  <path fill="currentColor"
                    d="M18 7h-.35A3.45 3.45 0 0 0 18 5.5a3.49 3.49 0 0 0-6-2.44A3.49 3.49 0 0 0 6 5.5A3.45 3.45 0 0 0 6.35 7H6a3 3 0 0 0-3 3v2a1 1 0 0 0 1 1h1v6a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3v-6h1a1 1 0 0 0 1-1v-2a3 3 0 0 0-3-3Zm-7 13H8a1 1 0 0 1-1-1v-6h4Zm0-9H5v-1a1 1 0 0 1 1-1h5Zm0-4H9.5A1.5 1.5 0 1 1 11 5.5Zm2-1.5A1.5 1.5 0 1 1 14.5 7H13ZM17 19a1 1 0 0 1-1 1h-3v-7h4Zm2-8h-6V9h5a1 1 0 0 1 1 1Z" />
                </svg>
              </div>
              <div class="col-md-10 mx-auto">
                <div class="card-body p-0">
                  <h5>Daily Offers</h5>
                  <p class="card-text">Nikmati penawaran spesial setiap hari untuk produk pertanian berkualitas tinggi.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
  
      </div>
    </div>
  </section>
  
  



  <!-- --------------------------------------------FOOTER----------------------------------------------- -->
  <footer class="py-5">
    <div class="container-fluid">
      <div class="row">

        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="footer-menu">
            <img src="images/logo.png" alt="logo">
            <div class="social-links mt-5">
              <ul class="d-flex list-unstyled gap-2">
                <li>
                  <a href="#" class="btn btn-outline-light">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                      <path fill="currentColor"
                        d="M15.12 5.32H17V2.14A26.11 26.11 0 0 0 14.26 2c-2.72 0-4.58 1.66-4.58 4.7v2.62H6.61v3.56h3.07V22h3.68v-9.12h3.06l.46-3.56h-3.52V7.05c0-1.05.28-1.73 1.76-1.73Z" />
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="btn btn-outline-light">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                      <path fill="currentColor"
                        d="M22.991 3.95a1 1 0 0 0-1.51-.86a7.48 7.48 0 0 1-1.874.794a5.152 5.152 0 0 0-3.374-1.242a5.232 5.232 0 0 0-5.223 5.063a11.032 11.032 0 0 1-6.814-3.924a1.012 1.012 0 0 0-.857-.365a.999.999 0 0 0-.785.5a5.276 5.276 0 0 0-.242 4.769l-.002.001a1.041 1.041 0 0 0-.496.89a3.042 3.042 0 0 0 .027.439a5.185 5.185 0 0 0 1.568 3.312a.998.998 0 0 0-.066.77a5.204 5.204 0 0 0 2.362 2.922a7.465 7.465 0 0 1-3.59.448A1 1 0 0 0 1.45 19.3a12.942 12.942 0 0 0 7.01 2.061a12.788 12.788 0 0 0 12.465-9.363a12.822 12.822 0 0 0 .535-3.646l-.001-.2a5.77 5.77 0 0 0 1.532-4.202Zm-3.306 3.212a.995.995 0 0 0-.234.702c.01.165.009.331.009.488a10.824 10.824 0 0 1-.454 3.08a10.685 10.685 0 0 1-10.546 7.93a10.938 10.938 0 0 1-2.55-.301a9.48 9.48 0 0 0 2.942-1.564a1 1 0 0 0-.602-1.786a3.208 3.208 0 0 1-2.214-.935q.224-.042.445-.105a1 1 0 0 0-.08-1.943a3.198 3.198 0 0 1-2.25-1.726a5.3 5.3 0 0 0 .545.046a1.02 1.02 0 0 0 .984-.696a1 1 0 0 0-.4-1.137a3.196 3.196 0 0 1-1.425-2.673c0-.066.002-.133.006-.198a13.014 13.014 0 0 0 8.21 3.48a1.02 1.02 0 0 0 .817-.36a1 1 0 0 0 .206-.867a3.157 3.157 0 0 1-.087-.729a3.23 3.23 0 0 1 3.226-3.226a3.184 3.184 0 0 1 2.345 1.02a.993.993 0 0 0 .921.298a9.27 9.27 0 0 0 1.212-.322a6.681 6.681 0 0 1-1.026 1.524Z" />
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="btn btn-outline-light">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                      <path fill="currentColor"
                        d="M23 9.71a8.5 8.5 0 0 0-.91-4.13a2.92 2.92 0 0 0-1.72-1A78.36 78.36 0 0 0 12 4.27a78.45 78.45 0 0 0-8.34.3a2.87 2.87 0 0 0-1.46.74c-.9.83-1 2.25-1.1 3.45a48.29 48.29 0 0 0 0 6.48a9.55 9.55 0 0 0 .3 2a3.14 3.14 0 0 0 .71 1.36a2.86 2.86 0 0 0 1.49.78a45.18 45.18 0 0 0 6.5.33c3.5.05 6.57 0 10.2-.28a2.88 2.88 0 0 0 1.53-.78a2.49 2.49 0 0 0 .61-1a10.58 10.58 0 0 0 .52-3.4c.04-.56.04-3.94.04-4.54ZM9.74 14.85V8.66l5.92 3.11c-1.66.92-3.85 1.96-5.92 3.08Z" />
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="btn btn-outline-light">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                      <path fill="currentColor"
                        d="M17.34 5.46a1.2 1.2 0 1 0 1.2 1.2a1.2 1.2 0 0 0-1.2-1.2Zm4.6 2.42a7.59 7.59 0 0 0-.46-2.43a4.94 4.94 0 0 0-1.16-1.77a4.7 4.7 0 0 0-1.77-1.15a7.3 7.3 0 0 0-2.43-.47C15.06 2 14.72 2 12 2s-3.06 0-4.12.06a7.3 7.3 0 0 0-2.43.47a4.78 4.78 0 0 0-1.77 1.15a4.7 4.7 0 0 0-1.15 1.77a7.3 7.3 0 0 0-.47 2.43C2 8.94 2 9.28 2 12s0 3.06.06 4.12a7.3 7.3 0 0 0 .47 2.43a4.7 4.7 0 0 0 1.15 1.77a4.78 4.78 0 0 0 1.77 1.15a7.3 7.3 0 0 0 2.43.47C8.94 22 9.28 22 12 22s3.06 0 4.12-.06a7.3 7.3 0 0 0 2.43-.47a4.7 4.7 0 0 0 1.77-1.15a4.85 4.85 0 0 0 1.16-1.77a7.59 7.59 0 0 0 .46-2.43c0-1.06.06-1.4.06-4.12s0-3.06-.06-4.12ZM20.14 16a5.61 5.61 0 0 1-.34 1.86a3.06 3.06 0 0 1-.75 1.15a3.19 3.19 0 0 1-1.15.75a5.61 5.61 0 0 1-1.86.34c-1 .05-1.37.06-4 .06s-3 0-4-.06a5.73 5.73 0 0 1-1.94-.3a3.27 3.27 0 0 1-1.1-.75a3 3 0 0 1-.74-1.15a5.54 5.54 0 0 1-.4-1.9c0-1-.06-1.37-.06-4s0-3 .06-4a5.54 5.54 0 0 1 .35-1.9A3 3 0 0 1 5 5a3.14 3.14 0 0 1 1.1-.8A5.73 5.73 0 0 1 8 3.86c1 0 1.37-.06 4-.06s3 0 4 .06a5.61 5.61 0 0 1 1.86.34a3.06 3.06 0 0 1 1.19.8a3.06 3.06 0 0 1 .75 1.1a5.61 5.61 0 0 1 .34 1.9c.05 1 .06 1.37.06 4s-.01 3-.06 4ZM12 6.87A5.13 5.13 0 1 0 17.14 12A5.12 5.12 0 0 0 12 6.87Zm0 8.46A3.33 3.33 0 1 1 15.33 12A3.33 3.33 0 0 1 12 15.33Z" />
                    </svg>
                  </a>
                </li>
                <li>
                  <a href="#" class="btn btn-outline-light">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                      <path fill="currentColor"
                        d="M1.04 17.52q.1-.16.32-.02a21.308 21.308 0 0 0 10.88 2.9a21.524 21.524 0 0 0 7.74-1.46q.1-.04.29-.12t.27-.12a.356.356 0 0 1 .47.12q.17.24-.11.44q-.36.26-.92.6a14.99 14.99 0 0 1-3.84 1.58A16.175 16.175 0 0 1 12 22a16.017 16.017 0 0 1-5.9-1.09a16.246 16.246 0 0 1-4.98-3.07a.273.273 0 0 1-.12-.2a.215.215 0 0 1 .04-.12Zm6.02-5.7a4.036 4.036 0 0 1 .68-2.36A4.197 4.197 0 0 1 9.6 7.98a10.063 10.063 0 0 1 2.66-.66q.54-.06 1.76-.16v-.34a3.562 3.562 0 0 0-.28-1.72a1.5 1.5 0 0 0-1.32-.6h-.16a2.189 2.189 0 0 0-1.14.42a1.64 1.64 0 0 0-.62 1a.508.508 0 0 1-.4.46L7.8 6.1q-.34-.08-.34-.36a.587.587 0 0 1 .02-.14a3.834 3.834 0 0 1 1.67-2.64A6.268 6.268 0 0 1 12.26 2h.5a5.054 5.054 0 0 1 3.56 1.18a3.81 3.81 0 0 1 .37.43a3.875 3.875 0 0 1 .27.41a2.098 2.098 0 0 1 .18.52q.08.34.12.47a2.856 2.856 0 0 1 .06.56q.02.43.02.51v4.84a2.868 2.868 0 0 0 .15.95a2.475 2.475 0 0 0 .29.62q.14.19.46.61a.599.599 0 0 1 .12.32a.346.346 0 0 1-.16.28q-1.66 1.44-1.8 1.56a.557.557 0 0 1-.58.04q-.28-.24-.49-.46t-.3-.32a4.466 4.466 0 0 1-.29-.39q-.2-.29-.28-.39a4.91 4.91 0 0 1-2.2 1.52a6.038 6.038 0 0 1-1.68.2a3.505 3.505 0 0 1-2.53-.95a3.553 3.553 0 0 1-.99-2.69Zm3.44-.4a1.895 1.895 0 0 0 .39 1.25a1.294 1.294 0 0 0 1.05.47a1.022 1.022 0 0 0 .17-.02a1.022 1.022 0 0 1 .15-.02a2.033 2.033 0 0 0 1.3-1.08a3.13 3.13 0 0 0 .33-.83a3.8 3.8 0 0 0 .12-.73q.01-.28.01-.92v-.5a7.287 7.287 0 0 0-1.76.16a2.144 2.144 0 0 0-1.76 2.22Zm8.4 6.44a.626.626 0 0 1 .12-.16a3.14 3.14 0 0 1 .96-.46a6.52 6.52 0 0 1 1.48-.22a1.195 1.195 0 0 1 .38.02q.9.08 1.08.3a.655.655 0 0 1 .08.36v.14a4.56 4.56 0 0 1-.38 1.65a3.84 3.84 0 0 1-1.06 1.53a.302.302 0 0 1-.18.08a.177.177 0 0 1-.08-.02q-.12-.06-.06-.22a7.632 7.632 0 0 0 .74-2.42a.513.513 0 0 0-.08-.32q-.2-.24-1.12-.24q-.34 0-.8.04q-.5.06-.92.12a.232.232 0 0 1-.16-.04a.065.065 0 0 1-.02-.08a.153.153 0 0 1 .02-.06Z" />
                    </svg>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>


      </div>
    </div>
  </footer>
  <div id="footer-bottom">
    <div class="container-fluid">
      <div class="row">
      </div>
    </div>
  </div>

  <!--------------------------------------------JAVASCRIPT----------------------------------------------- -->
  <script src="js/jquery-1.11.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="js/plugins.js"></script>
  <script src="{{ asset('js/script.js') }}"></script>

  <script>

    document.getElementById('search-form').addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent form submission for AJAX handling

      const query = document.getElementById('search-query').value.trim();

      // If there is a search query, hide the banner section and show search results
      if (query) {
        document.getElementById('banner-section').style.display = 'none';
        document.getElementById('search-results').style.display = 'block';

        fetch(`{{ route('produk.cari') }}?query=${query}`)
          .then((response) => response.json())
          .then((data) => {
            const resultsContainer = document.querySelector('#search-results .product-grid');
            resultsContainer.innerHTML = ''; // Clear previous results

            if (data.produkAll.length === 0) {
              // Display "Produk tidak ada" if no products are found
              resultsContainer.innerHTML = `
            <div class="col-12 text-center my-5">
              <h4 class="text-muted">Produk tidak ada</h4>
            </div>`;
            } else {
              // Display products if found
              data.produkAll.forEach(product => {
                const productCard = `
                    <div class="col mb-4">
                      <div class="product-item card shadow-sm produk-item">
                        <a href="/produk/${product.id_produk}" title="${product.nama_produk}" class="product-link" style="text-decoration: none;">
                          <figure style="width: 100%; overflow: hidden;">
                            <img src="/storage/${product.foto}" alt="${product.nama_produk}" class="tab-image" style="width: 100%; height: 100%; object-fit: cover;">
                          </figure>
                          <div class="product-details p-3">
                            <h3>${product.nama_produk}</h3>
                            <span class="qty">Stok: ${product.stok}</span> 
                            <span class="qty">ID: ${product.id_produk}</span> 
                            <span class="rating">
                              <svg width="24" height="24" class="text-primary"></svg>
                            </span>
                            <span class="price">RP. ${new Intl.NumberFormat().format(product.harga_produk)}</span>
                            <span>${product.user?.username || 'Tidak diketahui'}</span>
                          </div>
                        </a>
                        <div class="d-flex justify-content-between mt-2">
                         <form action="/keranjang/tambah-db/${product.id_produk}" method="POST" class="w-100">
                          @csrf
                          <input type="hidden" name="id_produk" value="${product.id_produk}">
                          <button type="submit" class="btn btn-primary w-100 text-center">
                            <span>+ Keranjang</span>
                          </button>
                        </form>

                        </div>
                      </div>
                    </div>`;
                resultsContainer.innerHTML += productCard;
              });

            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data produk.');
          });
      } else {
        // Show the banner and hide search results if input is empty
        document.getElementById('banner-section').style.display = 'block';
        document.getElementById('search-results').style.display = 'none';
      }
    });


  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const updateJumlah = (idKeranjang, jumlah) => {

        fetch('/keranjang/update', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
          body: JSON.stringify({
            id_keranjang: idKeranjang,
            jumlah: jumlah,
          }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (!data.success) {

              alert(data.message);
            }
          })
          .catch((error) => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui jumlah.');
          });
      };

      // Event listener untuk tombol minus
      document.querySelectorAll(".quantity-left-minus").forEach(function (button) {
        button.addEventListener("click", function () {
          const idKeranjang = this.getAttribute("data-id");
          const input = document.getElementById(`quantity-${idKeranjang}`);
          let jumlah = parseInt(input.value, 10) || 1;


          if (jumlah > 0) {

            input.value = jumlah;
            updateJumlah(idKeranjang, jumlah);
          }
        });
      });

      // Event listener untuk tombol plus
      document.querySelectorAll(".quantity-right-plus").forEach(function (button) {
        button.addEventListener("click", function () {
          const idKeranjang = this.getAttribute("data-id");
          const input = document.getElementById(`quantity-${idKeranjang}`);
          let jumlah = parseInt(input.value, 10) || 1;


          input.value = jumlah;
          updateJumlah(idKeranjang, jumlah);
        });
      });
    });
  </script>

  <script>
    // Update total when checkbox is checked or unchecked
    function updateTotal() {
      let total = 0;
      // Iterate over each checkbox that is checked
      document.querySelectorAll('.select-item:checked').forEach(function (checkbox) {
        let harga = parseFloat(checkbox.getAttribute('data-harga')); // Get price
        let jumlah = parseInt(checkbox.getAttribute('data-jumlah')); // Get quantity
        total += harga * jumlah; // Calculate total
      });

      // Display the total value
      document.getElementById('total').textContent = 'RP. ' + total.toLocaleString();
    }

    //Update quantity when the +/- buttons are clicked
    function updateQuantity(event, idKeranjang, change) {
      let inputElement = document.getElementById('quantity-' + idKeranjang);
      let newQuantity = parseInt(inputElement.value) + change;
      if (newQuantity >= 1) {
        inputElement.value = newQuantity;
        updateItemQuantity(idKeranjang, newQuantity);  // Update the quantity on the item
        updateTotal();  // Recalculate the total
      }
    }

    // Update quantity when the input value is changed manually

    function updateQuantityInput(idKeranjang) {
      let inputElement = document.getElementById('quantity-' + idKeranjang);
      let newQuantity = parseInt(inputElement.value);
      if (newQuantity >= 1) {
        updateItemQuantity(idKeranjang, newQuantity);  // Update the quantity on the item
        updateTotal();  // Recalculate the total
      } else {
        inputElement.value = 1;  // Reset to 1 if the value is less than 1
      }
    }

    //Update the quantity on the item (simulate backend update if necessary)
    function updateItemQuantity(idKeranjang, newQuantity) {
      let checkbox = document.querySelector(`.select-item[data-id='${idKeranjang}']`);
      checkbox.setAttribute('data-jumlah', newQuantity); // Update the data-jumlah attribute
    }

    // Fungsi untuk memilih atau membatalkan semua checkbox produk berdasarkan status checkbox "Semua"
    document.addEventListener("DOMContentLoaded", function () {
      const selectAllCheckbox = document.getElementById("selectAll"); // Checkbox "Semua"
      const productCheckboxes = document.querySelectorAll(".select-item"); // Checkbox produk

      // Menambahkan event listener untuk checkbox "Semua"
      selectAllCheckbox.addEventListener("change", function () {
        const isChecked = selectAllCheckbox.checked; // Cek apakah checkbox "Semua" dicentang

        // Menyeting status semua checkbox produk sesuai dengan status checkbox "Semua"
        productCheckboxes.forEach(function (checkbox) {
          checkbox.checked = isChecked;
        });

        // Update total setelah memilih atau membatalkan pilih semua checkbox
        updateTotal();
      });

      // Fungsi untuk memeriksa dan memperbarui status checkbox "Semua" berdasarkan checkbox produk
      productCheckboxes.forEach(function (checkbox) {
        checkbox.addEventListener("change", function () {
          // Jika semua checkbox produk tercentang, centang checkbox "Semua"
          const allChecked = Array.from(productCheckboxes).every(function (checkbox) {
            return checkbox.checked;
          });

          selectAllCheckbox.checked = allChecked;

          // Update total setelah checkbox produk berubah statusnya
          updateTotal();
        });
      });
    });

    document.getElementById('checkoutButton').addEventListener('click', function () {
      const selectedItems = [];
      document.querySelectorAll('.select-item:checked').forEach(function (checkbox) {
        console.log('ID Produk:', checkbox.getAttribute('data-id_produk'));
        const itemId = checkbox.getAttribute('data-id');
        const id_Produk = checkbox.getAttribute('data-id_produk');
        const harga = parseFloat(checkbox.getAttribute('data-harga'));
        const jumlah = parseInt(checkbox.getAttribute('data-jumlah'));
        const idPenjual = checkbox.getAttribute('id_penjual');

        selectedItems.push({
          id_keranjang: itemId,
          id_produk: id_Produk,
          harga: harga,
          jumlah: jumlah,
          id_penjual: idPenjual,
        });
      });

      console.log('Selected Items:', selectedItems);
      document.getElementById('keranjangItemsInput').value = JSON.stringify(selectedItems);
      document.getElementById('checkoutForm').submit();
    });



    // Fungsi untuk mengumpulkan data dari checkbox yang dipilih
    function collectCheckedItems() {
      let selectedItems = [];
      let checkboxes = document.querySelectorAll('.select-item:checked');

      checkboxes.forEach(function (checkbox) {
        let item = {
          id_produk: checkbox.getAttribute('data-id_produk'),
          jumlah: checkbox.dataset.jumlah,
          id_penjual: checkbox.getAttribute('id_penjual'),
          total_harga: parseFloat(checkbox.dataset.harga) * parseInt(checkbox.dataset.jumlah)
        };
        selectedItems.push(item);
      });

      // Kirim data ke input hidden dalam form
      document.getElementById('keranjangItemsInput').value = JSON.stringify(selectedItems);
    }

    // Kirim data saat form disubmit
    document.getElementById('checkoutForm').addEventListener('submit', function (e) {
      collectCheckedItems();
    });

    document.addEventListener("DOMContentLoaded", function () {
      const deleteButton = document.createElement("button");
      deleteButton.id = "deleteButton";
      deleteButton.className = "btn btn-danger btn-sm ms-190";
      deleteButton.style.marginLeft = "190px";
      deleteButton.innerHTML = '<i class="bi bi-trash"></i>';
      deleteButton.style.display = "none"; // Sembunyikan secara default
      const selectAllCheckbox = document.getElementById("selectAll");
      selectAllCheckbox.parentNode.appendChild(deleteButton); // Letakkan tombol di sebelah checkbox "Pilih Semua"

      // Periksa status checkbox untuk menampilkan atau menyembunyikan tombol hapus
      function updateDeleteButtonVisibility() {
        const anyChecked = document.querySelectorAll(".select-item:checked").length > 0;
        deleteButton.style.display = anyChecked ? "inline-block" : "none";
      }

      // Event listener untuk menampilkan/menghapus tombol hapus berdasarkan checkbox produk
      document.querySelectorAll(".select-item").forEach(function (checkbox) {
        checkbox.addEventListener("change", updateDeleteButtonVisibility);
      });

      // Event listener untuk checkbox "Pilih Semua"
      selectAllCheckbox.addEventListener("change", updateDeleteButtonVisibility);

      // Event listener untuk tombol hapus
      deleteButton.addEventListener("click", function () {
        const selectedIds = [];
        document.querySelectorAll(".select-item:checked").forEach(function (checkbox) {
          selectedIds.push(checkbox.getAttribute("data-id"));
        });

        if (selectedIds.length > 0) {
          if (confirm("Apakah Anda yakin ingin menghapus item yang dipilih?")) {
            fetch("/keranjang/delete", {
              method: "POST",
              headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
              },
              body: JSON.stringify({
                id_keranjang: selectedIds,
              }),
            })
              .then((response) => response.json())
              .then((data) => {
                if (data.success) {
                    // Menghapus item dari tampilan
                    selectedIds.forEach(id => removeItemFromCart(id));
                    
                    // Menampilkan alert sukses
                    let successMessage = document.createElement("div");
                    successMessage.classList.add("alert", "alert-success", "alert-custom");
                    successMessage.innerText = "Item berhasil dihapus.";
                    document.body.appendChild(successMessage);
                    // Update total secara langsung
                    updateTotal();
                    updateCartBadge()

                } else {
                  alert("Gagal menghapus item. Silakan coba lagi.");
                }
              })
              .catch((error) => {
                console.error("Error:", error);
                alert("Terjadi kesalahan saat menghapus item.");
              });
          }
        }
      });
    });
    function updateTotal() {
      let total = 0;
      
      // Loop melalui setiap checkbox yang dipilih dan jumlahkan harga yang relevan
      document.querySelectorAll('.select-item:checked').forEach(item => {
        const harga = parseFloat(item.getAttribute('data-harga'));
        const jumlah = parseInt(item.getAttribute('data-jumlah'));
        total += harga * jumlah;
      });
      
      // Update total di tampilan
      document.getElementById('total').textContent = "RP. " + total.toLocaleString();
    }
    function removeItemFromCart(idKeranjang) {
      // Cari elemen list item yang sesuai dengan id_keranjang
      const itemElement = document.querySelector(`.select-item[data-id='${idKeranjang}']`);
      
      if (itemElement) {
        // Hapus elemen list item yang terpilih
        const listItem = itemElement.closest('li');
        listItem.remove();
        
        // Update total jika diperlukan
        updateTotal();
      }
    }
    function updateCartBadge() {
      // Ambil semua elemen checkbox yang dipilih
      const selectedItems = document.querySelectorAll('.select-item');
      const cartItemCount = selectedItems.length;

      // Cari elemen badge dan perbarui teksnya
      const badge = document.querySelector('.badge');
      if (badge) {
        // Jika badge ditemukan, perbarui jumlah
        if (cartItemCount > 0) {
          badge.textContent = cartItemCount;
          badge.style.display = 'inline'; // Pastikan badge terlihat
        } else {
          badge.style.display = 'none'; // Sembunyikan badge jika tidak ada item
        }
      }
    }



    document.querySelectorAll('.btn-success').forEach(button => {
      button.addEventListener('click', function () {
        // Mendapatkan target modal yang sesuai dengan tombol
        let targetModal = this.getAttribute('data-bs-target');
        let modal = new bootstrap.Modal(document.querySelector(targetModal));
        modal.show();
      });
    });

    document.addEventListener("DOMContentLoaded", function () {
      // Event listener untuk modal yang ditutup
      document.querySelectorAll('.modal').forEach(function (modal) {
        modal.addEventListener('hidden.bs.modal', function () {
          // Menghapus backdrop setelah modal ditutup
          const backdrop = document.querySelector('.modal-backdrop');
          if (backdrop) {
            backdrop.remove();
          }
        });
      });
    });

    function confirmSelesaikanPesanan(idPesanan) {
      // Konfirmasi kepada pengguna
      if (confirm("Apakah Anda yakin ingin menyelesaikan pesanan? Pastikan pesanan yang diterima sesuai.")) {
        // Kirim permintaan AJAX ke server
        fetch(`/selesaikan-pesanan/${idPesanan}`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert("Pesanan berhasil diselesaikan.");
              location.reload(); // Reload halaman untuk memperbarui status
            } else {
              alert("Gagal menyelesaikan pesanan. Silakan coba lagi.");
            }
          })
          .catch(error => {
            console.error('Error:', error);
            alert("Terjadi kesalahan. Silakan coba lagi.");
          });
      }
    }
  </script>



  <!-- PERPETAAN ------------------------------------------------------------------------------------------------------- -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const searchLocationBtn = document.getElementById("searchLocationBtn");
      const searchResults = document.getElementById("searchResults");
      const mapContainer = document.getElementById("mapContainer");

      let map, marker;

      // Inisialisasi Peta
      function initMap() {
        map = L.map("mapContainer").setView([-6.1754, 106.8272], 13); // Koordinat default Jakarta
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
          attribution: "© OpenStreetMap contributors",
        }).addTo(map);
      }

      // Tambahkan Marker Ketika Klik di Peta
      function addMapClickEvent() {
        map.on("click", (e) => {
          const { lat, lng } = e.latlng;

          // Hapus marker sebelumnya jika ada
          if (marker) {
            map.removeLayer(marker);
          }

          // Tambahkan marker baru
          marker = L.marker([lat, lng]).addTo(map).bindPopup(`Lat: ${lat}, Lng: ${lng}`).openPopup();

          // Lakukan pencarian berdasarkan koordinat
          searchProductsByLocation(lat, lng);
        });
      }

      // Fungsi Pencarian Berdasarkan Lokasi
      // function searchProductsByLocation(lat, lng) {
      //     searchResults.innerHTML = "Mencari produk di lokasi ini...";
      //     const csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute("content");

      //     fetch("/search/location", {
      //         method: "POST",
      //         headers: {
      //             "Content-Type": "application/json",
      //             "X-CSRF-TOKEN": csrfToken,
      //         },
      //         body: JSON.stringify({ latitude: lat, longitude: lng }),
      //     })
      //         .then((response) => {
      //             if (!response.ok) {
      //                 throw new Error("Gagal mencari produk.");
      //             }
      //             return response.json();
      //         })
      //         .then((data) => {
      //             displaySearchResults(data);
      //         })
      //         .catch((error) => {
      //             searchResults.innerHTML = `<p class="error">${error.message}</p>`;
      //         });
      // }

      // Tampilkan Hasil Pencarian
      // function displaySearchResults(data) {
      //     if (data.length === 0) {
      //         searchResults.innerHTML = "<p>Tidak ada produk ditemukan di lokasi ini.</p>";
      //         return;
      //     }

      //     const resultHTML = data
      //         .map((product) => {
      //             return `
      //             <div class="product-item">
      //                 <h3>${product.nama_produk}</h3>
      //                 <p>Harga: Rp${product.harga}</p>
      //                 <p>Kategori: ${product.kategori}</p>
      //             </div>`;
      //         })
      //         .join("");

      //     searchResults.innerHTML = `<div class="product-list">${resultHTML}</div>`;
      // }

      // Event Listener untuk Tombol Pencarian Lokasi
      searchLocationBtn.addEventListener("click", () => {
        mapContainer.style.display = "block";

        if (!map) {
          initMap();
          addMapClickEvent();
        }
      });
    });

  </script>
  <script>
    // Variabel peta untuk Searching
    let mapSearch, marker, circle;
    let radiusValue = 1; // Nilai default radius dalam kilometer
    const defaultLat = -6.9175; // Latitude Bandung
    const defaultLng = 107.6191; // Longitude Bandung

    // Peta untuk Searching - Inisialisasi dalam event modal
    $('#searchLocationModal').on('shown.bs.modal', function () {
      if (!mapSearch) {
        // Inisialisasi peta untuk search
        mapSearch = L.map('map').setView([defaultLat, defaultLng], 10); // Default ke Bandung
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapSearch);

        // Tambahkan marker dan lingkaran default di Bandung
        marker = L.marker([defaultLat, defaultLng]).addTo(mapSearch);
        circle = L.circle([defaultLat, defaultLng], {
          color: 'blue',
          fillColor: '#30a7d7',
          fillOpacity: 0.4,
          radius: radiusValue * 1000 // Convert km to meters
        }).addTo(mapSearch);

        // Data lokasi penjual dari server
        const penjualLokasi = @json($penjualLokasi); // Pastikan data ini sudah dikirim dari server

        // Debug: Cetak isi penjualLokasi ke console
        console.log("Data lokasi penjual:", penjualLokasi);

        // Plot tiap lokasi penjual pada peta
        penjualLokasi.forEach(({ nama_penjual, latitude, longitude }) => {
          if (latitude && longitude) {
            const markerPenjual = L.marker([latitude, longitude]).addTo(mapSearch);

            // Tambahkan popup dengan nama penjual
            markerPenjual.bindPopup(`<strong>${nama_penjual}</strong>`).openPopup();
          }
        });

        // Tambahkan event click pada peta untuk mengubah posisi marker dan lingkaran
        mapSearch.on('click', function (e) {
          const lat = e.latlng.lat;
          const lng = e.latlng.lng;

          // Pindahkan marker ke lokasi baru
          marker.setLatLng(e.latlng);

          // Pindahkan lingkaran ke lokasi baru
          circle.setLatLng(e.latlng);
        });
      }
    });

    // Fungsi untuk mengubah radius saat slider digeser
    document.getElementById('radiusSlider').addEventListener('input', function () {
      radiusValue = this.value; // Ambil nilai radius dari slider
      document.getElementById('radiusValue').innerText = radiusValue + " km";

      // Perbarui radius lingkaran jika sudah ada
      if (circle) {
        circle.setRadius(radiusValue * 1000); // Perbarui radius dalam meter
      }
    });

    document.getElementById('searchLocationBtn').addEventListener('click', function () {
      if (marker) {
        const lat = marker.getLatLng().lat;
        const lng = marker.getLatLng().lng;

        console.log(`Lokasi dipilih: Latitude ${lat}, Longitude ${lng}, Radius: ${radiusValue} km`);

        // Kirim data lokasi dan radius ke server untuk melakukan pencarian
        fetch(`/search-by-location?latitude=${lat}&longitude=${lng}&radius=${radiusValue}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Gagal memuat data. Status: ' + response.status);  // Menambahkan pengecekan status HTTP
            }
            return response.json();
          })
          .then(data => {
            console.log('Data produk yang diterima:', data.produkAll);
            // Tampilkan hasil pencarian berdasarkan lokasi dan radius
            const searchResultsDiv = document.querySelector('#search-results .product-grid');
            searchResultsDiv.innerHTML = ''; // Clear hasil sebelumnya

            if (data.produkAll && data.produkAll.length > 0) {
              data.produkAll.forEach(product => {
                const productCard = `
                            <div class="col mb-4">
                                <div class="product-item card shadow-sm produk-item">
                                    <a href="/produk/${product.id_produk}" title="${product.nama_produk}" class="product-link" style="text-decoration: none;">
                                        <figure style="width: 100%; overflow: hidden;">
                                            <img src="/storage/${product.foto}" alt="${product.nama_produk}" class="tab-image" style="width: 100%; height: 100%; object-fit: cover;">
                                        </figure>
                                        <div class="product-details p-3">
                                            <h3>${product.nama_produk}</h3>
                                            <span class="qty">Stok: ${product.stok}</span>
                                            <span class="rating">
                                                <svg width="24" height="24" class="text-primary">                                            
                                                </svg>                                  
                                            </span>
                                            <span class="price">RP. ${new Intl.NumberFormat().format(product.harga_produk)}</span>
                                            <span>${product.user.username || 'Tidak diketahui'}</span>
                                        </div>
                                    </a>
                                    <div class="d-flex justify-content-between mt-2">
                                        <form action="/keranjang/tambah/${product.id_produk}" method="POST">
                                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                            <button type="submit" class="btn btn-primary w-100">
                                                <span>+ Keranjang</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>`;
                searchResultsDiv.innerHTML += productCard;
              });
            } else {
              searchResultsDiv.textContent = 'Tidak ada produk ditemukan dalam radius ini.';
            }

            // Tutup modal setelah pencarian selesai
            $('#searchLocationModal').modal('hide');

            // Sembunyikan elemen di dalam #banner-section
            document.querySelector('#banner-section').style.display = 'none';
          })
          .catch(error => {
            console.error('Terjadi kesalahan:', error);
            alert('Gagal melakukan pencarian berdasarkan lokasi.');
          });
      } else {
        alert("Silakan pilih lokasi pada peta terlebih dahulu.");
      }
    });






    // Variabel peta untuk Set Lokasi
    var mapSet;

    // Peta untuk Set Lokasi - Inisialisasi dalam event modal
    $('#setLocationModal').on('shown.bs.modal', function () {
      // Inisialisasi peta hanya saat modal dibuka
      if (!mapSet) {
        mapSet = L.map('mapSet').setView([-6.9175, 107.6191], 13); // Koordinat Bandung
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mapSet);

        // Marker untuk Set Lokasi
        var marker;

        // Fungsi untuk menangani pemilihan titik lokasi pada mapSet
        mapSet.on('click', function (e) {
          var lat = e.latlng.lat;
          var lng = e.latlng.lng;

          if (marker) {
            marker.setLatLng(e.latlng);
          } else {
            marker = L.marker(e.latlng).addTo(mapSet);
          }

          document.getElementById('latitude').value = lat;
          document.getElementById('longitude').value = lng;
        });
      }
    });








  </script>


</body>

</html>