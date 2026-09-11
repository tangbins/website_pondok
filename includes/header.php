<?php
// $page_title dan $active dikirim dari halaman pemanggil sebelum include ini
$page_title = $page_title ?? 'Pondok Pesantren Amaliah';
$active = $active ?? '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($page_title) ?> - Pondok Pesantren Amaliah</title>

  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Plus+Jakarta+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap"
    rel="stylesheet">

  <!-- Tailwind CSS (CDN, cocok buat development/tugas kuliah. Kalau udah mau ke hosting production,
     enaknya compile pakai Tailwind CLI biar lebih ringan & cepat, bukan CDN) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            teal: '#006b7d',
            'teal-deep': '#013843',
            orange: '#ee7a00',
            cream: '#FBF8F3',
            'teal-tint': '#E3F0F1',
            ink: '#14262A',
            gold: '#B8901F',
          },
          fontFamily: {
            display: ['Fraunces', 'serif'],
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            mono: ['"IBM Plex Mono"', 'monospace'],
          },
        }
      }
    }
  </script>

  <!-- AOS - library animasi scroll, ringan dan tinggal pasang data-aos di HTML -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style type="text/tailwindcss">
    @layer base {
    html { scroll-behavior: smooth; }
    body { @apply font-sans text-ink bg-white; }
    img { @apply max-w-full block; }
  }

  @layer components {
    .container { @apply max-w-6xl mx-auto px-5; }

    /* ---------- Navbar ---------- */
    .navbar { @apply bg-teal-deep sticky top-0 z-50 shadow-md; }
    .navbar-inner { @apply flex items-center justify-between py-3.5 px-5 max-w-6xl mx-auto; }
    .navbar-brand { @apply text-white font-display font-semibold text-base transition-opacity hover:opacity-80; }
    .navbar-brand span { @apply block font-sans font-normal text-[10.5px] text-teal-tint/70 tracking-wide; }
    .navbar-menu { @apply hidden lg:flex items-center gap-6 list-none; }
    .navbar-menu a { @apply text-teal-tint/90 text-sm font-medium transition-colors duration-200 hover:text-orange; }
    .navbar-menu a.active { @apply text-orange; }
    .navbar-cta { @apply hidden lg:inline-block bg-orange text-white py-2.5 px-4 rounded-md text-sm font-semibold transition-all duration-200 hover:bg-orange/90 hover:shadow-lg hover:-translate-y-0.5; }
    .navbar-toggle { @apply lg:hidden bg-transparent border-none w-6 h-[18px] flex flex-col justify-between cursor-pointer p-0; }
    .navbar-toggle div { @apply h-0.5 bg-white rounded-full transition-transform duration-200; }
    .navbar-mobile { @apply hidden flex-col bg-teal-deep px-5 pb-4; }
    .navbar-mobile.open { @apply flex; }
    .navbar-mobile a { @apply text-teal-tint/90 text-sm py-2.5 border-b border-white/10 transition-colors duration-200 hover:text-orange hover:pl-1; }

    /* ---------- Hero ---------- */
    .hero { @apply bg-teal pt-11 pb-0; }
    .hero-inner { @apply max-w-6xl mx-auto px-5; }
    .hero-eyebrow { @apply text-teal-tint/80 text-xs tracking-widest uppercase font-mono mb-2.5; }
    .hero h1 { @apply font-display font-semibold text-3xl md:text-5xl leading-tight text-white mb-3.5 max-w-xl; }
    .hero p { @apply text-sm leading-relaxed text-teal-tint/90 mb-6 max-w-md; }
    .hero-ctas { @apply flex gap-3 flex-wrap; }

    .btn-primary { @apply bg-orange text-white border-none py-3 px-5 rounded-md font-semibold text-sm cursor-pointer transition-all duration-200 hover:bg-orange/90 hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0; }
    .btn-ghost { @apply bg-transparent text-white border border-white/40 py-3 px-5 rounded-md font-medium text-sm cursor-pointer transition-all duration-200 hover:bg-white/10 hover:border-white/70; }
    .btn-white { @apply bg-white text-orange border-none py-3 px-6 rounded-md font-semibold text-sm cursor-pointer transition-all duration-200 hover:shadow-xl hover:-translate-y-0.5; }

    .arch-wrap { @apply w-full leading-none mt-7; }

    /* ---------- Stats ---------- */
    .stats { @apply flex bg-teal-deep py-5 px-3 flex-wrap; }
    .stat { @apply flex-1 min-w-[80px] text-center text-white border-r border-white/15 last:border-r-0; }
    .stat .num { @apply font-display font-semibold text-xl text-orange; }
    .stat .label { @apply text-[10.5px] text-teal-tint/80 mt-0.5; }

    /* ---------- Sections ---------- */
    .section { @apply py-10; }
    .section-tint { @apply bg-teal-tint; }
    .eyebrow { @apply font-mono text-xs tracking-wide uppercase text-teal mb-2 inline-block; }
    .section h2 { @apply font-display font-semibold text-2xl text-teal-deep mb-3; }
    .section p.desc { @apply text-sm leading-relaxed text-slate-600 mb-5 max-w-2xl; }

    /* ---------- Jenjang cards ---------- */
    .jenjang-grid { @apply grid grid-cols-1 md:grid-cols-2 gap-4; }
    .jenjang-card { @apply rounded-xl p-5 border border-gray-200 bg-white transition-all duration-300 hover:shadow-xl hover:-translate-y-1; }
    .jenjang-card.smp { @apply border-t-[3px] border-t-gold; }
    .jenjang-card.sma { @apply border-t-[3px] border-t-teal; }
    .jenjang-top { @apply flex items-center gap-3.5 mb-3; }
    .jenjang-top img { @apply w-12 h-12 object-contain transition-transform duration-300; }
    .jenjang-card:hover .jenjang-top img { @apply scale-110; }
    .jenjang-top .jt-name { @apply font-display font-semibold text-base; }
    .jenjang-top .jt-tag { @apply text-[11px] text-gray-500 font-mono; }
    .jenjang-card p { @apply text-[13.5px] text-gray-600 leading-relaxed mb-3.5; }
    .link-arrow { @apply text-[13px] font-semibold inline-block transition-all duration-200; }
    .jenjang-card.smp .link-arrow { @apply text-gold; }
    .jenjang-card.sma .link-arrow { @apply text-teal; }
    .link-arrow:hover { @apply pl-1; }

    /* ---------- Program list ---------- */
    .program-list { @apply grid grid-cols-1 md:grid-cols-2 gap-x-8; }
    .program-item { @apply flex gap-3.5 items-start py-3.5 border-b border-gray-200 transition-colors duration-200 hover:bg-teal-tint/40 rounded-md px-2 -mx-2; }
    .p-icon { @apply w-9 h-9 rounded-lg bg-teal-tint flex-shrink-0 flex items-center justify-center text-teal font-mono text-xs font-semibold transition-transform duration-300; }
    .program-item:hover .p-icon { @apply scale-110 bg-teal text-white; }
    .p-text .p-title { @apply text-sm font-semibold mb-0.5; }
    .p-text .p-sub { @apply text-xs text-gray-500; }

    /* ---------- Fasilitas grid ---------- */
    .fasilitas-grid { @apply grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5; }
    .fasilitas-card { @apply border border-gray-200 rounded-xl overflow-hidden bg-white transition-all duration-300 hover:shadow-xl hover:-translate-y-1; }
    .fasilitas-thumb { @apply h-36 bg-gradient-to-br from-teal to-teal-deep transition-transform duration-500; }
    .fasilitas-card:hover .fasilitas-thumb { @apply scale-105; }
    .fasilitas-body { @apply p-3.5; }
    .fasilitas-body .f-title { @apply font-semibold text-sm mb-1; }
    .fasilitas-body .f-desc { @apply text-xs text-gray-500 leading-relaxed; }
    .fasilitas-kategori-label { @apply inline-block bg-teal-tint text-teal-deep text-[11px] font-semibold py-1 px-2.5 rounded-full mb-4; }

    /* ---------- Pengajar cards ---------- */
    .pengajar-grid { @apply grid grid-cols-2 md:grid-cols-4 gap-3.5; }
    .pengajar-card { @apply text-center transition-transform duration-300 hover:-translate-y-1; }
    .pengajar-avatar { @apply w-full aspect-square rounded-xl bg-teal-tint flex items-center justify-center text-teal font-display font-semibold text-xl mb-2.5 transition-colors duration-300; }
    .pengajar-card:hover .pengajar-avatar { @apply bg-teal text-white; }
    .pengajar-nama { @apply text-[13.5px] font-semibold; }
    .pengajar-jabatan { @apply text-[11.5px] text-gray-500; }

    /* ---------- Berita ---------- */
    .berita-grid { @apply grid grid-cols-1 md:grid-cols-3 gap-3.5; }
    .berita-card { @apply bg-white border border-gray-200 rounded-lg overflow-hidden block transition-all duration-300 hover:shadow-xl hover:-translate-y-1; }
    .berita-thumb { @apply h-32 bg-gradient-to-br from-teal to-teal-deep transition-transform duration-500; }
    .berita-card:hover .berita-thumb { @apply scale-105; }
    .berita-body { @apply p-3.5; }
    .berita-date { @apply font-mono text-[10.5px] text-orange mb-1.5; }
    .berita-title { @apply text-[13.5px] font-semibold leading-snug; }
    .berita-ringkasan { @apply text-xs text-gray-500 mt-1.5 leading-relaxed; }

    /* ---------- Tabel biaya PSB ---------- */
    .tabel-biaya { @apply w-full border-collapse mb-6 text-[13.5px]; }
    .tabel-biaya th, .tabel-biaya td { @apply py-2.5 px-3.5 text-left border-b border-gray-200; }
    .tabel-biaya th { @apply bg-teal-tint text-teal-deep font-semibold text-xs; }
    .tabel-biaya td.jumlah { @apply text-right font-semibold text-teal-deep; }
    .tabel-biaya tr { @apply transition-colors duration-150 hover:bg-teal-tint/30; }

    /* ---------- Alur / steps PSB ---------- */
    .alur-list { @apply grid grid-cols-1 md:grid-cols-5 gap-0 md:gap-3.5; }
    .alur-item { @apply flex gap-3 py-3.5 border-b border-gray-200 md:flex-col md:gap-2 md:border-b-0 md:border-t-[3px] md:border-t-orange md:pt-3.5 md:pb-0 transition-transform duration-300 hover:-translate-y-1; }
    .alur-num { @apply font-display font-semibold text-orange text-lg flex-shrink-0; }

    /* ---------- Form ---------- */
    .form-box { @apply bg-white border border-gray-200 rounded-xl p-6 max-w-xl; }
    .form-group { @apply mb-4; }
    .form-group label { @apply block text-[13px] font-semibold mb-1.5 text-teal-deep; }
    .form-group input, .form-group select, .form-group textarea {
      @apply w-full py-2.5 px-3 border border-gray-300 rounded-md text-[13.5px] bg-white transition-all duration-200;
    }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
      @apply outline-none border-teal ring-2 ring-teal/20;
    }
    .alert { @apply py-3 px-3.5 rounded-lg text-[13.5px] mb-4; }
    .alert-success { @apply bg-emerald-50 text-emerald-700 border border-emerald-200; }
    .alert-error { @apply bg-red-50 text-red-700 border border-red-200; }

    /* ---------- CTA band ---------- */
    .cta-band { @apply bg-orange py-9 text-center; }
    .cta-band h3 { @apply font-display font-semibold text-xl text-white mb-2; }
    .cta-band p { @apply text-[13.5px] text-[#ffe3c2] mb-4; }

    /* ---------- Footer ---------- */
    .footer { @apply bg-teal-deep text-teal-tint py-9 pb-5; }
    .footer-grid { @apply grid grid-cols-1 md:grid-cols-[1.3fr_1fr_1fr] gap-6; }
    .footer-brand { @apply font-display text-base text-white mb-2; }
    .footer-desc { @apply text-xs text-teal-tint/70 leading-relaxed; }
    .footer-heading { @apply text-xs font-semibold text-white mb-3 uppercase tracking-wide; }
    .footer-row { @apply flex gap-2.5 items-start mb-2.5 text-[13px]; }
    .footer-row .fi { @apply w-[18px] text-orange font-mono text-[11px] flex-shrink-0 pt-0.5; }
    .footer-map { @apply bg-[#0a4650] h-full min-h-[120px] rounded-lg flex items-center justify-center text-[11.5px] text-teal-tint/70 font-mono border border-dashed border-white/20; }
    .footer-bottom { @apply border-t border-white/10 mt-6 pt-4 text-[11px] text-teal-tint/60 text-center; }
  }
</style>
</head>

<body>

  <nav class="navbar">
    <div class="navbar-inner">
      <a href="<?= BASE_URL ?>/index.php" class="navbar-brand">Pondok Pesantren Amaliah<span>Yayasan YPSPIA &middot;
          Ciawi, Bogor</span></a>
      <ul class="navbar-menu">
        <li><a href="<?= BASE_URL ?>/index.php" class="<?= $active == 'home' ? 'active' : '' ?>">Beranda</a></li>
        <li><a href="<?= BASE_URL ?>/pages/profil-yayasan.php" class="<?= $active == 'profil' ? 'active' : '' ?>">Profil</a>
        </li>
        <li><a href="<?= BASE_URL ?>/pages/jenjang-smp.php" class="<?= $active == 'smp' ? 'active' : '' ?>">SMP</a></li>
        <li><a href="<?= BASE_URL ?>/pages/jenjang-sma.php" class="<?= $active == 'sma' ? 'active' : '' ?>">SMA</a></li>
        <li><a href="<?= BASE_URL ?>/pages/fasilitas.php" class="<?= $active == 'fasilitas' ? 'active' : '' ?>">Fasilitas</a>
        </li>
        <li><a href="<?= BASE_URL ?>/pages/struktur-pengajar.php"
            class="<?= $active == 'pengajar' ? 'active' : '' ?>">Pengajar</a></li>
        <li><a href="<?= BASE_URL ?>/pages/berita.php" class="<?= $active == 'berita' ? 'active' : '' ?>">Berita</a></li>
        <li><a href="<?= BASE_URL ?>/pages/kontak.php" class="<?= $active == 'kontak' ? 'active' : '' ?>">Kontak</a></li>
      </ul>
      <a href="<?= BASE_URL ?>/pages/psb.php" class="navbar-cta">Daftar PSB</a>
      <button class="navbar-toggle" onclick="document.getElementById('navMobile').classList.toggle('open')"
        aria-label="Buka menu">
        <div></div>
        <div></div>
        <div></div>
      </button>
    </div>
    <div class="navbar-mobile" id="navMobile">
      <a href="<?= BASE_URL ?>/index.php">Beranda</a>
      <a href="<?= BASE_URL ?>/pages/profil-yayasan.php">Profil Yayasan</a>
      <a href="<?= BASE_URL ?>/pages/jenjang-smp.php">Jenjang SMP</a>
      <a href="<?= BASE_URL ?>/pages/jenjang-sma.php">Jenjang SMA</a>
      <a href="<?= BASE_URL ?>/pages/fasilitas.php">Fasilitas</a>
      <a href="<?= BASE_URL ?>/pages/struktur-pengajar.php">Struktur &amp; Pengajar</a>
      <a href="<?= BASE_URL ?>/pages/berita.php">Berita &amp; Kegiatan</a>
      <a href="<?= BASE_URL ?>/pages/galeri.php">Galeri</a>
      <a href="<?= BASE_URL ?>/pages/psb.php">PSB</a>
      <a href="<?= BASE_URL ?>/pages/kontak.php">Kontak</a>
    </div>
  </nav>