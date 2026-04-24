    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function getCsrfData() { return { '<?= csrf_token() ?>': '<?= csrf_hash() ?>' }; }
        <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({ icon: 'success', title: 'Berhasil', text: '<?= session()->getFlashdata('success') ?>', toast: true, position: 'top-end', showConfirmButton: false, timer: 3000 });
        <?php endif; ?>
    </script>
</body>
</html>
