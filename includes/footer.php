<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="footer-brand">Pondok Pesantren Amaliah</div>
        <p class="footer-desc"><?= e($site['yayasan']) ?><br>Ciawi, Bogor, Indonesia.</p>
      </div>
      <div>
        <div class="footer-heading">Kontak</div>
        <div class="footer-row"><span class="fi">IG</span><?= e($site['ig_putra']) ?> &middot;
          <?= e($site['ig_putri']) ?>
        </div>
        <div class="footer-row"><span class="fi">@</span><?= e($site['email']) ?></div>
        <div class="footer-row"><span class="fi">Tel</span><?= e($site['telepon']) ?></div>
        <div class="footer-row"><span class="fi">Loc</span><?= e($site['alamat']) ?></div>
      </div>
      <div>
        <div class="footer-heading">Lokasi</div>
        <div class="footer-map"><iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2731.1527849860972!2d106.85603181482077!3d-6.656156900998863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c9d461e03045%3A0x3acf15f99ba10142!2sPP.%20Tahfidz%20Binta%20Amaliyah%20Putri!5e0!3m2!1sid!2sid!4v1787582700597!5m2!1sid!2sid"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="strict-origin-when-cross-origin"></iframe></div>
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