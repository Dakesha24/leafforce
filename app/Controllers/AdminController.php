<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductVariantModel;

class AdminController extends BaseController
{
  protected $session;
  protected $adminModel;
  protected $productModel;
  protected $categoryModel;
  protected $variantModel;

  public function __construct()
  {
    $this->session = session();
    $this->adminModel = new \App\Models\AdminModel();
    $this->productModel = new ProductModel();
    $this->categoryModel = new CategoryModel();
    $this->variantModel = new ProductVariantModel();
  }

  public function login()
  {
    return view('admin/login');
  }

  public function auth()
  {
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $admin = $this->adminModel->where('username', $username)->first();

    if ($admin && $password === $admin['password']) {
      $this->session->set([
        'isAdminLoggedIn' => true,
        'adminId' => $admin['id'],
        'adminName' => $admin['name']
      ]);
      return redirect()->to('/admin/dashboard');
    }

    return redirect()->back()->with('error', 'Invalid credentials');
  }

  public function dashboard()
  {
    $data = [
      'title' => 'Dashboard',
      'totalProducts' => $this->productModel->countAll(),
      'totalCategories' => $this->categoryModel->countAll(),
      'totalVariants' => $this->variantModel->countAll()
    ];
    return view('admin/dashboard', $data);
  }

  public function logout()
  {
    $this->session->destroy();
    return redirect()->to('/admin/login');
  }

  public function categories()
  {
    $data = [
      'title' => 'Categories',
      'categories' => $this->categoryModel->findAll()
    ];
    return view('admin/categories', $data);
  }

  public function addCategory()
  {
    $data = [
      'name' => $this->request->getPost('name'),
      'description' => $this->request->getPost('description')
    ];
    $this->categoryModel->insert($data);
    return redirect()->to('/admin/categories')->with('success', 'Category added successfully');
  }

  public function editCategory($id)
  {
    $data = [
      'name' => $this->request->getPost('name'),
      'description' => $this->request->getPost('description')
    ];

    $this->categoryModel->update($id, $data);
    return redirect()->to('/admin/categories')->with('success', 'Category updated successfully');
  }

  public function checkRelations($id)
  {
    $products = $this->productModel->where('category_id', $id)->findAll();

    return $this->response->setJSON([
      'hasRelations' => !empty($products),
      'products' => $products
    ]);
  }

  public function deleteCategory($id)
  {
    // Double check for related products
    $products = $this->productModel->where('category_id', $id)->findAll();

    if (!empty($products)) {
      return redirect()->to('/admin/categories')
        ->with('error', 'Cannot delete category. Please delete related products first.');
    }

    $this->categoryModel->delete($id);
    return redirect()->to('/admin/categories')->with('success', 'Category deleted successfully');
  }

  public function products()
  {
    $data = [
      'title' => 'Products',
      'products' => $this->productModel->select('products.*, categories.name as category_name')
        ->join('categories', 'categories.id = products.category_id')
        ->findAll(),
      'categories' => $this->categoryModel->findAll(),
      'variants' => $this->variantModel->findAll() // Tambahkan ini
    ];

    // Menyusun variants berdasarkan product_id
    $productVariants = [];
    foreach ($data['variants'] as $variant) {
      $productVariants[$variant['product_id']][] = $variant;
    }
    $data['productVariants'] = $productVariants;

    return view('admin/products', $data);
  }

  public function addProduct()
  {
    // Validasi input terlebih dahulu
    if (!$this->validate([
      'category_id' => 'required',
      'name' => 'required',
      'description' => 'required',
      'image_m' => 'uploaded[image_m]|is_image[image_m]'
    ])) {
      return redirect()->back()->withInput()->with('error', 'Please check your input');
    }

    try {
      // Handle main product image
      $image = $this->request->getFile('image_m');
      if ($image->isValid() && !$image->hasMoved()) {
        $imageName = $image->getRandomName();
        $image->move('uploads/products', $imageName);
      } else {
        return redirect()->back()->withInput()->with('error', 'Problem with main image upload');
      }

      // Insert product
      $productData = [
        'category_id' => $this->request->getPost('category_id'),
        'name' => $this->request->getPost('name'),
        'description' => $this->request->getPost('description'),
        'image_m' => $imageName
      ];
      $productId = $this->productModel->insert($productData);

      // Handle variants
      $sizes = $this->request->getPost('size[]') ?? [];
      $prices = $this->request->getPost('price[]') ?? [];
      $stocks = $this->request->getPost('stock[]') ?? [];
      $variantImages = $this->request->getFiles('variant_image');

      // Pastikan arrays memiliki jumlah yang sama
      $variantCount = count($sizes);

      for ($i = 0; $i < $variantCount; $i++) {
        if (!empty($sizes[$i]) && !empty($prices[$i]) && !empty($stocks[$i])) {
          $variantImageName = null;

          // Handle variant image if exists
          if (
            isset($variantImages['variant_image']) &&
            isset($variantImages['variant_image'][$i]) &&
            $variantImages['variant_image'][$i]->isValid()
          ) {

            $variantImage = $variantImages['variant_image'][$i];
            $variantImageName = $variantImage->getRandomName();
            $variantImage->move('uploads/variants', $variantImageName);
          }

          $this->variantModel->insert([
            'product_id' => $productId,
            'size' => $sizes[$i],
            'price' => $prices[$i],
            'stock' => $stocks[$i],
            'image' => $variantImageName
          ]);
        }
      }

      return redirect()->to('/admin/products')->with('success', 'Product added successfully');
    } catch (\Exception $e) {
      return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
    }
  }

  public function getProductVariants($productId)
  {
    header('Content-Type: application/json');
    try {
      $variants = $this->variantModel->findByProductId($productId);
      return $this->response->setJSON($variants);
    } catch (\Exception $e) {
      log_message('error', 'Error getting variants: ' . $e->getMessage());
      return $this->response->setStatusCode(500)
        ->setJSON(['error' => $e->getMessage()]);
    }
  }
  public function editProduct($id)
  {
    // Validasi input
    if (!$this->validate([
      'category_id' => 'required',
      'name' => 'required',
      'description' => 'required'
    ])) {
      return redirect()->back()->withInput()->with('error', 'Please check your input');
    }

    try {
      // Handle main product image if uploaded
      $image = $this->request->getFile('image_m');
      $imageName = null;

      if ($image && $image->isValid() && !$image->hasMoved()) {
        $imageName = $image->getRandomName();
        $image->move('uploads/products', $imageName);

        // Delete old image
        $oldProduct = $this->productModel->find($id);
        if ($oldProduct['image_m'] && file_exists('uploads/products/' . $oldProduct['image_m'])) {
          unlink('uploads/products/' . $oldProduct['image_m']);
        }
      }

      // Update product
      $productData = [
        'category_id' => $this->request->getPost('category_id'),
        'name' => $this->request->getPost('name'),
        'description' => $this->request->getPost('description')
      ];

      if ($imageName) {
        $productData['image_m'] = $imageName;
      }

      $this->productModel->update($id, $productData);

      // Handle variants
      $variantIds = $this->request->getPost('variant_id') ?? [];
      $sizes = $this->request->getPost('size') ?? [];
      $prices = $this->request->getPost('price') ?? [];
      $stocks = $this->request->getPost('stock') ?? [];
      $variantImages = $this->request->getFiles()['variant_image'] ?? [];

      foreach ($sizes as $i => $size) {
        if (!empty($size) && !empty($prices[$i]) && !empty($stocks[$i])) {
          $variantData = [
            'size' => $size,
            'price' => $prices[$i],
            'stock' => $stocks[$i]
          ];

          // Handle variant image if uploaded
          if (isset($variantImages[$i]) && $variantImages[$i]->isValid()) {
            $variantImageName = $variantImages[$i]->getRandomName();
            $variantImages[$i]->move('uploads/variants', $variantImageName);
            $variantData['image'] = $variantImageName;
          }

          if (!empty($variantIds[$i])) {
            // Update existing variant
            $this->variantModel->update($variantIds[$i], $variantData);
          } else {
            // Insert new variant
            $variantData['product_id'] = $id;
            $this->variantModel->insert($variantData);
          }
        }
      }
      $deletedVariants = $this->request->getPost('deleted_variants') ?? [];
      foreach ($deletedVariants as $variantId) {
        // Hapus gambar variant jika ada
        $variant = $this->variantModel->find($variantId);
        if ($variant && $variant['image'] && file_exists('uploads/variants/' . $variant['image'])) {
          unlink('uploads/variants/' . $variant['image']);
        }
        // Hapus variant dari database
        $this->variantModel->delete($variantId);
      }

      return redirect()->to('/admin/products')->with('success', 'Product updated successfully');
    } catch (\Exception $e) {
      return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
    }
  }

  public function deleteProduct($id)
  {
    try {
      // Get product details
      $product = $this->productModel->find($id);

      // Delete main product image
      if ($product['image_m'] && file_exists('uploads/products/' . $product['image_m'])) {
        unlink('uploads/products/' . $product['image_m']);
      }

      // Get and delete all variant images
      $variants = $this->variantModel->where('product_id', $id)->findAll();
      foreach ($variants as $variant) {
        if ($variant['image'] && file_exists('uploads/variants/' . $variant['image'])) {
          unlink('uploads/variants/' . $variant['image']);
        }
      }

      // Delete product (variants will be deleted automatically due to foreign key constraint)
      $this->productModel->delete($id);

      return redirect()->to('/admin/products')->with('success', 'Product deleted successfully');
    } catch (\Exception $e) {
      return redirect()->to('/admin/products')->with('error', 'Error deleting product: ' . $e->getMessage());
    }
  }
}
