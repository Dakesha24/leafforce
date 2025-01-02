<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductVariantModel;

class Home extends BaseController
{
    public function index()
    {
        return view('landing');
    }

    public function content()
    {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $variantModel = new ProductVariantModel();
        // Join dengan categories dan subquery untuk mendapatkan min/max price dan total stock
        $products = $productModel->select('
                products.*, 
                categories.name as category_name,
                (SELECT MIN(price) FROM product_variants WHERE product_variants.product_id = products.id) as min_price,
                (SELECT MAX(price) FROM product_variants WHERE product_variants.product_id = products.id) as max_price,
                (SELECT SUM(stock) FROM product_variants WHERE product_variants.product_id = products.id) as total_stock
            ')
            ->join('categories', 'categories.id = products.category_id')
            ->findAll();

        return view('home', ['products' => $products]);
    }
}
