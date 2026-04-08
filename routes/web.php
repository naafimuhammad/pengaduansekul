<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage; 

/**
 * ==========================================
 * HALAMAN UTAMA & AUTHENTICATION
 * ==========================================
 */

// Mengarahkan halaman utama langsung ke login
Route::get('/', function () {
    return redirect('/login');
});

// Menampilkan form pendaftaran
Route::get('/register', function () {
    return view('auth.register');
});

// Proses registrasi: Simpan data ke tabel Siswa dan Admin (sebagai user)
Route::post('/register-proses', function (Request $request) {
    // Simpan identitas ke tabel Siswa
    DB::insert("INSERT INTO Siswa (nis, kelas) VALUES (?, ?)", [$request->nis, $request->kelas]);
    // Simpan akun login ke tabel Admin (Username menggunakan NIS)
    DB::insert("INSERT INTO Admin (username, password) VALUES (?, ?)", [$request->nis, $request->password]);
    
    return redirect('/login')->with('success', 'Registrasi Berhasil!');
});

// Menampilkan halaman login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Proses validasi login dan pengalihan Role (Siswa vs Admin)
Route::post('/login-proses', function (Request $request) {
    $u = trim($request->username);
    $p = $request->password;

    // Cek kecocokan kredensial
    $user = DB::selectOne("SELECT * FROM Admin WHERE username = ? AND password = ?", [$u, $p]);

    if ($user) {
        Session::put('user_login', $user->username);
        
        // Cek apakah username ini terdaftar sebagai Siswa
        $isSiswa = DB::selectOne("SELECT * FROM Siswa WHERE nis = ?", [$user->username]);
        if ($isSiswa) {
            return redirect('/aspirasi'); // Jika siswa, ke form aspirasi
        } else {
            return redirect('/admin');    // Jika bukan siswa, ke dashboard admin
        }
    }
    return back()->with('error', 'Gagal! Username/Password salah atau gak terdaftar.');
});

// Proses keluar dari sistem (Hapus Session)
Route::get('/logout', function () {
    Session::forget('user_login');
    return redirect('/login');
});


/**
 * ==========================================
 * FITUR SISWA (PELAPORAN/ASPIRASI)
 * ==========================================
 */

// Menampilkan form input aspirasi (Hanya untuk yang sudah login)
Route::get('/aspirasi', function () {
    if (!Session::has('user_login')) return redirect('/login');
    $kategori = DB::select("SELECT * FROM Kategori");
    return view('form_aspirasi', ['kategori' => $kategori]);
});

// Proses pengiriman aspirasi beserta upload foto
Route::post('/kirim-aspirasi', function (Illuminate\Http\Request $request) {
    $nama_foto = null;

    // Logika upload file foto jika ada
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $nama_foto = time() . "_" . $file->getClientOriginalName();
        $file->move(public_path('img_laporan'), $nama_foto);
    }

    // Insert data ke tabel Input_Aspirasi dan ambil ID terakhir
    $id = DB::table('Input_Aspirasi')->insertGetId([
        'nis'         => $request->nis,
        'id_kategori' => $request->id_kategori,
        'lokasi'      => $request->lokasi,
        'ket'         => $request->ket,
        'foto'        => $nama_foto,
        'created_at'  => now(),
    ]);

    // Secara otomatis membuat status laporan di tabel Aspirasi
    DB::table('Aspirasi')->insert([
        'id_aspirasi' => $id,
        'status'      => 'Menunggu',
        'feedback'    => 'Belum ada tanggapan',
    ]);

    return back()->with('success', 'Aspirasi berhasil dikirim!');
});


/**
 * ==========================================
 * FITUR ADMIN (MANAJEMEN & FILTER)
 * ==========================================
 */

// Dashboard Admin: Menampilkan semua laporan dengan fitur Filter Tanggal/Bulan
Route::get('/admin', function (Illuminate\Http\Request $request) {
    if (!Session::has('user_login')) return redirect('/login');
    
    $query = "SELECT i.*, a.status, a.feedback, k.ket_kategori 
              FROM Input_Aspirasi i
              JOIN Aspirasi a ON i.id_pelaporan = a.id_aspirasi
              JOIN Kategori k ON i.id_kategori = k.id_kategori WHERE 1=1";
    $params = [];

    // Filter berdasarkan tanggal spesifik
    if ($request->tanggal) {
        $query .= " AND DATE(i.created_at) = ?";
        $params[] = $request->tanggal;
    }

    // Filter berdasarkan bulan (Format: YYYY-MM)
    if ($request->bulan) {
        $query .= " AND DATE_FORMAT(i.created_at, '%Y-%m') = ?";
        $params[] = $request->bulan;
    }

    $query .= " ORDER BY i.id_pelaporan DESC";
    
    $aspirasi = DB::select($query, $params);
    return view('admin_dashboard', ['aspirasi' => $aspirasi]);
});

// Admin memberikan feedback (balasan) dan mengubah status laporan
Route::post('/update-aspirasi/{id}', function (Illuminate\Http\Request $request, $id) {
    DB::update("UPDATE Aspirasi SET status = ?, feedback = ? WHERE id_aspirasi = ?", [
        $request->status,
        $request->feedback,
        $id
    ]);
    return back()->with('success', 'Status aspirasi berhasil diperbarui!');
});


/**
 * ==========================================
 * CRUD KATEGORI (PENGELOLAAN DATA MASTER)
 * ==========================================
 */

// Menambah kategori pengaduan baru
Route::post('/tambah-kategori', function (Illuminate\Http\Request $request) {
    if($request->ket_kategori) {
        DB::insert("INSERT INTO Kategori (ket_kategori) VALUES (?)", [$request->ket_kategori]);
    }
    return back()->with('success', 'Kategori baru berhasil ditambahkan!');
});

// Mengubah/Edit nama kategori
Route::post('/edit-kategori/{id}', function (Illuminate\Http\Request $request, $id) {
    DB::update("UPDATE Kategori SET ket_kategori = ? WHERE id_kategori = ?", [$request->ket_kategori, $id]);
    return back()->with('success', 'Kategori diperbarui!');
});

// Menghapus kategori
Route::get('/hapus-kategori/{id}', function ($id) {
    DB::delete("DELETE FROM Kategori WHERE id_kategori = ?", [$id]);
    return back()->with('success', 'Kategori dihapus!');
});