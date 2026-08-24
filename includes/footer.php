<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">Pondok Pesantren Amaliah</div>
        <p class="footer-desc"><?= e($site['yayasan']) ?><br>Ciawi, Bogor, Indonesia.</p>
      </div>
      <div>
        <div class="footer-heading">Kontak</div>
        <div class="footer-row"><span class="fi">IG</span><?= e($site['ig_putra']) ?> &middot; <?= e($site['ig_putri']) ?></div>
        <div class="footer-row"><span class="fi">@</span><?= e($site['email']) ?></div>
        <div class="footer-row"><span class="fi">Tel</span><?= e($site['telepon']) ?></div>
        <div class="footer-row"><span class="fi">Loc</span><?= e($site['alamat']) ?></div>
      </div>
      <div>
        <div class="footer-heading">Lokasi</div>
        <div class="footer-map">peta lokasi (embed google maps)</div>
      </div>
    </div>
    <div class="footer-bottom">&copy; <?= date('Y') ?> Yayasan YPSPIA. Seluruh hak cipta dilindungi.</div>
  </div>
</footer>

<!-- AOS JS - dipanggil sekali di sini, otomatis jalan di semua halaman yang include footer ini -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 700,
    easing: 'ease-out-cubic',
    once: true,
    offset: 40,
  });
</script>
</body>
</html>
