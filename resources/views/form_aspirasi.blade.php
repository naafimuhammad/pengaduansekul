<div class="container" style="padding: 20px;">
    <!-- Container utama halaman (wrapper seluruh isi halaman) -->

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <!-- Header atas: judul halaman + tombol logout sejajar -->
        <h2>Kirim Aspirasi Baru</h2>
        <!-- Judul halaman -->
        <a href="/logout" style="color: red; text-decoration: none; font-weight: bold;">Logout</a>
        <!-- Tombol logout user -->
    </div>

    <hr>
    <!-- Garis pemisah -->

    <div style="background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 30px;">
        <!-- Box form input aspirasi -->

        <form action="/kirim-aspirasi" method="POST" enctype="multipart/form-data">
            <!-- Form kirim aspirasi ke server + bisa upload file -->

            @csrf
            <!-- Token keamanan Laravel agar form tidak ditolak -->

            <input type="hidden" name="nis" value="{{ Session::get('user_login') }}">
            <!-- Mengambil NIS user yang sedang login dari session -->

            <div style="margin-bottom: 10px;">
                <!-- Input kategori aspirasi -->
                <label style="display: block; font-weight: bold;">Kategori :</label>
                <select name="id_kategori" style="width: 100%; padding: 8px;">
                    <!-- Dropdown kategori dari database -->
                    @foreach($kategori as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 10px;">
                <!-- Input lokasi kejadian -->
                <label style="display: block; font-weight: bold;">Lokasi Kejadian :</label>
                <input type="text" name="lokasi" required placeholder="Contoh: Kantin, Kelas 10, dll" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 10px;">
                <!-- Input detail aspirasi -->
                <label style="display: block; font-weight: bold;">Detail Aspirasi :</label>
                <textarea name="ket" required placeholder="Ceritakan detail kejadian..." style="width: 100%; padding: 8px; height: 100px; box-sizing: border-box;"></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <!-- Upload bukti foto -->
                <label style="display: block; font-weight: bold;">Bukti Foto :</label>
                <input type="file" name="foto" accept="image/*" required style="padding: 5px;">
            </div>

            <button type="submit" style="background: #28a745; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; font-weight: bold;">
                <!-- Tombol kirim form -->
                Kirim Laporan Sekarang
            </button>
        </form>
    </div>

    <hr>

    <h3>Histori Aspirasi Saya</h3>
    <!-- Judul tabel riwayat laporan user -->

    <table border="1" width="100%" style="border-collapse: collapse; background: white;">
        <!-- Tabel histori aspirasi -->

        <thead style="background: #333; color: white;">
            <!-- Header tabel -->
            <tr>
                <th width="150">Tanggal</th>
                <th width="100">Foto</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Umpan Balik (Feedback)</th>
            </tr>
        </thead>

        <tbody>
            @php
                // Query ambil data aspirasi user dari database
                $histori = DB::select("SELECT i.*, a.status, a.feedback, k.ket_kategori 
                                     FROM Input_Aspirasi i 
                                     JOIN Aspirasi a ON i.id_pelaporan = a.id_aspirasi 
                                     JOIN Kategori k ON i.id_kategori = k.id_kategori 
                                     WHERE i.nis = ?", [Session::get('user_login')]);
            @endphp

            @foreach($histori as $h)
            <!-- Loop data histori aspirasi -->

            <tr>
                <td align="center">{{ $h->created_at ?? 'Baru saja' }}</td>
                <!-- Tanggal laporan -->

                <td align="center">
                    <!-- Foto bukti -->
                    @if($h->foto)
                        <a href="{{ asset('img_laporan/'.$h->foto) }}" target="_blank">
                            <!-- Klik foto untuk lihat full -->
                            <img src="{{ asset('img_laporan/'.$h->foto) }}" width="70" style="border-radius: 4px; border: 1px solid #ddd;">
                        </a>
                    @else
                        <span style="color: #ccc; font-size: 11px;">Gak ada foto</span>
                        <!-- Jika tidak ada foto -->
                    @endif
                </td>

                <td style="padding: 10px;">{{ $h->ket_kategori }}</td>
                <!-- Nama kategori -->

                <td align="center">
                    <!-- Status laporan (Selesai / Proses / Ditolak) -->
                    <span style="padding: 5px 10px; border-radius: 15px; font-size: 12px; 
                        background: {{ $h->status == 'Selesai' ? '#d4edda' : ($h->status == 'Proses' ? '#fff3cd' : '#f8d7da') }};
                        color: {{ $h->status == 'Selesai' ? '#155724' : ($h->status == 'Proses' ? '#856404' : '#721c24') }};">
                        <b>{{ $h->status }}</b>
                    </span>
                </td>

                <td style="padding: 10px;">
                    <!-- Feedback dari admin/guru -->
                    {{ $h->feedback ?? 'Belum ada tanggapan' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>