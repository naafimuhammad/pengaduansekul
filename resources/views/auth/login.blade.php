<!DOCTYPE html>
<html lang="id"> <head>
    <meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>Login - Pengaduan Sekolah</title> <style>
        /* Mengatur tampilan dasar body halaman */
        body { 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; /* Font cadangan jika font utama tidak ada */
            background-color: #f0f2f5; /* Warna latar belakang abu-abu muda khas aplikasi modern */
            display: flex; /* Mengaktifkan flexbox untuk pengaturan posisi */
            justify-content: center; /* Menengahkan konten secara horizontal */
            align-items: center; /* Menengahkan konten secara vertikal */
            height: 100vh; /* Mengatur tinggi body sesuai tinggi layar penuh */
            margin: 0; /* Menghilangkan margin bawaan browser */
        }

        /* Mengatur kotak putih (card) sebagai wadah utama form */
        .card { 
            background: white; /* Warna latar belakang putih */
            padding: 40px; /* Jarak antara isi dengan tepi kotak */
            border-radius: 16px; /* Membuat sudut kotak menjadi tumpul/bulat */
            width: 100%; /* Lebar responsif */
            max-width: 380px; /* Batas lebar maksimal kotak */
            box-shadow: 0 10px 25px rgba(0,0,0,0.08); /* Memberikan efek bayangan lembut agar terlihat melayang */
        }

        /* Mengatur style judul utama di dalam card */
        .card h2 { 
            text-align: center; /* Teks di tengah */
            color: #1c1e21; /* Warna teks hitam pekat */
            margin-bottom: 8px; /* Jarak bawah judul */
            font-size: 24px; /* Ukuran teks judul */
        }

        /* Mengatur teks sub-judul di bawah judul utama */
        .card p.subtitle {
            text-align: center;
            color: #606770; /* Warna teks abu-abu */
            font-size: 14px;
            margin-bottom: 24px; /* Memberi jarak ke elemen form di bawahnya */
        }

        /* Style untuk label input agar terlihat lebih profesional */
        label {
            font-size: 14px;
            font-weight: 600; /* Menebalkan teks label */
            color: #4b4b4b;
            display: block; /* Memaksa label berada di baris sendiri */
            margin-bottom: 5px;
        }

        /* Mengatur tampilan kolom input teks dan password */
        input { 
            width: 100%; 
            padding: 12px 16px; 
            margin-bottom: 20px; 
            border: 1px solid #dddfe2; /* Garis tepi tipis abu-abu */
            border-radius: 8px; /* Sudut input agak membulat */
            box-sizing: border-box; /* Memastikan padding tidak menambah lebar elemen */
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s; /* Efek transisi saat diklik */
        }

        /* Efek saat pengguna mengklik atau fokus pada kolom input */
        input:focus {
            border-color: #1877f2; /* Warna garis berubah jadi biru */
            outline: none;
            box-shadow: 0 0 0 2px rgba(24, 119, 242, 0.2); /* Memberikan efek cahaya biru di sekitar input */
        }

        /* Mengatur tampilan tombol login */
        button { 
            width: 100%; 
            padding: 12px; 
            background: #1877f2; /* Warna biru khas tombol utama */
            color: white; 
            border: none; 
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer; /* Mengubah kursor menjadi tangan saat diarahkan ke tombol */
            transition: background 0.3s;
            margin-top: 10px;
        }

        /* Efek warna saat tombol diarahkan kursor (hover) */
        button:hover { 
            background: #166fe5; /* Warna biru sedikit lebih gelap */
        }

        /* Style untuk kotak pesan kesalahan (error message) */
        .error { 
            background: #ffebe8; /* Latar belakang merah muda pucat */
            color: #d0342c; /* Warna teks merah tua */
            padding: 12px;
            border-radius: 8px;
            font-size: 13px; 
            text-align: center;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        /* Mengatur teks bagian bawah (link daftar) */
        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #606770;
        }

        /* Style khusus untuk link (hyperlink) */
        .footer-text a {
            color: #1877f2;
            text-decoration: none; /* Menghilangkan garis bawah default */
            font-weight: 600;
        }

        /* Efek saat link diarahkan kursor */
        .footer-text a:hover {
            text-decoration: underline; /* Muncul garis bawah saat hover */
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Selamat Datang</h2>
        <p class="subtitle">Silakan login untuk masuk ke sistem pengaduan</p>

        @if(session('error'))
            <div class="error">
                {{ session('error') }} </div>
        @endif

        <form action="/login-proses" method="POST">
            @csrf <label for="username">User</label>
            <input type="text" id="username" name="username" required placeholder="Username Anda">
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required placeholder="Password Anda">
            
            <button type="submit">Masuk Ke Sistem</button>
        </form>

        <div class="footer-text">
            Siswa belum punya akun? <a href="/register">Daftar di sini</a>
        </div>
    </div>

</body>
</html>