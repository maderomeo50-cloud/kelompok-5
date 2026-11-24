{{-- View: menampilkan data dari TopupController dan mengirim form melalui route. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WRB.Store - Top Up Diamond</title>
    <style>
        :root {
            color-scheme: dark;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #0c0e14;
            color: #f4f5f7;
            font-synthesis: none;
        }

        * { box-sizing: border-box; }
        body { margin: 0; min-width: 320px; background: radial-gradient(ellipse at 82% 4%, #202040 0, transparent 34%), #0c0e14; }
        a { color: inherit; text-decoration: none; }
        button, input { font: inherit; }
        .shell { width: min(1120px, calc(100% - 40px)); margin: 0 auto; }
        .topbar { height: 76px; border-bottom: 1px solid #ffffff12; display: flex; align-items: center; }
        .nav { display: flex; align-items: center; justify-content: space-between; }
        .brand { display: inline-flex; gap: 10px; align-items: center; font-size: 19px; font-weight: 850; letter-spacing: -.5px; }
        .brand-mark { width: 34px; height: 34px; display: grid; place-items: center; border-radius: 11px; color: #12131a; background: #a4f177; font-size: 10px; font-weight: 900; letter-spacing: -.4px; }
        .nav-note { color: #a5a7b3; font-size: 13px; }
        .hero { display: flex; justify-content: space-between; align-items: center; gap: 24px; padding: 48px 0 30px; }
        .eyebrow { color: #a4f177; font-size: 12px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; }
        h1 { margin: 10px 0 12px; max-width: 640px; font-size: clamp(32px, 5vw, 52px); line-height: 1.06; letter-spacing: -2px; }
        .hero p { margin: 0; max-width: 570px; color: #a5a7b3; line-height: 1.7; }
        .hero-badge { flex: 0 0 auto; padding: 14px 18px; border: 1px solid #ffffff18; border-radius: 16px; background: #ffffff08; color: #d7d9e2; font-size: 13px; }
        .hero-badge strong { display: block; margin-bottom: 4px; color: #a4f177; font-size: 15px; }
        .notice { margin: 0 0 22px; padding: 13px 16px; border: 1px solid #c997382e; border-radius: 12px; background: #c9973812; color: #f5d894; font-size: 13px; line-height: 1.6; }
        .notice.success { border-color: #a4f17745; background: #a4f17712; color: #d8f8c3; }
        .notice.error { border-color: #ff777745; background: #ff777712; color: #ffb8b8; }
        .notice strong { color: inherit; }
        .layout { display: grid; grid-template-columns: minmax(0, 1fr) 340px; align-items: start; gap: 22px; padding-bottom: 50px; }
        .panel { padding: 25px; border: 1px solid #ffffff12; border-radius: 18px; background: #151720d9; box-shadow: 0 16px 48px #00000020; }
        .step { display: flex; align-items: flex-start; gap: 13px; margin-bottom: 24px; }
        .step + .step { margin-top: 29px; }
        .step-number { flex: 0 0 30px; height: 30px; display: grid; place-items: center; border-radius: 10px; background: #a4f1771c; color: #a4f177; font-size: 13px; font-weight: 800; }
        h2 { margin: 2px 0 5px; font-size: 17px; }
        .help { margin: 0; color: #9295a3; font-size: 13px; line-height: 1.6; }
        .field { margin-top: 15px; }
        .field label, .group-label { display: block; margin-bottom: 8px; color: #d5d6dd; font-size: 13px; font-weight: 700; }
        .field input { width: 100%; padding: 13px 14px; border: 1px solid #ffffff1a; border-radius: 10px; outline: none; background: #0e1017; color: #f4f5f7; }
        .field input:focus { border-color: #a4f177; box-shadow: 0 0 0 3px #a4f17720; }
        .field input::placeholder { color: #6f7280; }
        .field-error { margin: 7px 0 0; color: #ff9a9a; font-size: 12px; }
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .packages { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 11px; }
        .package-option, .payment-option { position: relative; }
        .package-option input, .payment-option input { position: absolute; width: 1px; height: 1px; opacity: 0; }
        .package-card { min-height: 96px; display: flex; flex-direction: column; justify-content: center; padding: 13px; border: 1px solid #ffffff18; border-radius: 12px; background: #10121a; cursor: pointer; transition: border-color .15s, background .15s, transform .15s; }
        .package-card:hover { transform: translateY(-2px); border-color: #ffffff45; }
        .package-option input:checked + .package-card { border-color: #a4f177; background: #a4f17712; box-shadow: inset 0 0 0 1px #a4f17740; }
        .package-option input:focus-visible + .package-card, .payment-option input:focus-visible + .payment-card { outline: 2px solid #a4f177; outline-offset: 3px; }
        .diamond-amount { color: #f4f5f7; font-size: 15px; font-weight: 800; }
        .diamond-amount span { color: #69c9ff; }
        .package-price { margin-top: 7px; color: #a4f177; font-size: 13px; font-weight: 700; }
        .payment-list { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 10px; }
        .payment-card { min-height: 48px; display: grid; place-items: center; border: 1px solid #ffffff18; border-radius: 10px; background: #10121a; color: #d5d6dd; font-size: 13px; font-weight: 700; cursor: pointer; }
        .payment-option input:checked + .payment-card { border-color: #a4f177; color: #a4f177; background: #a4f17712; }
        .submit { width: 100%; margin-top: 23px; padding: 15px 18px; border: 0; border-radius: 11px; background: #a4f177; color: #10130d; font-weight: 850; cursor: pointer; transition: filter .15s, transform .15s; }
        .submit:hover { filter: brightness(1.05); transform: translateY(-1px); }
        .summary { position: sticky; top: 20px; }
        .summary h2 { margin: 0 0 8px; font-size: 19px; }
        .summary-game { display: flex; align-items: center; gap: 12px; margin: 21px 0; padding: 13px; border-radius: 12px; background: #ffffff08; }
        .game-icon { width: 42px; height: 42px; display: grid; place-items: center; border-radius: 12px; background: linear-gradient(135deg, #1a75ac, #7448bd); font-size: 21px; }
        .summary-game strong { display: block; font-size: 13px; }
        .summary-game span { display: block; margin-top: 4px; color: #9295a3; font-size: 11px; }
        .summary-line { display: flex; justify-content: space-between; gap: 12px; padding: 12px 0; border-top: 1px solid #ffffff12; color: #a5a7b3; font-size: 13px; }
        .summary-line strong { color: #f4f5f7; text-align: right; }
        .safe-note { display: flex; gap: 9px; margin-top: 17px; padding: 12px; border-radius: 10px; background: #a4f1770d; color: #b7c9ae; font-size: 12px; line-height: 1.6; }
        .footer { padding: 20px 0 30px; border-top: 1px solid #ffffff12; color: #777a87; text-align: center; font-size: 12px; }
        .receipt { margin: 0 0 22px; }
        .receipt .summary-line:last-child { padding-bottom: 2px; }
        @media (max-width: 780px) {
            .layout { grid-template-columns: 1fr; }
            .summary { position: static; grid-row: 1; }
            .hero { align-items: flex-start; flex-direction: column; padding-top: 35px; }
            .hero-badge { display: none; }
        }
        @media (max-width: 520px) {
            .shell { width: min(100% - 26px, 1120px); }
            .topbar { height: 64px; }
            .nav-note { font-size: 11px; }
            .hero { padding: 31px 0 22px; }
            h1 { letter-spacing: -1px; }
            .panel { padding: 18px; border-radius: 14px; }
            .packages { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .field-row { grid-template-columns: 1fr; gap: 0; }
            .payment-list { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <nav class="shell nav" aria-label="Navigasi utama">
            <a class="brand" href="{{ route('topup.index') }}">
                <span class="brand-mark" aria-hidden="true">WRB</span>
                <span>WRB<span style="color:#a4f177">.Store</span></span>
            </a>
            <span class="nav-note">Top up game jadi lebih praktis</span>
        </nav>
    </header>

    <main class="shell">
        <section class="hero">
            <div>
                <div class="eyebrow">Cepat · Praktis · Aman</div>
                <h1>Top up diamond,<br>lanjutkan kemenangan.</h1>
                <p>Pilih nominal diamond, masukkan ID akun, lalu pilih metode pembayaran. Halaman ini adalah simulasi untuk demonstrasi project UAS.</p>
            </div>
            <div class="hero-badge"><strong>Project UAS</strong>Contoh Controller &amp; View Laravel</div>
        </section>

        <div class="notice">
            <strong>Mode demonstrasi.</strong> Harga dan konfirmasi pesanan hanya contoh. Tidak ada pembayaran atau pengiriman diamond sungguhan.
        </div>

        @if ($order)
            <section class="panel receipt" aria-live="polite">
                <div class="eyebrow">Pesanan berhasil dibuat</div>
                <h2 style="margin-top:8px">Konfirmasi simulasi</h2>
                <p class="help">Tidak ada transaksi yang diproses. Berikut ringkasan data yang dikirim ke Controller.</p>
                <div class="summary-line"><span>Nomor pesanan</span><strong>{{ $order['order_number'] }}</strong></div>
                <div class="summary-line"><span>ID akun</span><strong>{{ $order['player_id'] }} ({{ $order['server_id'] }})</strong></div>
                <div class="summary-line"><span>Diamond</span><strong>{{ number_format($order['diamonds'], 0, ',', '.') }} Diamond</strong></div>
                <div class="summary-line"><span>Metode</span><strong>{{ $order['payment_method'] }}</strong></div>
                <div class="summary-line"><span>Total simulasi</span><strong>Rp{{ number_format($order['price'], 0, ',', '.') }}</strong></div>
            </section>
        @endif

        @if ($errors->any())
            <div class="notice error" role="alert">Periksa kembali formulir. Ada data yang belum valid.</div>
        @endif

        <div class="layout">
            <form class="panel" action="{{ route('topup.store') }}" method="POST">
                @csrf
                <section>
                    <div class="step">
                        <span class="step-number">1</span>
                        <div>
                            <h2>Masukkan data akun</h2>
                            <p class="help">Pastikan ID dan server sesuai dengan akun game kamu.</p>
                        </div>
                    </div>
                    <div class="field-row">
                        <div class="field">
                            <label for="player_id">User ID</label>
                            <input id="player_id" name="player_id" type="text" value="{{ old('player_id') }}" placeholder="Contoh: 12345678" maxlength="30" autocomplete="off" required aria-describedby="player-id-error">
                            @error('player_id')<p class="field-error" id="player-id-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="server_id">Zone / Server ID</label>
                            <input id="server_id" name="server_id" type="text" value="{{ old('server_id') }}" placeholder="Contoh: 1234" maxlength="10" autocomplete="off" required aria-describedby="server-id-error">
                            @error('server_id')<p class="field-error" id="server-id-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </section>

                <section class="step" style="margin-top:32px">
                    <span class="step-number">2</span>
                    <div style="width:100%">
                        <h2>Pilih nominal diamond</h2>
                        <p class="help" style="margin-bottom:15px">Pilih salah satu paket yang tersedia.</p>
                        <div class="packages">
                            @foreach ($packages as $code => $package)
                                <label class="package-option">
                                    <input type="radio" name="package" value="{{ $code }}" @checked(old('package', '86') === $code) required>
                                    <span class="package-card">
                                        <span class="diamond-amount"><span aria-hidden="true">◆</span> {{ number_format($package['diamonds'], 0, ',', '.') }}</span>
                                        <span class="package-price">Rp{{ number_format($package['price'], 0, ',', '.') }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('package')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </section>

                <section class="step" style="margin-top:32px">
                    <span class="step-number">3</span>
                    <div style="width:100%">
                        <h2>Pilih metode pembayaran</h2>
                        <p class="help" style="margin-bottom:15px">Metode hanya untuk contoh tampilan, bukan transaksi nyata.</p>
                        <div class="payment-list">
                            @foreach ($paymentMethods as $value => $label)
                                <label class="payment-option">
                                    <input type="radio" name="payment_method" value="{{ $value }}" @checked(old('payment_method', 'qris') === $value) required>
                                    <span class="payment-card">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('payment_method')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                </section>

                <button class="submit" type="submit">Buat Pesanan Simulasi</button>
            </form>

            <aside class="panel summary">
                <h2>Ringkasan top up</h2>
                <p class="help">Detail pilihan akan dikonfirmasi setelah formulir dikirim.</p>
                <div class="summary-game">
                    <div class="game-icon" aria-hidden="true">⚔</div>
                    <div><strong>Mobile Legends: Bang Bang</strong><span>Diamond · Global</span></div>
                </div>
                <div class="summary-line"><span>Item</span><strong>Diamond</strong></div>
                <div class="summary-line"><span>Nominal</span><strong>Pilih paket</strong></div>
                <div class="summary-line"><span>Pembayaran</span><strong>Pilih metode</strong></div>
                <div class="safe-note"><span aria-hidden="true">✓</span><span>Contoh project edukasi. Jangan masukkan informasi rahasia atau data pembayaran asli.</span></div>
            </aside>
        </div>
    </main>

    <footer class="footer"><div class="shell">© {{ date('Y') }} WRB.Store · Project UAS Controller &amp; View Laravel</div></footer>
</body>
</html>
