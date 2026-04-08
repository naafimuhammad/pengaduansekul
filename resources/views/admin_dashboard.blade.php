<div class="container" style="padding: 20px;">

    <!-- HEADER DASHBOARD ADMIN -->
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Dashboard Admin - Pengaduan Sekolah</h2>

        <!-- tombol logout untuk keluar dari sistem -->
        <a href="/logout" style="color: red; text-decoration: none; font-weight: bold;">Logout</a>
    </div>

    <hr>

    <!-- ========================= -->
    <!-- MANAGEMEN KATEGORI -->
    <!-- ========================= -->
    <div style="background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 30px;">
        <h3>Manajemen Kategori</h3>

        <!-- form tambah kategori baru -->
        <form action="/tambah-kategori" method="POST" style="margin-bottom: 15px; display: flex; gap: 10px;">
            @csrf
            <input type="text" name="ket_kategori" required placeholder="Nama Kategori Baru" style="padding: 8px; flex: 1;">

            <!-- tombol submit tambah kategori -->
            <button type="submit" style="background: #28a745; color: white; border: none; padding: 8px 15px; cursor: pointer;">
                + Tambah
            </button>
        </form>

        <!-- tabel daftar kategori -->
        <table border="1" width="100%" style="border-collapse: collapse; background: white;">
            <thead style="background: #eee;">
                <tr>
                    <th width="50">ID</th>
                    <th>Nama Kategori</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @php
                    // mengambil semua data kategori dari database
                    $semua_kategori = DB::select("SELECT * FROM Kategori");
                @endphp

                @foreach($semua_kategori as $kat)
                <tr>

                    <!-- menampilkan ID kategori -->
                    <td align="center">{{ $kat->id_kategori }}</td>

                    <td>
                        <!-- form edit kategori -->
                        <form action="/edit-kategori/{{ $kat->id_kategori }}" method="POST" style="display: flex; gap: 5px; margin: 5px;">
                            @csrf

                            <!-- input edit nama kategori -->
                            <input type="text" name="ket_kategori" value="{{ $kat->ket_kategori }}" style="padding: 5px; flex: 1;">

                            <!-- tombol update kategori -->
                            <button type="submit" style="background: #ffc107; border: none; padding: 5px 10px; cursor: pointer;">
                                Update
                            </button>
                        </form>
                    </td>

                    <td align="center">
                        <!-- tombol hapus kategori -->
                        <a href="/hapus-kategori/{{ $kat->id_kategori }}"
                           onclick="return confirm('Hapus?')"
                           style="background: red; color: white; padding: 5px; text-decoration: none; font-size: 12px;">
                           Hapus
                        </a>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <hr>

    <!-- ========================= -->
    <!-- FILTER ASPIRASI -->
    <!-- ========================= -->
    <h3>List Aspirasi Masuk</h3>

    <div style="background: #fff; padding: 15px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 15px;">

        <!-- form filter data aspirasi -->
        <form action="/admin" method="GET" style="display: flex; gap: 15px; align-items: flex-end;">

            <!-- filter berdasarkan tanggal -->
            <div>
                <label style="display: block; font-size: 11px;">Tanggal:</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}">
            </div>

            <!-- filter berdasarkan bulan -->
            <div>
                <label style="display: block; font-size: 11px;">Bulan:</label>
                <input type="month" name="bulan" value="{{ request('bulan') }}">
            </div>

            <!-- tombol cari filter -->
            <button type="submit" style="background: #007bff; color: white; border: none; padding: 5px 15px; cursor: pointer;">
                Cari
            </button>

            <!-- reset filter -->
            <a href="/admin">Reset</a>
        </form>
    </div>

    <!-- ========================= -->
    <!-- TABEL ASPIRASI -->
    <!-- ========================= -->
    <table border="1" width="100%" style="border-collapse: collapse;">
        <thead style="background: #333; color: white;">
            <tr>
                <th>NIS</th>
                <th>Foto</th>
                <th>Kategori</th>
                <th>Isi Aspirasi</th>
                <th>Status</th>
                <th>Umpan Balik (Aksi)</th>
            </tr>
        </thead>

        <tbody>
            @foreach($aspirasi as $a)
            <tr>

                <!-- NIS siswa -->
                <td align="center">{{ $a->nis }}</td>

                <!-- foto laporan (jika ada) -->
                <td align="center">
                    @if($a->foto)
                        <a href="{{ asset('img_laporan/'.$a->foto) }}" target="_blank">
                            <img src="{{ asset('img_laporan/'.$a->foto) }}" width="60">
                        </a>
                    @else
                        -
                    @endif
                </td>

                <!-- kategori aspirasi -->
                <td>{{ $a->ket_kategori }}</td>

                <!-- isi laporan -->
                <td>{{ $a->ket }}</td>

                <!-- status laporan -->
                <td align="center"><b>{{ $a->status }}</b></td>

                <!-- form update status + feedback -->
                <td>
                    <form action="/update-aspirasi/{{ $a->id_pelaporan }}" method="POST">
                        @csrf

                        <!-- dropdown ubah status -->
                        <select name="status">
                            <option value="Menunggu" {{ $a->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Proses" {{ $a->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai" {{ $a->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>

                        <!-- input feedback dari admin -->
                        <input type="text" name="feedback" value="{{ $a->feedback }}" placeholder="Feedback">

                        <!-- tombol update -->
                        <button type="submit">Update</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>