<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kwitansi Pembayaran - {{ $pembayaran->kode_transaksi }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
    }
    .receipt-container {
      max-width: 780px;
      margin: 30px auto;
      background: #fff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      position: relative;
    }
    .receipt-header {
      border-bottom: 2.5px solid #0d6efd;
      padding-bottom: 18px;
      margin-bottom: 25px;
    }
    .watermark-paid {
      position: absolute;
      top: 45%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-25deg);
      font-size: 5.5rem;
      font-weight: 900;
      color: rgba(25, 135, 84, 0.12);
      border: 8px dashed rgba(25, 135, 84, 0.2);
      padding: 10px 40px;
      border-radius: 20px;
      pointer-events: none;
      text-transform: uppercase;
    }
    @media print {
      body {
        background: #fff;
      }
      .no-print {
        display: none !important;
      }
      .receipt-container {
        box-shadow: none;
        margin: 0;
        padding: 20px;
        max-width: 100%;
      }
    }
  </style>
</head>
<body>

<div class="container py-3 no-print text-center">
  <button onclick="window.print()" class="btn btn-primary px-4 me-2">
    <i class="bi bi-printer me-1"></i> Cetak Kwitansi
  </button>
  <button onclick="window.close()" class="btn btn-secondary px-3">
    Tutup
  </button>
</div>

<div class="receipt-container position-relative">
  @if($pembayaran->status_pembayaran === 'lunas')
    <div class="watermark-paid">LUNAS</div>
  @endif

  <!-- Header Sekolah -->
  <div class="receipt-header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
      <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" style="height: 65px;" onerror="this.style.display='none'">
      <div>
        <h4 class="fw-bold mb-0 text-primary text-uppercase">SD ISLAM PLUS AL-WAFA</h4>
        <div class="small text-muted">Jl. Daeng Kamboja, Perumahan BSI Blok B3 No. 12, Batam</div>
        <div class="small text-muted font-monospace">NPSN: 69988221 | Telp: (0778) 465221 / WA: 0812-7000-8891</div>
      </div>
    </div>
    <div class="text-end">
      <h5 class="fw-bold text-dark mb-0">KWITANSI RESMI</h5>
      <span class="badge bg-light text-dark border font-monospace">{{ $pembayaran->kode_transaksi }}</span>
    </div>
  </div>

  <!-- Rincian Pembayaran -->
  <div class="row mb-4">
    <div class="col-7">
      <table class="table table-sm table-borderless small mb-0">
        <tr>
          <td style="width: 130px;" class="text-muted">Telah Terima Dari</td>
          <td class="fw-bold">: {{ $pembayaran->calonSiswa->nama_lengkap ?? '-' }}</td>
        </tr>
        <tr>
          <td class="text-muted">No. Registrasi</td>
          <td class="font-monospace">: {{ $pembayaran->calonSiswa->no_pendaftaran ?? '-' }}</td>
        </tr>
        <tr>
          <td class="text-muted">Nama Orang Tua</td>
          <td>: {{ $pembayaran->calonSiswa->nama_ayah ?: ($pembayaran->calonSiswa->nama_ibu ?: '-') }}</td>
        </tr>
      </table>
    </div>
    <div class="col-5">
      <table class="table table-sm table-borderless small mb-0">
        <tr>
          <td style="width: 100px;" class="text-muted">Tanggal Bayar</td>
          <td>: {{ $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->translatedFormat('d F Y') : date('d F Y') }}</td>
        </tr>
        <tr>
          <td class="text-muted">Metode</td>
          <td>: {{ $pembayaran->metode_pembayaran }}</td>
        </tr>
        <tr>
          <td class="text-muted">Status</td>
          <td class="fw-bold text-success">: {{ strtoupper($pembayaran->status_pembayaran) }}</td>
        </tr>
      </table>
    </div>
  </div>

  <!-- Item Pembayaran -->
  <table class="table table-bordered align-middle mb-4">
    <thead class="table-light">
      <tr>
        <th style="width: 5%" class="text-center">No</th>
        <th>Deskripsi / Peruntukan Pembayaran</th>
        <th class="text-end" style="width: 30%">Jumlah</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="text-center">1</td>
        <td>
          <strong class="d-block text-dark">{{ $pembayaran->biaya->nama_biaya ?? 'Pembayaran PPDB' }}</strong>
          <small class="text-muted">{{ $pembayaran->catatan ?: 'Pembayaran biaya pendaftaran / operasional PPDB' }}</small>
        </td>
        <td class="text-end font-monospace fw-bold fs-6">
          Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}
        </td>
      </tr>
      <tr class="table-light">
        <td colspan="2" class="text-end fw-bold">TOTAL PEMBAYARAN:</td>
        <td class="text-end font-monospace fw-bold fs-5 text-success">
          Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Tanda Tangan Kwitansi -->
  <div class="row pt-3 mt-4">
    <div class="col-6">
      <div class="border p-2 rounded bg-light small">
        <i class="bi bi-info-circle text-primary me-1"></i><strong>Perhatian:</strong>
        <p class="mb-0 text-muted" style="font-size: 0.76rem;">Kwitansi ini adalah bukti pembayaran yang sah dari Panitia PPDB SD Islam Plus Al-Wafa Batam. Harap disimpan dengan baik.</p>
      </div>
    </div>
    <div class="col-6 text-center">
      <div class="small text-muted mb-5">Batam, {{ date('d F Y') }}<br>Bendahara PPDB,</div>
      <div class="fw-bold text-dark text-decoration-underline mt-4">{{ $pembayaran->verifikator->name ?? 'Bendahara Sekolah' }}</div>
      <div class="small text-muted">SD Islam Plus Al-Wafa Batam</div>
    </div>
  </div>

</div>

</body>
</html>
