<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Judul halaman di tab browser -->
    <title>Register Siswa - Pengaduan Sekolah</title>

    <style>
        /* Mengatur tampilan body (tengah layar, background abu muda) */
        body { 
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; 
            background-color: #f0f2f5; 
            display: flex; 
            justify-content: center; 
            align-items: center;
            height: 100vh; 
            margin: 0;
        }

        /* Card utama form register */
        .card { 
            background: white;
            padding: 40px; 
            border-radius: 16px; 
            width: 100%;
            max-width: 400px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        /* Judul form */
        .card h2 { 
            text-align: center; 
            color: #1c1e21;
            margin-bottom: 8px;
            font-size: 24px;
        }

        /* Subtitle di bawah judul */
        .card p.subtitle {
            text-align: center;
            color: #606770;
            font-size: 14px;
            margin-bottom: 24px;
        }

        /* Label input */
        label {
            font-size: 14px;
            font-weight: 600;
            color: #4b4b4b;
            display: block;
            margin-bottom: 5px;
        }

        /* Style semua input form */
        input { 
            width: 100%; 
            padding: 12px 16px; 
            margin-bottom: 15px; 
            border: 1px solid #dddfe2;
            border-radius: 8px;
            box-sizing: border-box; 
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        /* Efek saat input diklik (focus) */
        input:focus {
            border-color: #28a745;
            outline: none;
            box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.2);
        }

        /* Tombol daftar */
        button { 
            width: 100%; 
            padding: 12px; 
            background: #28a745; 
            color: white; 
            border: none; 
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer; 
            transition: background 0.3s;
            margin-top: 10px;
        }

        /* Hover tombol */
        button:hover { 
            background: #218838; 
        }

        /* Text bawah (link login) */
        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #606770;
        }

        /* Link login */
        .footer-text a {
            color: #28a745;
            text-decoration: none;
            font-weight: 600;
        }

        /* Hover link login */
        .footer-text a:hover {
            text-decoration: underline;
        }

        /* Hilangkan spinner di input number (biar lebih clean) */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>

    <!-- Card utama form register -->
    <div class="card">

        <!-- Judul halaman register -->
        <h2>Daftar Akun Baru</h2>

        <!-- Deskripsi singkat form -->
        <p class="subtitle">Lengkapi data diri kamu untuk mulai melapor</p>

        <!-- Form register siswa -->
        <form action="/register-proses" method="POST">
            
            <!-- CSRF Laravel: keamanan form agar tidak bisa diakses sembarangan -->
            @csrf
            
            <!-- Input NIS (Nomor Induk Siswa) -->
            <label for="nis">NIS</label>
            <input type="number" id="nis" name="nis" required placeholder="Contoh: 10101">
            
            <!-- Input kelas siswa -->
            <label for="kelas">Kelas</label>
            <input type="text" id="kelas" name="kelas" required placeholder="Contoh: XII RPL 1">
            
            <!-- Input password akun -->
            <label for="password">Buat Password</label>
            <input type="password" id="password" name="password" required placeholder="Gunakan password yang aman">
            
            <!-- Tombol submit form -->
            <button type="submit">Daftar Sekarang</button>
        </form>

        <!-- Link ke halaman login -->
        <div class="footer-text">
            Sudah punya akun? <a href="/login">Login di sini</a>
        </div>

    </div>

</body>
</html>