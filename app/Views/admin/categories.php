<?= $this->extend('admin/layout/master') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0">Categories</h5>
        <button class="btn btn-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#addCategory">
            <i class="bi bi-plus-lg"></i> Add Category
        </button>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td class="align-middle"><?= esc($category['name']) ?></td>
                        <td class="align-middle"><?= esc($category['description']) ?></td>
                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editCategory<?= $category['id'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-outline-danger" 
                                        onclick="confirmDelete(<?= $category['id'] ?>, '<?= esc($category['name']) ?>')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editCategory<?= $category['id'] ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="<?= base_url('admin/categories/edit/'.$category['id']) ?>" method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control" 
                                                           value="<?= esc($category['name']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea name="description" class="form-control" 
                                                              rows="3"><?= esc($category['description']) ?></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" 
                                                        data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategory">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?= base_url('admin/categories/add') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmation" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete category "<span id="categoryName"></span>"?</p>
                <div id="relatedProductsWarning" class="alert alert-warning d-none">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    This category has related products. Please delete the following products first:
                    <ul id="relatedProductsList" class="mt-2 mb-0"></ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" action="" method="post" class="d-inline">
                    <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(categoryId, categoryName) {
    // Set category name in modal
    document.getElementById('categoryName').textContent = categoryName;
    
    // Check for related products via AJAX
    fetch(`<?= base_url('admin/categories/check-relations/') ?>/${categoryId}`)
        .then(response => response.json())
        .then(data => {
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmation'));
            const warningDiv = document.getElementById('relatedProductsWarning');
            const productsList = document.getElementById('relatedProductsList');
            const deleteForm = document.getElementById('deleteForm');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            
            // Reset previous state
            warningDiv.classList.add('d-none');
            productsList.innerHTML = '';
            confirmDeleteBtn.disabled = false;
            
            if (data.hasRelations) {
                // Show warning and list related products
                warningDiv.classList.remove('d-none');
                data.products.forEach(product => {
                    const li = document.createElement('li');
                    li.textContent = product.name;
                    productsList.appendChild(li);
                });
                confirmDeleteBtn.disabled = true;
            }
            
            // Set delete form action
            deleteForm.action = `<?= base_url('admin/categories/delete/') ?>/${categoryId}`;
            
            // Show modal
            deleteModal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while checking category relations');
        });
}
</script>

<?= $this->endSection() ?>