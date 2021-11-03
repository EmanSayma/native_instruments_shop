<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends AppRepository
{
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function findProductBySku($sku)
    {
        return $this->model->where('sku', $sku)->first();
    }
}