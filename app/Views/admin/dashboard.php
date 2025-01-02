<?= $this->extend('admin/layout/master') ?>

<?= $this->section('content') ?>
<!-- Tutorial Modal -->
<div class="modal fade" id="tutorialModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary text-white">
        <h5 class="modal-title">Selamat Datang di Dashboard Admin</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="steps">
          <div class="step mb-4">
            <h6 class="fw-bold"><i class="bi bi-1-circle-fill text-primary me-2"></i>Memulai</h6>
            <p class="ms-4">Pertama, Tambahin kategori klik di navbar atau di menu dashboard.</p>
          </div>
          <div class="step mb-4">
            <h6 class="fw-bold"><i class="bi bi-2-circle-fill text-primary me-2"></i>Tambah Produk</h6>
            <p class="ms-4">Buka bagian "Products" untuk menambahkan produk baru beserta kategori, detail, dan variannya.</p>
          </div>
          <div class="step mb-4">
            <h6 class="fw-bold"><i class="bi bi-3-circle-fill text-primary me-2"></i>Kelola Varian</h6>
            <p class="ms-4">Untuk setiap produk, bisa menambahkan beberapa varian dengan ukuran, harga, dan stok yang berbeda.</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="dontShowAgain">
          <label class="form-check-label" for="dontShowAgain">Jangan tampilkan lagi</label>
        </div>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti!</button>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="container-fluid">
  <!-- Welcome Card -->
  <div class="card mb-4 border-0 bg-gradient-primary text-white">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h4 class="mb-1">Selamat datang kembali, <?= session()->get('adminName') ?>!</h4>
          <p class="mb-0 opacity-75">Berikut adalah ringkasan toko Anda hari ini.</p>
        </div>
        <button class="btn btn-light btn-sm" onclick="showTutorial()">
          <i class="bi bi-question-circle me-1"></i> Tampilkan Tutorial
        </button>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="row g-4 mb-4">
    <!-- Categories Card -->
    <div class="col-md-6">
      <a href="<?= base_url('admin/categories') ?>" class="text-decoration-none">
        <div class="card h-100 border-0 shadow-sm hover-shadow">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="text-muted mb-1">Total Kategori</div>
                <h2 class="mb-0 text-primary"><?= $totalCategories ?></h2>
              </div>
              <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                <i class="bi bi-grid text-primary fs-3"></i>
              </div>
            </div>
            <div class="mt-3 text-primary">
              <span>Kelola kategori</span>
              <i class="bi bi-arrow-right ms-1"></i>
            </div>
          </div>
        </div>
      </a>
    </div>

    <!-- Products Card -->
    <div class="col-md-6">
      <a href="<?= base_url('admin/products') ?>" class="text-decoration-none">
        <div class="card h-100 border-0 shadow-sm hover-shadow">
          <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="text-muted mb-1">Total Produk</div>
                <h2 class="mb-0 text-primary"><?= $totalProducts ?></h2>
              </div>
              <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                <i class="bi bi-box text-primary fs-3"></i>
              </div>
            </div>
            <div class="mt-3 text-primary">
              <span>Kelola produk</span>
              <i class="bi bi-arrow-right ms-1"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>

  <!-- Quick Actions -->
  <!-- Quick Actions -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-white border-0">
      <h5 class="mb-0">Aksi Cepat</h5>
    </div>
    <div class="card-body">
      <div class="row g-3">
        <div class="col-md-6">
          <a href="<?= base_url('admin/categories') ?>" class="btn btn-primary w-100">
            <i class="bi bi-plus-circle me-2"></i>Tambah Kategori Baru
          </a>
        </div>
        <div class="col-md-6">
          <a href="<?= base_url('admin/products') ?>" class="btn btn-primary w-100">
            <i class="bi bi-plus-circle me-2"></i>Tambah Produk Baru
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    transition: all .3s ease;
  }

  .bg-gradient-primary {
    background: linear-gradient(45deg, #2196F3, #1976D2);
  }
</style>

<script>
  function showTutorial() {
    const modal = new bootstrap.Modal(document.getElementById('tutorialModal'));
    modal.show();
  }

  document.addEventListener('DOMContentLoaded', function() {
    if (!localStorage.getItem('tutorialShown')) {
      showTutorial();
    }
  });

  document.getElementById('dontShowAgain').addEventListener('change', function(e) {
    if (e.target.checked) {
      localStorage.setItem('tutorialShown', 'true');
    } else {
      localStorage.removeItem('tutorialShown');
    }
  });
</script>
<?= $this->endSection() ?>