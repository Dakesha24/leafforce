<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductVariantModel;

class Product extends BaseController
{
    public function detail($productName)
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $variantModel = new ProductVariantModel();

        // Ambil data produk
        $product = $productModel->where('name', urldecode($productName))->first();

        if (!$product) {
            return redirect()->to('/');
        }

        // Ambil data kategori
        $category = $categoryModel->find($product['category_id']);

        // Ambil semua varian produk
        $variants = $variantModel->where('product_id', $product['id'])
            ->orderBy('size', 'ASC')
            ->findAll();

        $data = [
            'product' => $product,
            'category' => $category,
            'variants' => $variants,
            'variantId' => $this->request->getGet('variant_id')
        ];

        return view('product_detail', $data);
    }
}
