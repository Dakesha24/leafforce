<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
  <div class="container">
    <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>">
      <i class="bi bi-leaf-fill"></i> LeafForce
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/dashboard') ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/products') ?>">
            <i class="bi bi-box-seam"></i> Products
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('admin/categories') ?>">
            <i class="bi bi-tags"></i> Categories
          </a>
        </li>
      </ul>
      <div class="ms-auto">
        <button class="btn btn-outline-light btn-sm" onclick="confirmLogout()">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </div>

      <script>
        function confirmLogout() {
          if (confirm('Are you sure you want to logout?')) {
            window.location.href = '<?= base_url('admin/logout') ?>';
          }
        }
      </script>
    </div>
  </div>
</nav>