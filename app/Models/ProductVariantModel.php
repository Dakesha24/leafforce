<?php namespace App\Models;
use CodeIgniter\Model;

class ProductVariantModel extends Model {
    protected $table = 'product_variants';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'size', 'price', 'stock', 'image'];
    protected $returnType = 'array';
}