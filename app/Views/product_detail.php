  <?= $this->extend('layout/master') ?>

  <?= $this->section('content') ?>

  <section class="py-5">
    <div class="container">
      <!-- Breadcrumb dengan garis -->
      <nav aria-label="breadcrumb" class="border-bottom pb-3 mb-4">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none">Home</a></li>
          <li class="breadcrumb-item text-muted"><?= $category['name'] ?></li>
          <li class="breadcrumb-item active"><?= $product['name'] ?></li>
        </ol>
      </nav>

      <div class="row">
        <!-- Product Images dengan border halus -->
        <div class="col-md-6 mb-4">
          <div class="product-image-container border">
            <?php
            // Set default values
            $currentImage = base_url('uploads/products/' . $product['image_m']);
            $currentPrice = 0;
            $currentStock = 0;
            $currentSize = '';

            // If variant is selected, update values
            if ($variantId) {
              foreach ($variants as $var) {
                if ($var['id'] == $variantId) {
                  if ($var['image']) {
                    $currentImage = base_url('uploads/variants/' . $var['image']);
                  }
                  $currentPrice = $var['price'];
                  $currentStock = $var['stock'];
                  $currentSize = $var['size'];
                  break;
                }
              }
            }
            ?>
            <img src="<?= $currentImage ?>" class="img-fluid" alt="<?= $product['name'] ?>">
          </div>
        </div>

        <!-- Product Info dengan card style -->
        <div class="col-md-6">
          <div class="card border-0 bg-transparent">
            <div class="card-body p-0">
              <div class="category-badge mb-2">
                <span class="badge bg-light text-dark border"><?= $category['name'] ?></span>
              </div>

              <h1 class="product-title mb-4"><?= $product['name'] ?></h1>

              <div class="info-section mb-4 border-bottom pb-4">
                <h5 class="section-title">Tentang Kategori</h5>
                <p class="text-muted"><?= $category['description'] ?></p>
              </div>

              <div class="info-section mb-4 border-bottom pb-4">
                <h5 class="section-title">Deskripsi Produk</h5>
                <p class="text-muted"><?= $product['description'] ?></p>
              </div>

              <form method="get" class="mb-4">
                <div class="size-selection">
                  <h5 class="section-title mb-3">Pilih Ukuran</h5>
                  <div class="variant-buttons">
                    <?php foreach ($variants as $variant): ?>
                      <button type="submit"
                        name="variant_id"
                        value="<?= $variant['id'] ?>"
                        class="btn <?= ($variantId == $variant['id']) ? 'btn-dark' : 'btn-outline-dark' ?> rounded-pill me-2 mb-2">
                        <?= $variant['size'] ?>
                      </button>
                    <?php endforeach; ?>
                  </div>
                </div>
              </form>

              <?php if ($variantId): ?>
                <div class="selected-variant-info border-top pt-4 mt-4">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="price mb-0">Rp <?= number_format($currentPrice, 0, ',', '.') ?></h4>
                    <span class="stock text-muted">Stok: <?= $currentStock ?></span>
                  </div>

                  <?php
                  $message = "Halo, saya ingin memesan:\n\n";
                  $message .= "Produk: {$product['name']}\n";
                  $message .= "Ukuran: {$currentSize}\n";
                  $message .= "Harga: Rp " . number_format($currentPrice, 0, ',', '.');
                  $message .= "\n\nMohon dibantu prosesnya, terima kasih.";

                  $waNumber = "6281234567890";
                  $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($message);
                  ?>

                  <div class="text-center">
                    <a href="<?= $waLink ?>" class="btn-wa" target="_blank">
                      <i class="bi bi-whatsapp me-2"></i>Order via WhatsApp
                    </a>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
    .product-image-container {
      background-color: #fff;
      padding: 2rem;
      border-radius: 8px;
      text-align: center;
    }

    .product-image-container img {
      max-height: 500px;
      width: auto;
      object-fit: contain;
    }

    .product-title {
      font-size: 2rem;
      font-weight: 600;
      color: #333;
    }

    .section-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 1rem;
    }

    .variant-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .variant-buttons .btn {
      min-width: 50px;
      font-size: 0.9rem;
    }

    .price {
      font-size: 1.5rem;
      font-weight: 600;
      color: #333;
    }

    .btn-wa {
      background: linear-gradient(45deg, #25D366, #128C7E);
      color: white;
      text-decoration: none;
      padding: 8px 20px;
      border-radius: 25px;
      transition: all 0.3s;
      display: inline-block;
    }

    .btn-wa:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(37, 211, 102, 0.2);
      color: white;
      text-decoration: none;
    }

    /* Mobile Responsiveness */
    @media (max-width: 768px) {
      .product-image-container {
        padding: 1rem;
      }

      .product-image-container img {
        max-height: 300px;
      }

      .product-title {
        font-size: 1.5rem;
      }

      .section-title {
        font-size: 1rem;
      }

      .price {
        font-size: 1.2rem;
      }
    }
  </style>

  <?= $this->endSection() ?>