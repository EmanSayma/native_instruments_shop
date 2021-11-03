<?php

namespace App\Repositories;

use App\Models\Purchase;

class PurchaseRepository extends AppRepository
{
    protected $model;
    
    public function __construct(Purchase $model)
    {
        $this->model = $model;
    }

    public function findByUserAndProductSku($userId, $productSku)
    {
        return $this->model->where([
            ['user_id', '=', $userId],
            ['product_sku', '=', $productSku]
        ]);
    }
}