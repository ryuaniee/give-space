<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bukti Transaksi - {{ $transaction->transaction_code }}</title>
    <style>
        @page {
            margin: 35px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 12px;
            line-height: 1.6;
        }

        .header {
            border-bottom: 2px solid #111827;
            padding-bottom: 18px;
            margin-bottom: 25px;
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
        }

        .title {
            margin-top: 4px;
            color: #6b7280;
        }

        .status {
            float: right;
            padding: 5px 10px;
            border-radius: 20px;
            background: #f3f4f6;
            font-size: 11px;
            font-weight: bold;
        }

        .section {
            margin-bottom: 22px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 7px 0;
            vertical-align: top;
        }

        td:first-child {
            width: 35%;
            color: #6b7280;
        }

        .amount {
            font-size: 20px;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            color: #9ca3af;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="status">{{ ucfirst($transaction->status) }}</div>
        <div class="brand">Give Space</div>
        <div class="title">Bukti Transaksi Donasi</div>
    </div>

    <div class="section">
        <div class="section-title">Informasi Transaksi</div>
        <table>
            <tr>
                <td>Kode Transaksi</td>
                <td><strong>{{ $transaction->transaction_code }}</strong></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
            </tr>
            <tr>
                <td>Metode Pembayaran</td>
                <td>{{ $transaction->payment_method === 'qris' ? 'QRIS' : 'Transfer Rekening' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Donatur</div>
        <table>
            <tr>
                <td>Nama</td>
                <td>{{ $transaction->user->name }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $transaction->user->email }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Campaign</div>
        <table>
            <tr>
                <td>Nama Campaign</td>
                <td>{{ $transaction->campaign->title }}</td>
            </tr>
            <tr>
                <td>Nominal Donasi</td>
                <td class="amount">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    @if($transaction->status === 'rejected' && $transaction->rejection_reason)
        <div class="section">
            <div class="section-title">Alasan Penolakan</div>
            <div>{{ $transaction->rejection_reason }}</div>
        </div>
    @endif

    @if($transaction->verified_at)
        <div class="section">
            <div class="section-title">Verifikasi</div>
            <div>Transaksi diverifikasi pada {{ $transaction->verified_at->format('d M Y, H:i') }}.</div>
        </div>
    @endif

    <div class="footer">
        Dokumen ini dibuat secara otomatis oleh sistem Give Space.
    </div>
</body>

</html>