<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Surat Keterangan Penerimaan - {{ $calonSiswa->nama_lengkap }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Times New Roman', Times, serif;
      color: #111;
      line-height: 1.6;
    }
    .letter-container {
      max-width: 800px;
      margin: 25px auto;
      background: #fff;
      padding: 50px 60px;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      position: relative;
    }
    .kop-surat {
      border-bottom: 3px double #000;
      padding-bottom: 12px;
      margin-bottom: 25px;
    }
    .kop-logo {
      height: 75px;
    }
    .badge-decision {
      display: inline-block;
      border: 2px solid #198754;
      color: #198754;
      background-color: #f0fff4;
      font-size: 1.4rem;
      font-weight: 800;
      letter-spacing: 3px;
      padding: 6px 32px;
      border-radius: 6px;
      text-transform: uppercase;
    }
    .badge-rejected {
      display: inline-block;
      border: 2px solid #dc3545;
      color: #dc3545;
      background-color: #fff5f5;
      font-size: 1.4rem;
      font-weight: 800;
      letter-spacing: 3px;
      padding: 6px 32px;
      border-radius: 6px;
      text-transform: uppercase;
    }
    .table-data td {
      padding: 4px 6px;
      font-size: 1.05rem;
    }
    @media print {
      body {
        background: #fff;
        margin: 0;
        padding: 0;
      }
      .no-print {
        display: none !important;
      }
      .letter-container {
        box-shadow: none;
        margin: 0;
        padding: 20px 30px;
        max-width: 100%;
        border-radius: 0;
      }
    }
  </style>
</head>
<body>

<div class="container py-3 no-print text-center">
  <button onclick="window.print()" class="btn btn-primary px-4 me-2">
    <i class="bi bi-printer me-1"></i> Cetak Surat Keputusan
  </button>
  <button onclick="window.close()" class="btn btn-secondary px-3">
    Tutup
  </button>
</div>

<div class="letter-container">
  <!-- Kop Surat Resmi -->
  <div class="kop-surat d-flex align-items-center gap-4 text-center">
    <div>
      <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="kop-logo" onerror="this.style.display='none'">
    </div>
    <div class="flex-grow-1">
      <h6 class="mb-0 fw-normal text-uppercase" style="letter-spacing: 1px;">YAYASAN AL-WAFA BATAM</h6>
      <h4 class="fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">SD ISLAM PLUS AL-WAFA</h4>
      <div style="font-size: 0.9rem;">Terakreditasi "A" | NPSN: 69988221 | NSS: 102317102001</div>
      <div style="font-size: 0.82rem;" class="text-muted">
        Jl. Daeng Kamboja, Komplek Perumahan BSI Blok B3 No. 12, Kel. Belian, Kec. Batam Kota, Kota Batam<br>
        Telp: (0778) 465221 | Pos-el: sdislamplusalwafa@gmail.com | Laman: sdislamplusalwafa.sch.id
      </div>
    </div>
  </div>

  <!-- Judul Surat -->
  <div class="text-center mb-4">
    <h5 class="fw-bold text-uppercase mb-1" style="text-decoration: underline; letter-spacing: 1px;">SURAT KEPUTUSAN KELULUSAN SELEKSI PPDB</h5>
    <div style="font-size: 0.95rem;">Nomor: 421.2/PPDB-ALWAFA/{{ date('Y') }}/{{ str_pad($calonSiswa->id_calon_siswa, 4, '0', STR_PAD_LEFT) }}</div>
  </div>

  <p style="text-align: justify; font-size: 1.05rem;">
    Berdasarkan hasil observasi kesiapan belajar, tes kemampuan dasar (membaca, menulis, berhitung & Al-Qur'an/Iqro), serta wawancara orang tua peserta didik baru Tahun Ajaran <strong>{{ $calonSiswa->tahunAjaran->tahun_ajaran ?? date('Y') . '/' . (date('Y')+1) }}</strong>, Panitia Penerimaan Peserta Didik Baru (PPDB) SD Islam Plus Al-Wafa Batam dengan ini menyatakan bahwa:
  </p>

  <!-- Biodata Siswa -->
  <div class="table-responsive my-3 px-3">
    <table class="table-data w-100">
      <tr>
        <td style="width: 210px;">Nomor Registrasi</td>
        <td style="width: 15px;">:</td>
        <td class="fw-bold">{{ $calonSiswa->no_pendaftaran }}</td>
      </tr>
      <tr>
        <td>Nama Lengkap Siswa</td>
        <td>:</td>
        <td class="fw-bold text-uppercase">{{ $calonSiswa->nama_lengkap }}</td>
      </tr>
      <tr>
        <td>NISN / NIK</td>
        <td>:</td>
        <td>{{ $calonSiswa->nisn ?: '-' }} / {{ $calonSiswa->nik ?: '-' }}</td>
      </tr>
      <tr>
        <td>Tempat, Tanggal Lahir</td>
        <td>:</td>
        <td>{{ $calonSiswa->tempat_lahir ?? '-' }}, {{ $calonSiswa->tanggal_lahir ? \Carbon\Carbon::parse($calonSiswa->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</td>
      </tr>
      <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td>{{ $calonSiswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
      </tr>
      <tr>
        <td>Asal Sekolah (TK/RA)</td>
        <td>:</td>
        <td>{{ $calonSiswa->asal_sekolah ?: '-' }}</td>
      </tr>
      <tr>
        <td>Nama Orang Tua / Wali</td>
        <td>:</td>
        <td>{{ $calonSiswa->nama_ayah ?: ($calonSiswa->nama_ibu ?: '-') }}</td>
      </tr>
      <tr>
        <td>Jalur Pendaftaran</td>
        <td>:</td>
        <td>{{ $calonSiswa->jalur->nama_jalur ?? 'Reguler' }} ({{ $calonSiswa->gelombang->nama_gelombang ?? 'Gelombang 1' }})</td>
      </tr>
    </table>
  </div>

  <!-- Box Status Kelulusan -->
  <div class="text-center my-4 py-2">
    @if(in_array(strtolower($calonSiswa->status ?? ''), ['lulus', 'diterima']))
      <div class="badge-decision">D I T E R I M A</div>
      <p class="mt-2 text-muted" style="font-size: 0.95rem;">Sebagai Peserta Didik Baru Kelas 1 SD Islam Plus Al-Wafa Batam</p>
    @elseif(in_array(strtolower($calonSiswa->status ?? ''), ['tidak lulus', 'ditolak']))
      <div class="badge-rejected">TIDAK DITERIMA</div>
      <p class="mt-2 text-muted" style="font-size: 0.95rem;">Mohon maaf, kuota penerimaan saat ini belum mencukupi</p>
    @else
      <div class="badge border text-dark p-2 fs-5">STATUS: {{ strtoupper(str_replace('_', ' ', $calonSiswa->status ?: 'DALAM PROSES')) }}</div>
    @endif
  </div>

  @if(in_array(strtolower($calonSiswa->status ?? ''), ['lulus', 'diterima']))
  <!-- Petunjuk Daftar Ulang -->
  <div class="border rounded p-3 my-3 bg-light" style="font-size: 0.92rem;">
    <strong class="d-block mb-1 text-primary"><i class="bi bi-info-circle-fill me-1"></i> PETUNJUK DAFTAR ULANG:</strong>
    <ol class="mb-0 ps-3">
      <li>Calon peserta didik yang dinyatakan <strong>DITERIMA</strong> wajib melakukan proses daftar ulang dan penyelesaian biaya administrasi pendidikan sesuai jadwal panitia.</li>
      <li>Membawa dan menyerahkan dokumen fisik (FC Akta Kelahiran, Kartu Keluarga, KTP Orang Tua, Pas Foto 3x4 sebanyak 3 lembar).</li>
      <li>Apabila sampai batas waktu yang ditetapkan tidak melakukan pendaftaran ulang tanpa pemberitahuan resmi, maka hak penerimaan dianggap <em>gugur / mengundurkan diri</em>.</li>
    </ol>
  </div>
  @endif

  <p style="text-align: justify; font-size: 1.05rem;" class="mt-3">
    Demikian surat keterangan ini kami sampaikan secara resmi agar dapat dipergunakan sebagaimana mestinya. Atas kepercayaan Bapak/Ibu mendaftarkan putra/putri di SD Islam Plus Al-Wafa Batam, kami ucapkan terima kasih.
  </p>

  <!-- Tanda Tangan -->
  <div class="row pt-4 mt-2">
    <div class="col-7"></div>
    <div class="col-5 text-center" style="font-size: 1.05rem;">
      <div>Batam, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
      <div>Kepala SD Islam Plus Al-Wafa,</div>
      <div style="height: 70px;"></div>
      <div class="fw-bold text-decoration-underline">H. Ahmad Fauzi, S.Pd.I., M.Pd.</div>
      <div>NIP. 19820512 200801 1 009</div>
    </div>
  </div>

</div>

</body>
</html>
