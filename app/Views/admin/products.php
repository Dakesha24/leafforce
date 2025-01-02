<?= $this->extend('admin/layout/master') ?>

<?= $this->section('content') ?>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Products</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
      <i class="bi bi-plus"></i> Add Product
    </button>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Description</th>
            <th>Variants</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product): ?>
            <tr>
              <td><img src="<?= base_url('uploads/products/' . $product['image_m']) ?>" height="50" class="rounded"></td>
              <td><?= $product['name'] ?></td>
              <td><?= $product['category_name'] ?></td>
              <td><?= $product['description'] ?></td>
              <td>
                <!-- Tampilkan variants -->
                <?php if (isset($productVariants[$product['id']])): ?>
                  <div class="small">
                    <?php foreach ($productVariants[$product['id']] as $variant): ?>
                      <div class="mb-1">
                        Size: <?= $variant['size'] ?> |
                        Price: <?= number_format($variant['price']) ?> |
                        Stock: <?= $variant['stock'] ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </td>
              <td class="text-end">
                <div class="btn-group btn-group-sm">
                  <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editProduct<?= $product['id'] ?>">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <button class="btn btn-outline-danger" onclick="confirmDeleteProduct(<?= $product['id'] ?>, '<?= esc($product['name']) ?>')">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProduct">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="<?= base_url('admin/products/add') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Add Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Category</label>
              <select name="category_id" class="form-select" required>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Thumbnail Image</label>
            <input type="file" name="image_m" class="form-control" required accept="image/*" onchange="previewImage(this, 'preview')">
            <img id="preview" class="mt-2" style="max-height: 200px">
          </div>
          <hr>
          <h6>Variants</h6>
          <div id="variants">
            <div class="row mb-3">
              <div class="col-md-3">
                <label class="form-label">Size</label>
                <select name="size[]" class="form-select">
                  <option value="">Select Size</option>
                  <option value="S">S</option>
                  <option value="M">M</option>
                  <option value="L">L</option>
                  <option value="XL">XL</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Price</label>
                <input type="number" name="price[]" class="form-control">
              </div>
              <div class="col-md-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock[]" class="form-control">
              </div>
              <div class="col-md-3">
                <label class="form-label">Image</label>
                <input type="file" name="variant_image[]" class="form-control" accept="image/*">
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-outline-primary btn-sm" onclick="addVariant()">
            <i class="bi bi-plus"></i> Add Variant
          </button>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Product Modal -->
<?php foreach ($products as $product): ?>
  <div class="modal fade" id="editProduct<?= $product['id'] ?>">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="editForm<?= $product['id'] ?>" action="<?= base_url('admin/products/edit/' . $product['id']) ?>"
          method="post" enctype="multipart/form-data"
          onsubmit="return confirmUpdate(this)">
          <div class="modal-header">
            <h5 class="modal-title">Edit Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                  <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                      <?= $category['name'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required value="<?= $product['name'] ?>">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="3"><?= $product['description'] ?></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Thumbnail Image</label>
              <input type="file" name="image_m" class="form-control" accept="image/*" onchange="previewImage(this, 'preview<?= $product['id'] ?>')">
              <img src="<?= base_url('uploads/products/' . $product['image_m']) ?>" id="preview<?= $product['id'] ?>" class="mt-2" style="max-height: 200px">
            </div>
            <hr>
            <h6>Variants</h6>
            <div id="variants<?= $product['id'] ?>" class="variants-container">
              <?php if (isset($productVariants[$product['id']])): ?>
                <?php foreach ($productVariants[$product['id']] as $variant): ?>
                  <div class="row mb-3 variant-row">
                    <input type="hidden" name="variant_id[]" value="<?= $variant['id'] ?>">
                    <div class="col-md-3">
                      <label class="form-label">Size</label>
                      <select name="size[]" class="form-select" required>
                        <option value="S" <?= $variant['size'] === 'S' ? 'selected' : '' ?>>S</option>
                        <option value="M" <?= $variant['size'] === 'M' ? 'selected' : '' ?>>M</option>
                        <option value="L" <?= $variant['size'] === 'L' ? 'selected' : '' ?>>L</option>
                        <option value="XL" <?= $variant['size'] === 'XL' ? 'selected' : '' ?>>XL</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Price</label>
                      <input type="number" name="price[]" class="form-control" value="<?= $variant['price'] ?>" required>
                    </div>
                    <div class="col-md-2">
                      <label class="form-label">Stock</label>
                      <input type="number" name="stock[]" class="form-control" value="<?= $variant['stock'] ?>" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Image</label>
                      <input type="file" name="variant_image[]" class="form-control" accept="image/*">
                      <?php if ($variant['image']): ?>
                        <div class="mt-1">
                          <img src="<?= base_url('uploads/variants/' . $variant['image']) ?>" class="img-thumbnail" style="height: 40px">
                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                      <button type="button" class="btn btn-outline-danger btn-sm mb-3" onclick="removeVariant(this)">
                        <i class="bi bi-trash"></i>
                      </button>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addVariantToEdit(<?= $product['id'] ?>)">
              <i class="bi bi-plus"></i> Add Variant
            </button>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
              onclick="confirmCancel('editProduct<?= $product['id'] ?>')">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>

<script>
  document.getElementById('editProduct<?= $product['id'] ?>').setAttribute('data-original',
    JSON.stringify({
      category_id: '<?= $product['category_id'] ?>',
      name: '<?= htmlspecialchars($product['name'], ENT_QUOTES) ?>',
      description: '<?= htmlspecialchars($product['description'], ENT_QUOTES) ?>',
      variants: document.getElementById('variants<?= $product['id'] ?>').innerHTML
    })
  );
</script>

<!-- Delete Product Confirmation Modal -->
<div class="modal fade" id="deleteProductModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete product "<span id="productNameToDelete"></span>"?</p>
        <p class="text-danger mb-0">This will also delete all variants associated with this product.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form id="deleteProductForm" action="" method="post">
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById(previewId).src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function addVariant() {
    const template = `
        <div class="row mb-3">
            <div class="col-md-3">
                <label class="form-label">Size</label>
                <select name="size[]" class="form-select">
                    <option value="">Select Size</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Price</label>
                <input type="number" name="price[]" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Stock</label>
                <input type="number" name="stock[]" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Image</label>
                <input type="file" name="variant_image[]" class="form-control" accept="image/*">
            </div>
        </div>
    `;
    document.getElementById('variants').insertAdjacentHTML('beforeend', template);
  }

  function loadProductVariants(productId) {
    const container = document.getElementById(`variants${productId}`);

    // Clear existing variants first
    container.innerHTML = '';

    // Tampilkan loading indicator
    container.innerHTML = '<div class="text-center py-3"><div class="spinner-border text-primary"></div></div>';

    // Tambahkan timestamp untuk mencegah cache
    fetch(`<?= base_url('admin/products/get-variants/') ?>/${productId}?t=${Date.now()}`)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(variants => {
        console.log('Received variants:', variants); // Debug log

        container.innerHTML = ''; // Hapus loading indicator

        if (!Array.isArray(variants) || variants.length === 0) {
          // Jika tidak ada variants, tambahkan form kosong
          addVariantToEdit(productId);
          return;
        }

        // Render existing variants
        variants.forEach(variant => {
          const template = `
                    <div class="row mb-3 variant-row">
                        <input type="hidden" name="variant_id[]" value="${variant.id}">
                        <div class="col-md-3">
                            <label class="form-label">Size</label>
                            <select name="size[]" class="form-select" required>
                                <option value="S" ${variant.size === 'S' ? 'selected' : ''}>S</option>
                                <option value="M" ${variant.size === 'M' ? 'selected' : ''}>M</option>
                                <option value="L" ${variant.size === 'L' ? 'selected' : ''}>L</option>
                                <option value="XL" ${variant.size === 'XL' ? 'selected' : ''}>XL</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Price</label>
                            <input type="number" name="price[]" class="form-control" value="${variant.price}" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock[]" class="form-control" value="${variant.stock}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="variant_image[]" class="form-control" accept="image/*">
                            ${variant.image ? 
                                `<div class="mt-1">
                                    <img src="<?= base_url('uploads/variants/') ?>/${variant.image}" class="img-thumbnail" style="height: 40px">
                                </div>` : 
                                ''}
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-outline-danger btn-sm d-block" onclick="removeVariant(this)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
          container.insertAdjacentHTML('beforeend', template);
        });
      })
      .catch(error => {
        console.error('Error:', error);
        container.innerHTML = `
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Error loading variants. Please try again.
                    <div class="small mt-1">${error.message}</div>
                </div>
            `;
      });
  }


  function addVariantToEdit(productId) {
    const container = document.getElementById(`variants${productId}`);
    const template = `
        <div class="row mb-3 variant-row">
            <input type="hidden" name="variant_id[]" value="">
            <div class="col-md-3">
                <label class="form-label">Size</label>
                <select name="size[]" class="form-select" required>
                    <option value="">Select Size</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Price</label>
                <input type="number" name="price[]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Stock</label>
                <input type="number" name="stock[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Image</label>
                <input type="file" name="variant_image[]" class="form-control" accept="image/*">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger btn-sm mb-3" onclick="removeVariant(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
  }

  function removeVariant(button) {
    const variantRow = button.closest('.variant-row');
    const variantId = variantRow.querySelector('[name="variant_id[]"]').value;

    if (variantId) {
      // Jika ini existing variant, tambahkan ke deleted_variants
      const form = button.closest('form');
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'deleted_variants[]';
      input.value = variantId;
      form.appendChild(input);
    }

    variantRow.remove();
  }

  function confirmDeleteProduct(productId, productName) {
    document.getElementById('productNameToDelete').textContent = productName;
    document.getElementById('deleteProductForm').action = `<?= base_url('admin/products/delete/') ?>/${productId}`;
    new bootstrap.Modal(document.getElementById('deleteProductModal')).show();
  }

  // Tambahkan fungsi konfirmasi
  function confirmCancel(modalId) {
    const confirmModal = `
        <div class="modal fade" id="cancelConfirm" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Cancel</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to cancel? Any changes will be lost.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, continue editing</button>
                        <button type="button" class="btn btn-danger" onclick="closeEditModal('${modalId}')">Yes, cancel</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Hapus modal konfirmasi lama jika ada
    const oldModal = document.getElementById('cancelConfirm');
    if (oldModal) oldModal.remove();

    // Tambahkan modal baru
    document.body.insertAdjacentHTML('beforeend', confirmModal);

    // Tampilkan modal konfirmasi
    new bootstrap.Modal(document.getElementById('cancelConfirm')).show();
  }

  function confirmUpdate(form) {
    const confirmModal = `
        <div class="modal fade" id="updateConfirm" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to update this product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, review changes</button>
                        <button type="button" class="btn btn-primary" onclick="submitForm('${form.id}')">Yes, update</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Hapus modal konfirmasi lama jika ada
    const oldModal = document.getElementById('updateConfirm');
    if (oldModal) oldModal.remove();

    // Tambahkan modal baru
    document.body.insertAdjacentHTML('beforeend', confirmModal);

    // Tampilkan modal konfirmasi
    new bootstrap.Modal(document.getElementById('updateConfirm')).show();
    return false;
  }

  function closeEditModal(modalId) {
    // Tutup modal konfirmasi
    bootstrap.Modal.getInstance(document.getElementById('cancelConfirm')).hide();

    // Tunggu sebentar lalu tutup modal edit dan reset form
    setTimeout(() => {
      const editModal = document.getElementById(modalId);
      bootstrap.Modal.getInstance(editModal).hide();
      editModal.querySelector('form').reset();
      // Kembalikan semua data ke nilai awal
      resetModalData(modalId);
    }, 200);
  }

  function submitForm(formId) {
    document.getElementById(formId).submit();
  }

  // Fungsi untuk mereset data modal ke nilai awal
  function resetModalData(modalId) {
    const modal = document.getElementById(modalId);
    const originalData = JSON.parse(modal.getAttribute('data-original'));

    // Reset form fields ke nilai original
    Object.keys(originalData).forEach(key => {
      const element = modal.querySelector(`[name="${key}"]`);
      if (element) element.value = originalData[key];
    });

    // Reset variants container
    const variantsContainer = modal.querySelector('.variants-container');
    if (variantsContainer) {
      variantsContainer.innerHTML = originalData.variants || '';
    }
  }
</script>
<?= $this->endSection() ?>